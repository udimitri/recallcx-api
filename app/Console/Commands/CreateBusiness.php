<?php

namespace App\Console\Commands;

use App\Models\Business;
use Illuminate\Console\Command;
use function Laravel\Prompts\form;
use function Laravel\Prompts\info;

class CreateBusiness extends Command
{
    protected $signature = 'app:create-business';

    protected $description = 'Create a new business.';

    public function handle()
    {
        $responses = form()
            ->text('What is the business name?', required: true, name: 'name')
            ->text('What slug would you like?', required: true, name: 'slug')
            ->text('What is the Google review URL?', required: true, name: 'google_review_url')
            ->text('What is the Google place ID?', required: true, name: 'place_id')
            ->text('What is the address?', required: true, name: 'address')
            ->text('What is the business owner\'s first name?', required: true, name: 'first_name')
            ->text('What is the business owner\'s phone number?', required: true, name: 'phone_number')
            ->submit();

        $business = Business::build($responses['slug'], $responses['name'], [
            'google_review_url' => $responses['google_review_url'],
            'place_id' => $responses['place_id'],
            'address' => $responses['address'],
        ]);

        $business->business_owner()->create([
            'first_name' => $responses['first_name'],
            'phone_number' => $responses['phone_number']
        ]);

        info("Business created!");
    }
}
