<?php

namespace App\Providers;

use App\Domain\Twilio\LookupClient;
use App\Domain\Twilio\SmsClient;
use App\Domain\Twilio\TwilioLookupClient;
use App\Domain\Twilio\TwilioSmsClient;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Twilio\Rest\Client as TwilioClient;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // perhaps use API keys?
        $this->app->bind(SmsClient::class, function (Application $app) {
            return new TwilioSmsClient(
                config('services.twilio.primary_sid'),
                config('services.twilio.auth_token'),
            );
        });

        $this->app->singleton(LookupClient::class, function (Application $app) {
            return new TwilioLookupClient(
                config('services.twilio.primary_sid'),
                config('services.twilio.auth_token'),
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
