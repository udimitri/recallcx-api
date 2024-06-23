<?php

namespace App\Jobs;

use App\Models\Broadcast;
use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendBroadcast implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private Broadcast $broadcast,
        private Contact $contact
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $transport = $this->contact->transport();

        $transport->sendBroadcast($this->broadcast);

    }
}
