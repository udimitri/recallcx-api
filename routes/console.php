<?php

use App\Console\Commands\FetchRatingInformation;
use App\Console\Commands\SendReviewRequests;
use Illuminate\Support\Facades\Schedule;

Schedule::command(SendReviewRequests::class)
    ->everyFifteenMinutes()
    ->onOneServer();

Schedule::command(FetchRatingInformation::class)
    ->dailyAt('23:00')
    ->onOneServer();
