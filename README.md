# ZainCash Laravel SDK

## Introduction
ZainCash Laravel is a PHP SDK designed to integrate the ZainCash payment gateway with Laravel applications seamlessly. This package provides an easy-to-use interface for initiating and verifying payments.

## Installation
You can install the package via Composer:

```sh
composer require thejano/zaincash-laravel
```

## Configuration

After installing the package, publish the configuration file using:

```sh
php artisan vendor:publish --provider="ZainCash\Providers\ZainCashPaymentServiceProvider"
```

This will create a `config/zaincash.php` file where you can set your credentials.


Add your credentials in your `.env` file:

```env
ZAINCASH_SECRET=your_secret_key
ZAINCASH_MERCHANT_ID=your_merchant_id
ZAINCASH_MSISDN=your_phone_number
ZAINCASH_ENV=staging
ZAINCASH_REDIRECT_URL=https://yourdomain.com/payment/callback
ZAINCASH_PREFIX_ORDER_ID=ORD_
```

## Usage

### Initiate a Payment

You can initiate a payment using the `ZainCashPayment` facade:

```php
use TheJano\ZainCash\Facades\ZainCashPayment;

$response = ZainCashPayment::initiatePayment(
    orderId: '12345',
    amount: 1000.00,
    serviceType: 'purchase',
    redirectUrl: 'https://yourdomain.com/payment/success'
);

$transactionId = $response['id'];
$paymentUrl = ZainCashPayment::getPaymentUrl($transactionId);

return redirect($paymentUrl);
```

### Verify a Payment

```php
use TheJano\ZainCash\Facades\ZainCashPayment;

$token = request('token');
$paymentData = ZainCashPayment::verifyPayment($token);

if ($paymentData) {
    // Payment is successful
} else {
    // Payment failed
}
```

### Check Transaction Status

```php
use TheJano\ZainCash\Facades\ZainCashPayment;

$transactionId = 'some_transaction_id';
$transactionStatus = ZainCashPayment::checkTransaction($transactionId);
```

## Service Provider & Facade
The package registers `ZainCashPaymentServiceProvider` automatically. It also provides a facade `ZainCashPayment` for convenient usage.

## License
This package is open-sourced software licensed under the [MIT license](LICENSE).