<?php

namespace App\Models;

use App\Domain\Google\PlacesApi;
use App\Domain\Google\PlacesRatingData;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RatingHistory extends Model
{

    protected $guarded = [];

    protected $table = 'rating_history';

    protected $casts = [
        'date' => 'date',
    ];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public static function build(Business $business, Carbon $date, PlacesRatingData $data): self
    {
        return $business->ratings()->create([
            'date' => $date,
            'rating' => $data->rating,
            'review_count' => $data->review_count,
        ]);
    }
}
