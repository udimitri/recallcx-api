<?php

use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

Route::post('/businesses/{business}/contacts', [ ContactController::class, 'store' ]);
