<?php

namespace App\Console\Commands;

use App\Domain\Google\PlacesApi;
use App\Models\Business;
use App\Models\RatingHistory;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Prompts\Progress;
use function Laravel\Prompts\progress;
use function Laravel\Prompts\info;

class FetchRatingInformation extends Command
{
    protected $signature = 'app:fetch-rating-information';

    protected $description = 'Fetch and store rating information for businesses.';

    public function handle(PlacesApi $placesApi): void
    {
        $targets = Business::query()
            ->whereDoesntHave('ratings', function (Builder $builder) {
                $builder->whereDate('date', Carbon::now());
            })
            ->get();

        if (!$targets->count()) {
            info("Everything is up-to-date. Nothing to do...");
            return;
        }

        progress(
            label: 'Fetching & storing rating information',
            steps: $targets,
            callback: function (Business $business, Progress $progress) use ($placesApi) {
                $progress->hint($business->name);

                RatingHistory::build(
                    business: $business,
                    date: Carbon::now(),
                    data: $placesApi->ratingData($business)
                );
            }
        );
    }
}
