<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\BusinessIncentive;
use App\Models\BusinessOwner;
use App\Models\Enums\IncentiveType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $business = Business::create([
            'slug' => 'circularchic',
            'name' => 'CHIC Circular Fashion',
            'google_review_url' => 'https://g.page/r/CRMi-N-HNuIEEBM/review',
            'place_id' => 'ChIJ-9T48SoioFMREyL434c24gQ',
        ]);

        BusinessOwner::create([
            'business_id' => $business->id,
            'first_name' => 'Mel',
            'phone_number' => '+17804511562'
        ]);

        BusinessIncentive::create([
            'business_id' => $business->id,
            'type' => IncentiveType::Amount,
            'value' => '5',
        ]);
    }
}
