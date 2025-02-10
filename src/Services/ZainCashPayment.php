<?php

namespace TheJano\ZainCash\Services;

use TheJano\ZainCash\Contracts\PaymentGateway;
use TheJano\ZainCash\Http\HttpClient;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;
use TheJano\ZainCash\Http\LaravelHttpClient;

class ZainCashPayment implements PaymentGateway
{
    private HttpClient $httpClient;
    private string $secret;
    private string $merchantId;
    private string $msisdn;
    private string $language;
    private string $environment;
    private string $baseUrl;
    private bool $shouldRedirect;
    private string $redirectUrl;
    private string $prefixOrderId;
    private static ?ZainCashPayment $instance = null;

    public function __construct(HttpClient $httpClient)
    {
        $config = config('zaincash');
        $this->secret = $config['secret'];
        $this->merchantId = $config['merchant_id'];
        $this->msisdn = $config['msisdn'];
        $this->language = $config['language'];
        $this->environment = $config['environment'];
        $this->baseUrl = $this->environment === 'production' ? $config['production_url'] : $config['staging_url'];
        $this->shouldRedirect = $config['should_redirect'];
        $this->redirectUrl = $config['redirect_url'];
        $this->prefixOrderId = $config['prefix_order_id'];
        $this->httpClient = $httpClient;
    }

    public static function make(): ZainCashPayment
    {
        if (self::$instance === null) {
            self::$instance = new self(new LaravelHttpClient());
        }
        return self::$instance;
    }

    public function initiatePayment(string $orderId, float $amount, string $serviceType, ?string $redirectUrl = null): array
    {
        $data = [
            'amount' => $amount,
            'serviceType' => $serviceType,
            'orderId' => $this->prefixOrderId . $orderId,
        ];

        if ($this->shouldRedirect) {
            $data['redirectUrl'] = $redirectUrl ?? $this->redirectUrl;
        }

        $token = $this->generateToken($data);

        return $this->httpClient->post("{$this->baseUrl}/transaction/init", [
            'token' => $token,
            'merchantId' => $this->merchantId,
            'lang' => $this->language,
        ]);
    }

    public function verifyPayment(string $token): ?array
    {
        try {
            return (array)JWT::decode($token, new Key($this->secret, 'HS256'));
        } catch (Exception $e) {
            return null;
        }
    }

    public function checkTransaction(string $transactionId): array
    {
        $token = $this->generateToken(['id' => $transactionId, 'msisdn' => $this->msisdn]);

        return $this->httpClient->post("{$this->baseUrl}/transaction/get", [
            'token' => $token,
            'merchantId' => $this->merchantId,
        ]);
    }

    public function getPaymentUrl(string $transactionId): string
    {
        return "{$this->baseUrl}/transaction/pay?id={$transactionId}";
    }

    private function generateToken(array $data): string
    {
        $data['msisdn'] = $this->msisdn;
        $data['iat'] = time();
        $data['exp'] = time() + 60 * 60 * 4;

        return JWT::encode($data, $this->secret, 'HS256');
    }

    public static function decodeToken(string $token, string $secret): ?array
    {
        try {
            return (array)JWT::decode($token, new Key($secret, 'HS256'));
        } catch (Exception $e) {
            return null;
        }
    }
}