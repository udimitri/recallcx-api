<?php

use App\Http\Controllers\App\BroadcastController;
use App\Http\Controllers\App\BusinessIncentiveController;
use App\Http\Controllers\App\ContactController;
use App\Http\Controllers\App\DashboardController;
use App\Http\Controllers\App\MessageHistoryController;
use App\Http\Controllers\Kiosk\KioskBusinessController;
use App\Http\Controllers\Kiosk\KioskContactController;
use App\Http\Controllers\Kiosk\ReviewRecoveryController;
use App\Http\Controllers\Webhook\TwilioWebhookController;
use App\Http\Middleware\BusinessAuth;
use Illuminate\Foundation\Http\Middleware\TrimStrings;
use Illuminate\Support\Facades\Route;

// kiosk
Route::group([ 'prefix' => 'kiosk' ], function () {
    Route::get('/businesses/{business:slug}', [ KioskBusinessController::class, 'get' ]);

    Route::post('/businesses/{business:slug}/review-recovery', [ ReviewRecoveryController::class, 'store' ]);

    Route::post('/businesses/{business:slug}/contacts', [ KioskContactController::class, 'store' ]);
    Route::post('/businesses/{business:slug}/contacts/unsubscribe', [ KioskContactController::class, 'unsubscribe' ]);

});

// app
Route::group([ 'prefix' => 'app', 'middleware' => [ 'auth:clerk', BusinessAuth::class ] ], function () {
    Route::get('/businesses/{business:slug}/dashboard', [ DashboardController::class, 'dashboard' ]);

    Route::withoutMiddleware([ TrimStrings::class])->group(function () {
        Route::post('/businesses/{business:slug}/broadcasts', [ BroadcastController::class, 'store' ]);
        Route::post('/businesses/{business:slug}/broadcasts/send-test', [ BroadcastController::class, 'sendTestMessage' ]);
    });

    Route::get('/businesses/{business:slug}/broadcasts/{broadcast}', [ BroadcastController::class, 'get' ]);

    Route::get('/businesses/{business:slug}/contacts', [ ContactController::class, 'list' ]);
    Route::get('/businesses/{business:slug}/review-requests', [ ContactController::class, 'reviewRequestHistory' ]);
    Route::get('/businesses/{business:slug}/messages', [ MessageHistoryController::class, 'list' ]);

    Route::put('/businesses/{business:slug}/incentive', [ BusinessIncentiveController::class, 'update' ]);
});

Route::post('/webhook/twilio', [ TwilioWebhookController::class, 'receive' ]);
