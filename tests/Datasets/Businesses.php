<?php

use App\Models\Business;
use App\Models\BusinessIncentive;
use App\Models\BusinessOwner;
use App\Models\Enums\IncentiveType;

dataset('business', [
    function () {
        $business = Business::build('biz-a', 'Business A', [
            'twilio_account_id' => 'test',
            'twilio_messaging_service_id' => 'test',
            'google_review_url' => 'https://google.com/test'
        ]);

        BusinessOwner::build($business, 'Ted', [
            'phone_number' => '+17809103702'
        ]);

        BusinessIncentive::build($business, IncentiveType::Amount, '5');

        return $business;
    }
]);
