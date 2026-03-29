<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoice_records', function (Blueprint $table): void {
            $table->id();
            $table->string('reference')->unique();
            $table->string('status', 40)->default('awaiting payment');
            $table->date('invoice_date');
            $table->date('due_date');
            $table->string('job_address', 255);
            $table->string('client_name', 120);
            $table->decimal('total_due', 10, 2)->default(0);
            $table->string('last_action', 40)->default('saved');
            $table->string('public_pdf_path')->nullable();
            $table->json('payload')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();

            $table->index(['status', 'invoice_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_records');
    }
};
