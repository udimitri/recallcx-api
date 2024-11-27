<?php

namespace App\Console\Commands;

use App\Domain\Messenger\Messages\TestBroadcastMessage;
use App\Domain\Messenger\Messenger;
use App\Domain\Twilio\LookupClient;
use App\Models\Broadcast;
use App\Models\Business;
use App\Models\Contact;
use App\Models\Enums\BroadcastStatus;
use App\Models\Enums\ContactType;
use Carbon\Carbon;
use Illuminate\Console\Command;

class FixBug extends Command
{
    protected $signature = 'fix-bug';

    protected $description = 'Fix bug';

    public function handle(LookupClient $lookupClient, Messenger $messenger)
    {
        $broadcast = Broadcast::find(7);
        $business = $broadcast->business;

        $contacts = [
            '+17802937193',
            '+17806604518',
            '+17808600830',
            '+12506992992',
            '+15877121105',
            '+17809077161',
            '+17806996857',
            '+17802178503',
            '+17809951171',
            '+17807293309',
            '+17806897881',
            '+17788790983',
            '+17807082378',
            '+17808603919',
            '+17802938524',
            '+17802931636',
            '+17809994217',
            '+18259934141',
            '+17802922389',
            '+17806043719',
            '+17782296142',
            '+17809084780',
            '+17802971191',
            '+17807006666',
            '+16475379291',
            '+17809641061',
            '+18259755111',
            '+17809539226',
        ];

        foreach($contacts as $contact) {
            $contact = $business
                ->contacts()
                ->where([
                    'channel' => ContactType::Phone,
                    'value' => $contact,
                ])
                ->first();
            info($contact->id);
        }
    }
}
