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
        Schema::create('listing_sale_details', function (Blueprint $table) {
            $table->foreignId('listing_id')->constrained()->cascadeOnDelete();
            $table->primary('listing_id');
            $table->enum('ownership_type', ['single', 'joint']);
            $table->enum('facing_direction', [
                'north', 'south', 'east', 'west',
                'north_east', 'north_west', 'south_east', 'south_west',
            ]);
            $table->enum('condition', ['new', 'used']);
            $table->unsignedTinyInteger('property_age_years')->nullable();
            $table->enum('completion_status', ['ready', 'under_construction']);
            $table->date('handover_date')->nullable();
            $table->boolean('negotiable')->default(false);
            $table->enum('registration_cost_by', ['buyer', 'seller', 'shared']);
            $table->string('floor_plan_image')->nullable();
            $table->string('video_url')->nullable();
            $table->timestamps();

            $table->index('condition');
            $table->index('property_age_years');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listing_sale_details');
    }
};