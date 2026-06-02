<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ExternalApiService
{
    public function __construct(
        private ExternalApiAuthService $auth
    ) {}

    public function get($url, $query = [])
    {
        return $this->request('GET', $url, $query);
    }

    public function post($url, $data = [])
    {
        return $this->request('POST', $url, $data);
    }

    public function request($method, $url, $data = [])
    {
        $response = $this->send($method, $url, $data);

        if ($response->status() === 401) {
            $this->auth->refresh();
            $response = $this->send($method, $url, $data);

            if ($response->status() === 401) {
                abort(401, 'External API auth failed');
            }
        }

        return response(
            $response->body(),
            $response->status()
        )->header('Content-Type', 'application/json');
    }

    private function send($method, $url, $data = [])
    {
        $method = strtolower($method);

        $request = Http::withToken($this->auth->token())
            ->baseUrl(config('services.external.base_url'));

        return match ($method) {
            'get' => $request->get($url, $data),
            'delete' => $request->delete($url, $data),
            'put' => $request->put($url, $data),
            'patch' => $request->patch($url, $data),
            default => $request->post($url, $data),
        };
    }
}
