<?php

use App\Models\Business;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('review_recoveries', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Business::class)->constrained();
            $table->string('email_address');
            $table->text('message');
            $table->timestamps();
        });
    }
};
