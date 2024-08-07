<?php

namespace App\Console\Commands;

use App\Domain\Messenger\Messages\ReviewRequestMessage;
use App\Domain\Messenger\Messenger;
use App\Models\Contact;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendReviewRequests extends Command
{
    protected $signature = 'app:send-review-requests';

    protected $description = 'Send outstanding review requests.';

    public function handle(Messenger $messenger)
    {
        $three_hours_ago = Carbon::now()->subHours(3);

        $targets = Contact::query()
            ->whereNull('review_request_sent_at')
            ->whereNull('unsubscribed_at')
            ->where('created_at', '<', $three_hours_ago)
            ->get();

        $this->info("Found {$targets->count()} target(s) requiring review requests!");

        foreach ($targets as $target) {
            $target->review_request_sent_at = Carbon::now();
            $target->save();

            try {
                $messenger->send($target, new ReviewRequestMessage());
            } catch (\Throwable $throwable) {
                report($throwable);
            }

            $this->info("Sent review request for contact #{$target->id} on {$target->channel->value}.");
        }

        $this->info("Completed send review request!");
    }
}
