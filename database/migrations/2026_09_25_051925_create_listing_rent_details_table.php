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
        Schema::create('listing_rent_details', function (Blueprint $table) {
             $table->foreignId('listing_id')->constrained()->cascadeOnDelete();
            $table->primary('listing_id');
            $table->unsignedTinyInteger('advance_months')->nullable();
            $table->decimal('service_charge', 10, 2)->nullable();
            $table->boolean('utility_included')->default(false);
            $table->enum('tenant_preference', ['family', 'bachelor', 'sublet', 'any'])->default('any');
            $table->enum('furnished_status', ['unfurnished', 'semi', 'full'])->default('unfurnished');
            $table->date('available_from')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listing_rent_details');
    }
};