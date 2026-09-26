<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('reviews')) {
            $hasUniqueReviewIndex = false;

            foreach (Schema::getIndexes('reviews') as $index) {
                if (($index['unique'] ?? false) && $index['columns'] === ['user_id', 'listing_id']) {
                    $hasUniqueReviewIndex = true;
                    break;
                }
            }

            if (! $hasUniqueReviewIndex) {
                Schema::table('reviews', function (Blueprint $table): void {
                    $table->unique(['user_id', 'listing_id']);
                });
            }

            $hasVisitRequestForeignKey = false;

            foreach (Schema::getForeignKeys('reviews') as $foreignKey) {
                if ($foreignKey['columns'] === ['visit_request_id'] && $foreignKey['foreign_table'] === 'visit_request') {
                    $hasVisitRequestForeignKey = true;
                    break;
                }
            }

            if (! $hasVisitRequestForeignKey) {
                Schema::table('reviews', function (Blueprint $table): void {
                    $table->foreign('visit_request_id')->references('id')->on('visit_request')->nullOnDelete();
                });
            }

            return;
        }

        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('visit_request_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedTinyInteger('rating');
            $table->text('comment')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'listing_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
