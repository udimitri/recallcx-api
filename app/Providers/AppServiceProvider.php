<?php

namespace App\Providers;

use App\Domain\Twilio\LookupClient;
use App\Domain\Twilio\TwilioLookupClient;
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
        $this->app->bind(TwilioClient::class, function () {
            return new TwilioClient(
                config('services.twilio.primary_sid'),
                config('services.twilio.auth_token'),
            );
        });

        $this->app->singleton(LookupClient::class, function (Application $app) {
            return new TwilioLookupClient($app->make(TwilioClient::class));
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
