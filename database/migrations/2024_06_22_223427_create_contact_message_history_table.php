<?php

use App\Models\Broadcast;
use App\Models\Contact;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contact_message_history', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Contact::class)->constrained();
            $table->string('message_type');
            $table->foreignIdFor(Broadcast::class)->nullable()->constrained();
            $table->text('subject')->nullable();
            $table->text('message');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_message_history');
    }
};
