<?php

namespace App\Console\Commands;

use App\Models\Broadcast;
use App\Models\Contact;
use Illuminate\Console\Command;
use function Laravel\Prompts\search;
use function Laravel\Prompts\table;

class PreviewBroadcastAudience extends Command
{
    protected $signature = 'app:preview-broadcast-audience';

    protected $description = 'Previews the audience for a given broadcast.';

    public function handle()
    {
        $broadcast_id = search(
            "Which broadcast?",
            function (string $value) {
                if (strlen($value) > 0) {
                    return Broadcast::where('subject', 'like', "%{$value}%")
                        ->get()
                        ->mapWithKeys(
                            fn (Broadcast $broadcast) => [
                                $broadcast->id => "[{$broadcast->id}] {$broadcast->subject}"
                            ]
                        )
                        ->all();
                }

                return [];
            }
        );

        $broadcast = Broadcast::find($broadcast_id);
        $audience = $broadcast->audience()->get();

        info("This broadcast will send to {$audience->count()} contacts.");

        table(
            [ 'Contact' ],
            $audience->map(fn (Contact $contact) => [ $contact->value ])->toArray()
        );
    }
}
