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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 20)->unique()->after('email');
            $table->enum('account_type',['owner','seeker'])->default('seeker')->after('phone');
            $table->string('profile_photo')->nullable()->after('account_type');
            $table->boolean('is_active')->default(true)->after('profile_photo');

            $table->index('account_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['account_type']);
            $table->dropColumn(['phone','account_type','profile_photo','is_active']);
            
        });
    }
};