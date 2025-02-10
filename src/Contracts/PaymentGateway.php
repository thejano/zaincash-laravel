<?php
namespace TheJano\ZainCash\Contracts;

interface PaymentGateway {
    public function initiatePayment(string $orderId, float $amount, string $serviceType, ?string $redirectUrl = null): array;
    public function verifyPayment(string $token): ?array;
    public function checkTransaction(string $transactionId): array;
}
