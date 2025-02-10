<?php
namespace TheJano\ZainCash\Providers;

use Illuminate\Support\ServiceProvider;
use TheJano\ZainCash\Services\ZainCashPayment;
use TheJano\ZainCash\Http\LaravelHttpClient;

class ZainCashPaymentServiceProvider extends ServiceProvider {
    public function boot() {
        $this->publishes([
            __DIR__ . '/../../config/zaincash.php' => config_path('zaincash.php'),
        ], 'config');
    }

    public function register() {
        $this->mergeConfigFrom(__DIR__ . '/../../config/zaincash.php', 'zaincash');

        $this->app->singleton('zaincashPayment', function ($app) {
            return ZainCashPayment::make();
        });
    }
}
