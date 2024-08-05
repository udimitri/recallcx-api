<?php

use App\Domain\DTOs\ContactDto;
use App\Domain\DTOs\ReviewRequestDto;
use App\Domain\Reporting\Last30Change\AudienceLast30Change;
use App\Domain\Reporting\Last30Change\ReviewsLast30Change;
use App\Domain\Reporting\Last7Report\AudienceLast7Report;
use App\Domain\Reporting\Last7Report\ReviewsLast7Report;
use App\Http\Controllers\ProfileController;
use App\Models\Business;
use App\Models\Contact;
use App\Models\Enums\ContactType;
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
            'change' => (new ReviewsLast30Change($business))->get(),
            'last7' => (new ReviewsLast7Report($business))->get(),
        ]
    ]);
})->middleware([ 'auth', 'verified' ])->name('dashboard');

Route::get('/reviews', function () {
    $business = Business::first();
    return Inertia::render('Reviews/Reviews', [
        'business' => [
            'name' => $business->name,
            'address' => $business->address,
            'rating' => $business->ratings()->latest()->first()?->rating,
            'review_count' => $business->ratings()->latest()->first()?->review_count,
        ],
        'last7' => (new ReviewsLast7Report($business))->get(),
        'paginatedContacts' => $business
            ->contacts()
            ->whereNotNull('review_request_sent_at')
            ->orderByDesc('review_request_sent_at')
            ->jsonPaginate()
            ->through(fn (Contact $contact) => ReviewRequestDto::fromContact($contact)),
    ]);
})->middleware([ 'auth', 'verified' ])->name('reviews');

Route::get('/broadcasts', [\App\Http\Controllers\BroadcastController::class, 'list'])->middleware([ 'auth' ])->name('broadcasts');
Route::get('/broadcasts/create', [\App\Http\Controllers\BroadcastController::class, 'create'])->middleware([ 'auth' ])->name('broadcasts.create');
Route::post('/broadcasts', [\App\Http\Controllers\BroadcastController::class, 'store'])->middleware([ 'auth' ])->name('broadcasts.store');
Route::get('/broadcasts/{broadcast}/created', [\App\Http\Controllers\BroadcastController::class, 'success'])->middleware([ 'auth' ])->name('broadcasts.success');
Route::post('/broadcasts/send-test', [\App\Http\Controllers\BroadcastController::class, 'sendTestMessage'])->middleware([ 'auth' ])->name('broadcasts.send-test');

Route::get('/audience', function () {
    $business = Business::first();
    return Inertia::render('Audience/Audience', [
        'metrics' => [
            'subscribed' => $business->contacts()->whereNull('unsubscribed_at')->count(),
            'email' => $business->contacts()->whereNull('unsubscribed_at')->where('channel',
                ContactType::Email)->count(),
            'phone' => $business->contacts()->whereNull('unsubscribed_at')->where('channel',
                ContactType::Phone)->count(),
            'unsubscribed' => $business->contacts()->whereNotNull('unsubscribed_at')->count(),
        ],
        'last7' => (new AudienceLast7Report($business))->get(),
        'paginatedContacts' => $business->contacts()
            ->orderByDesc('created_at')
            ->jsonPaginate()
            ->through(fn (Contact $contact) => ContactDto::fromContact($contact)),
    ]);
})->middleware([ 'auth', 'verified' ])->name('audience');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ ProfileController::class, 'edit' ])->name('profile.edit');
    Route::patch('/profile', [ ProfileController::class, 'update' ])->name('profile.update');
    Route::delete('/profile', [ ProfileController::class, 'destroy' ])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
