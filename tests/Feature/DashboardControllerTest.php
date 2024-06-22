<?php

use App\Models\Business;
use App\Models\Contact;
use App\Models\Enums\ContactType;
use Carbon\Carbon;

describe('it can generate dashboard stats', function () {

    it('can generate audience chart stats', function (Business $business) {
        Carbon::setTestNow("2024-06-01 10:00 UTC");
        Contact::build($business, ContactType::Email, 'dimitri+test1@recallcx.com');
        Contact::build($business, ContactType::Email, 'dimitri+test2@recallcx.com');

        Carbon::setTestNow("2024-06-03 10:00 UTC");
        Contact::build($business, ContactType::Email, 'dimitri+test3@recallcx.com');
        Contact::build($business, ContactType::Email, 'dimitri+test4@recallcx.com');

        // should still be counted as June 3 in Mountain Time
        Carbon::setTestNow("2024-06-04 02:00 UTC");
        Contact::build($business, ContactType::Email, 'dimitri+test5@recallcx.com');

        // Should be counted as June 5
        Carbon::setTestNow("2024-06-06 00:00 UTC");
        Contact::build($business, ContactType::Email, 'dimitri+test6@recallcx.com');

        // it's still June 6 in Mountain Time
        // so we should report on May 31 - Jun 6
        Carbon::setTestNow("2024-06-07 00:00 UTC");

        $this->getJson("/api/businesses/{$business->slug}/dashboard/chart")
            ->assertOk()
            ->assertJson([
                "data" => [
                    [ "day" => "May 31", "count" => 0 ],
                    [ "day" => "Jun 1", "count" => 2 ],
                    [ "day" => "Jun 2", "count" => 0 ],
                    [ "day" => "Jun 3", "count" => 3 ],
                    [ "day" => "Jun 4", "count" => 0 ],
                    [ "day" => "Jun 5", "count" => 1 ],
                    [ "day" => "Jun 6", "count" => 0 ],
                ]
            ]);
    })->with('business');
});
