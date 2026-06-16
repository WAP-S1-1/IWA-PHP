<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ExternalApiAuthService
{
    /**
     * Get a valid access token (auto-refresh if needed)
     */
    public function token(): string
    {
        if ($this->hasValidToken()) {
            return Cache::get('external.access_token');
        }

        return $this->login();
    }

    /**
     * Check if token is still valid locally
     */
    private function hasValidToken(): bool
    {
        return Cache::has('external.access_token')
            && Cache::has('external.expires_at')
            && Cache::get('external.expires_at') > now()->addMinute();
    }

    /**
     * Perform login (first time or full re-auth)
     */
    public function login(): string
    {
        error_log(config('services.external.base_url') . '/login');
        $response = Http::asForm()
            ->post(config('services.external.base_url') . '/login', [
                'email' => config('services.external.email'),
                'password' => config('services.external.password'),
            ])
            ->throw()
            ->json();


        return $this->storeTokenResponse($response);
    }

    /**
     * Store token data consistently
     */
    private function storeTokenResponse(array $response): string
    {
        Cache::put(
            'external.access_token',
            $response['token'],
        );

        if (isset($response['refresh_token'])) {
            Cache::put('external.refresh_token', $response['refresh_token']);
        }

        return $response['token'];
    }
}
