<?php

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
        Schema::create('visit_request', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained()->cascadeOnDelete();
            $table->foreignId('seeker_id')->constrained('users')->cascadeOnDelete();
            $table->date('preferred_date');
            $table->enum('preferred_slot', ['morning', 'afternoon', 'evening']);
            $table->text('message')->nullable();
            $table->enum('status', [
                'pending', 'accepted', 'declined', 'rescheduled', 'cancelled', 'completed',
            ])->default('pending');
            $table->date('proposed_date')->nullable();
            $table->enum('proposed_slot', ['morning', 'afternoon', 'evening'])->nullable();
            $table->text('owner_note')->nullable();
            $table->timestamp('responded_at')->nullable();

            $table->index(['listing_id', 'status']);
            $table->index(['seeker_id', 'status']);
            // Makes the "one pending request per seeker per listing" check cheap.
            $table->index(['listing_id', 'seeker_id', 'status']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visit_request');
    }
};