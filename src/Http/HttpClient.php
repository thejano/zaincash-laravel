<?php
namespace TheJano\ZainCash\Http;

interface HttpClient {
    public function post(string $url, array $data): array;
}
