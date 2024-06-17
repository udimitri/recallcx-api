<?php

namespace App\Providers;

use App\Domain\Twilio\LookupClient;
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
        $this->app->bind(TwilioClient::class, function () {
            return new TwilioClient(
                config('services.twilio.key'),
                config('services.twilio.secret'),
            );
        });

        $this->app->singleton(LookupClient::class, function (Application $app) {
            return new LookupClient($app->make(TwilioClient::class));
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
