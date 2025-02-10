<?php
namespace TheJano\ZainCash\Facades;

use Illuminate\Support\Facades\Facade;

class ZainCashPayment extends Facade {
    protected static function getFacadeAccessor() {
        return 'zaincashPayment';
    }
}
