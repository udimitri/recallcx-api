<?php

namespace App\Mail;

use App\Domain\Base64URL;
use App\Models\Business;
use Illuminate\Mail\Mailables\Address;

class TenantEmailConfiguration
{
    public function __construct(
        private Business $business,
    ) {
    }

    public static function for(Business $business)
    {
        return new self($business);
    }

    public function from(): Address
    {
        return new Address(
            "updates@{$this->business->slug}.onrecallcx.com",
            "{$this->business->business_owner->first_name} from {$this->business->name}"
        );
    }

    public function unsubscribeUrl(string $contact_email_address): string
    {
        $encoded_email = Base64URL::encode($contact_email_address);

        return "https://{$this->business->slug}.onrecallcx.com/unsubscribe?email={$encoded_email}";
    }
}
