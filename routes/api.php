<?php

use App\Http\Controllers\App\BroadcastController;
use App\Http\Controllers\App\DashboardController;
use App\Http\Controllers\Kiosk\BusinessController;
use App\Http\Controllers\Kiosk\ContactController;
use App\Http\Controllers\Kiosk\ReviewRecoveryController;
use App\Http\Controllers\Webhook\TwilioWebhookController;
use Illuminate\Support\Facades\Route;

// kiosk
Route::post('/webhook/twilio', [ TwilioWebhookController::class, 'receive' ]);

Route::get('/kiosk/businesses/{business:slug}', [ BusinessController::class, 'get' ]);

Route::post('/kiosk/businesses/{business:slug}/review-recovery', [ ReviewRecoveryController::class, 'store' ]);

Route::post('/kiosk/businesses/{business:slug}/contacts', [ ContactController::class, 'store' ]);
Route::post('/kiosk/businesses/{business:slug}/contacts/unsubscribe', [ ContactController::class, 'unsubscribe' ]);

// app
Route::get('/app/businesses/{business:slug}/stats', [ DashboardController::class, 'stats' ]);
Route::get('/app/businesses/{business:slug}/chart', [ DashboardController::class, 'chart' ]);
Route::post('/app/businesses/{business:slug}/broadcasts', [ BroadcastController::class, 'store' ]);
