<?php

namespace App\Console\Commands;

use App\Jobs\SendBroadcast;
use App\Models\Broadcast;
use App\Models\Enums\BroadcastStatus;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class QueueReadyBroadcasts extends Command
{
    protected $signature = 'app:queue-ready-broadcasts';

    protected $description = 'Queue outstanding broadcasts for sending.';

    public function handle()
    {
        DB::transaction(function () {
            $targets = Broadcast::query()
                ->where('send_at', '<', now())
                ->where('status', BroadcastStatus::Created)
                ->lockForUpdate()
                ->get();

            $this->info("Found {$targets->count()} broadcasts(s) ready for sending!");

            foreach ($targets as $target) {
//                $target->business->contacts->chunk(100, function($contacts) use ($target) {
//                    foreach ($contacts as $contact) {
//                        // dispatch(new SendBroadcast($target, $contact))->afterCommit();
//                    }
//                });

                $target->status = BroadcastStatus::Finished;
                $target->save();

                $this->info("Queued broadcast #{$target->id} for sending.");
            }

            $this->info("Completed queue ready broadcasts!");
        });
    }
}
