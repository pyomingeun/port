<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Billing\PaymentGateway;
use App\Containers\SMS\SmsService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PaymentGateway::class, function ($app) {
            return new PaymentGateway(
                env('INI_CURRENCY', 'WON'),
                env('INI_ENVIRONMENT', 'test'),
                env('INI_MID', 'INIpayTest'),
                env('INI_SIGN_KEY', 'SU5JTElURV9UUklQTEVERVNfS0VZU1RS'),
                env('INI_RETURN_URL', 'http://localhost:8000/payment/complete'),
                env('INI_CANCEL_URL', 'http://localhost:8000/payment/cancel'),
                env('INI_VERSION', '1.0')
            );
        });

        $this->app->singleton(SmsService::class, function ($app) {
            return new SmsService(
                env('NAVER_SMS_URL'),
                env('NAVER_ACCESS_KEY_ID'),
                env('NAVER_SECRET_KEY'),
                env('NAVER_SENDER'),
                env('NAVER_SERVICE_ID')
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
