<?php

namespace App\Http\Controllers\Webhook;

use App\Domain\Twilio\Twilio;
use App\Models\Business;
use App\Models\Enums\ContactType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Twilio\TwiML\MessagingResponse;

class TwilioWebhookController
{
    public function receive(Request $request): Response
    {
        $account_sid = $request->input('AccountSid');
        $phone_number = $request->input('From');
        $message = $request->input('Body');

        if (!$account_sid || !$phone_number || !$message) {
            Log::error('Unexpected webhook received from Twilio - missing account_sid, phone_number or message', [
                'payload' => $request->all()
            ]);

            abort(404);
        }

        $business = Business::findByTwilioId($account_sid);

        if (!$business) {
            Log::error('Unexpected webhook received from Twilio - unknown business', [
                'payload' => $request->all()
            ]);

            abort(404);
        }

        if (Twilio::isStopWord($message)) {
            $contact = $business->contacts()
                ->where('channel', ContactType::Phone)
                ->where('value', $phone_number)
                ->first();

            if (!$contact) {
                Log::error('Unexpected webhook received from Twilio - unknown contact', [
                    'payload' => $request->all()
                ]);

                abort(404);
            }

            $contact->unsubscribe();
        }

        return response(new MessagingResponse())
            ->header('Content-Type', 'text/xml');
    }
}
