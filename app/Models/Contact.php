<?php

namespace App\Models;

use App\Domain\Transports\EmailTransport;
use App\Domain\Transports\SmsTransport;
use App\Domain\Transports\Transport;
use App\Domain\Twilio\SmsClient;
use App\Domain\Twilio\TwilioSmsClient;
use App\Exceptions\ContactAlreadyExistsException;
use App\Models\Enums\ContactType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Twilio\Rest\Client as TwilioClient;

class Contact extends Model
{

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'channel' => ContactType::class
        ];
    }

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }

    public static function build(
        Business $business,
        ContactType $type,
        string $value
    ): self {
        $payload = [
            'channel' => $type,
            'value' => $value,
        ];

        if ($business->contacts()->where($payload)->exists()) {
            throw new ContactAlreadyExistsException();
        }

        return $business->contacts()->create($payload);
    }

    public function unsubscribe(): void
    {
        UnsubscribeLog::fromContact($this);

        $this->delete();
    }

    public function transport(): Transport
    {
        return match ($this->channel) {
            ContactType::Phone => new SmsTransport(resolve(SmsClient::class), $this),
            ContactType::Email => new EmailTransport($this)
        };
    }
}
