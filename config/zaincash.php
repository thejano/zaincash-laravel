<?php
return [
    'msisdn' => env('ZAINCASH_MSISDN', '9647835077893'),
    'merchant_id' => env('ZAINCASH_MERCHANT_ID', '5ffacf6612b5777c6d44266f'),
    'secret' => env('ZAINCASH_SECRET', '$2y$10$hBbAZo2GfSSvyqAyV2SaqOfYewgYpfR1O19gIh4SqyGWdmySZYPuS'),
    'environment' => env('ZAINCASH_ENVIRONMENT', 'staging'),
    'staging_url' => env('ZAINCASH_STAGING_URL', 'https://test.zaincash.iq'),
    'production_url' => env('ZAINCASH_PRODUCTION_URL', 'https://api.zaincash.iq'),
    'language' => env('ZAINCASH_LANGUAGE', 'ar'),
    'prefix_order_id' => env('ZAINCASH_PREFIX_ORDER_ID', 'myshop_'),
    'should_redirect' => env('ZAINCASH_SHOULD_REDIRECT', true),
    'redirect_url' => env('ZAINCASH_REDIRECT_URL', 'https://yourwebsite.com/payment/callback'),
];
