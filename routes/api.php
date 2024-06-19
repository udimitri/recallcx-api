<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\TwilioWebhookController;
use Illuminate\Support\Facades\Route;

Route::post('/webhook/twilio', [ TwilioWebhookController::class, 'receive' ]);

Route::post('/businesses/{business}/contacts', [ ContactController::class, 'store' ]);
Route::post('/businesses/{business}/contacts/unsubscribe', [ ContactController::class, 'unsubscribe' ]);
