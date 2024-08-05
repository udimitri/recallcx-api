<?php

namespace App\Http\Controllers;

use App\Domain\DTOs\BroadcastDto;
use App\Domain\Messenger\Messages\TestBroadcastMessage;
use App\Domain\Messenger\Messenger;
use App\Domain\Twilio\LookupClient;
use App\Http\Requests\CreateBroadcastRequest;
use App\Http\Requests\SendTestBroadcastRequest;
use App\Models\Broadcast;
use App\Models\Business;
use App\Models\Contact;
use App\Models\Enums\BroadcastStatus;
use App\Models\Enums\ContactType;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Inertia\Response;

class BroadcastController extends Controller
{
    public function __construct(
        private LookupClient $lookupClient,
        private Messenger $messenger
    ) {
    }

    public function list(Request $request): Response
    {
        $business = Business::first();
        return Inertia::render('Broadcasts/Broadcasts', [
            'paginatedBroadcasts' => $business->broadcasts()
                ->orderByDesc('created_at')
                ->jsonPaginate()
                ->through(fn (Broadcast $broadcast) => BroadcastDto::fromBroadcast($broadcast)),
        ]);
    }

    public function create(Request $request): Response
    {
        $business = Business::first();

        return Inertia::render('Broadcasts/Create/CreateBroadcast', [
            'business' => [
                'name' => $business->name,
                'address' => $business->address,
                'logo' => $business->logo,
                'owner' => [
                    'first_name' => $business->business_owner?->first_name,
                ]
            ],
        ]);
    }

    public function success(Broadcast $broadcast): Response
    {
        return Inertia::render('Broadcasts/Create/BroadcastCreated', [
            'broadcast' => $broadcast
        ]);
    }

    public function store(CreateBroadcastRequest $request): RedirectResponse
    {
        $business = Business::first();

        $broadcast = $business->broadcasts()->create([
            'status' => BroadcastStatus::Created,
            'subject' => $request->input('subject'),
            'message' => $request->input('message'),
            'send_at' => (new Carbon($request->input('send_at'), "America/Edmonton"))->utc()
        ]);

        return Redirect::route('broadcasts.success', [ $broadcast ]);
    }

    public function sendTestMessage(SendTestBroadcastRequest $request)
    {
        Session::flash('success', 'Test message sent successfully.');

        return ;

        $business = Business::first();

        $formatted_phone_number = $this->lookupClient->format($request->input('phone_number'));

        $email_contact = Contact::build($business, ContactType::Email, $request->input('email_address'), return_existing: true);
        $phone_contact = Contact::build($business, ContactType::Phone, $formatted_phone_number, return_existing: true);

        $message = new TestBroadcastMessage(
            $request->input('subject'),
            $request->input('message')
        );

        $this->messenger->send($email_contact, $message);
        $this->messenger->send($phone_contact, $message);

    }
}
