<?php

use App\Http\Controllers\BusinessController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TwilioWebhookController;
use Illuminate\Support\Facades\Route;

// kiosk
Route::post('/webhook/twilio', [ TwilioWebhookController::class, 'receive' ]);

Route::get('/kiosk/businesses/{business:slug}', [ BusinessController::class, 'get' ]);

Route::post('/kiosk/businesses/{business:slug}/contacts', [ ContactController::class, 'store' ]);
Route::post('/kiosk/businesses/{business:slug}/contacts/unsubscribe', [ ContactController::class, 'unsubscribe' ]);

// app
Route::get('/dashboard/businesses/{business:slug}/stats', [ DashboardController::class, 'stats' ]);
Route::get('/dashboard/businesses/{business:slug}/chart', [ DashboardController::class, 'chart' ]);
