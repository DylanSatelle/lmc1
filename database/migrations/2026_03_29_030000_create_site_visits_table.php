<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_visits', function (Blueprint $table): void {
            $table->id();
            $table->string('path', 255);
            $table->dateTime('visited_at')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_visits');
    }
};
