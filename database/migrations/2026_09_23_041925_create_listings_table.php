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
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('area_id')->constrained()->restrictOnDelete();
            $table->enum('listing_type',['rent','sale']);
            $table->string('title', 150);
            $table->string('slug',180)->unique();
            $table->text('description');
            $table->string('address', 255);
            $table->string('building_name',120)->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->unsignedInteger(('size_sqft'));
            $table->unsignedTinyInteger('bedrooms');
            $table->unsignedTinyInteger('bathrooms');
            $table->unsignedTinyInteger('balconies')->nullable();
            $table->unsignedTinyInteger('floor_no');
            $table->unsignedTinyInteger('total_floors');

            // Monthly rent when listing_type is rent; total price when it is sale.
            $table->decimal('price',12,2);
            $table->enum('gas_connection',['none','shared','individual'])->default('none');
            $table->enum('electricity_meter',['shared','individual'])->default('shared');
            $table->boolean('water_reserve')->default(false);
            $table->text('additional_notes')->nullable();
            $table->enum('status',['draft','available','rented','sold','inactive'])->default('draft');
            $table->boolean('is_featured')->default(false);
            $table->date('featured_until')->nullable();
            $table->unsignedInteger('view_count')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // The filter every search applies.
            $table->index(['status','listing_type','area_id'],'listings_search_index');
            // Price range plus sort.
            $table->index(['status','listing_type','price'],'listings_price_index');
            $table->index('bedrooms');
            $table->index('size_sqft');
            $table->index('published_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};