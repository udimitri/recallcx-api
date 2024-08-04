<?php

use App\Domain\Reporting\Last30Change\AudienceLast30Change;
use App\Domain\Reporting\Last30Change\ReviewsLast30Change;
use App\Domain\Reporting\Last7Report\AudienceLast7Report;
use App\Domain\Reporting\Last7Report\ReviewsLast7Report;
use App\Http\Controllers\ProfileController;
use App\Models\Business;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    $business = Business::first();
    return Inertia::render('Dashboard', [
        'business' => [
            'name' => $business->name,
            'address' => $business->address,
        ],
        'audience' => [
            'count' => $business->contacts()->count(),
            'change' => (new AudienceLast30Change($business))->get(),
            'last7' => (new AudienceLast7Report($business))->get(),
        ],
        'reviews' => [
            'count' => $business->ratings()->latest()->first()?->review_count,
            'change' =>(new ReviewsLast30Change($business))->get(),
            'last7' => (new ReviewsLast7Report($business))->get(),
        ]
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
