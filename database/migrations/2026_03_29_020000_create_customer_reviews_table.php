<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_reviews', function (Blueprint $table): void {
            $table->id();
            $table->string('reviewer_name');
            $table->text('review_text');
            $table->string('source');
            $table->string('source_label')->nullable();
            $table->dateTime('reviewed_at')->nullable();
            $table->dateTime('imported_at')->nullable();
            $table->json('metadata')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_reviews');
    }
};
