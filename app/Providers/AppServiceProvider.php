<?php

namespace App\Providers;

use App\Domain\Clerk\ClerkApi;
use App\Domain\Clerk\ClerkGuard;
use App\Domain\Clerk\ClerkProvider;
use App\Domain\Messenger\LiveMessenger;
use App\Domain\Messenger\Messenger;
use App\Domain\Twilio\LookupClient;
use App\Domain\Twilio\SmsClient;
use App\Domain\Twilio\TwilioLookupClient;
use App\Domain\Twilio\TwilioSmsClient;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        $this->app->bind(Messenger::class, function (Application $app) {
            return new LiveMessenger(
                $app->make(SmsClient::class)
            );
        });

        $this->app->bind(ClerkApi::class, function (Application $app) {
            return new ClerkApi(
                config('services.clerk.token'),
            );
        });

        Auth::extend('clerk', function (Application $app, $name, array $config) {
            return new ClerkGuard(
                $app->make(ClerkApi::class),
                $app->make(Request::class)
            );
        });

        Auth::provider('clerk-provider', function () {
            return new ClerkProvider();
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
