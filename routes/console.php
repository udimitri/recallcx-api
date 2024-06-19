<?php

use App\Console\Commands\SendReviewRequests;
use Illuminate\Support\Facades\Schedule;

Schedule::command(SendReviewRequests::class)->everyFifteenMinutes();
