<?php
namespace TheJano\ZainCash\Http;

use Illuminate\Support\Facades\Http;
use Exception;

class LaravelHttpClient implements HttpClient {
    public function post(string $url, array $data): array {
        $response = Http::asForm()->post($url, $data);
        if ($response->failed()) {
            throw new Exception('Request failed: ' . $response->body());
        }
        return $response->json();
    }
}
