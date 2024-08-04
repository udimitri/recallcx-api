<?php

namespace App\Providers;

use App\Domain\Google\LivePlacesApi;
use App\Domain\Google\PlacesApi;
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


        $this->app->bind(PlacesApi::class, function (Application $app) {
            return new LivePlacesApi(
                config('services.google.key')
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
