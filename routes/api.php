<?php

use App\Http\Controllers\BusinessController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\TwilioWebhookController;
use Illuminate\Support\Facades\Route;

Route::post('/webhook/twilio', [ TwilioWebhookController::class, 'receive' ]);

Route::get('/businesses/{business:slug}', [ BusinessController::class, 'get' ]);

Route::post('/businesses/{business:slug}/contacts', [ ContactController::class, 'store' ]);
Route::post('/businesses/{business:slug}/contacts/unsubscribe', [ ContactController::class, 'unsubscribe' ]);
