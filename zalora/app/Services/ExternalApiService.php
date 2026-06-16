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
            // Attempt to log in and try again
            $this->auth->login();

            $response = $this->send($method, $url, $data);

            if ($response->status() === 401) {
                return response()->json([
                    'message' => 'External API auth failed'
                ], 401);
            }
        }

        // Try to decode JSON safely
        $body = $response->body();
        $json = json_decode($body, true);

        // If body failed to parse to JSON
        $finalResponse = is_array($json) ? $json : [
            'raw' => $body
        ];

        return response()
            ->json($finalResponse, $response->status())
            ->withHeaders([
                'Content-Type' => 'application/json',
            ]);
    }

    private function send($method, $url, $data = [])
    {
        $method = strtolower($method);

        $request = Http::baseUrl(config('services.external.base_url'))
            ->withToken($this->auth->token())
            ->acceptJson()
            ->timeout(10);

        return match ($method) {
            'get' => $request->get($url, $data),

            'delete' => $request->withBody(
                    json_encode($data),
                )->delete($url),

            'put' => $request->withBody(
                    json_encode($data),
                )->put($url),

            'patch' => $request->withBody(
                    json_encode($data),
                )->patch($url),

            default => $request->asJson()->post($url, $data),
        };
    }
}
