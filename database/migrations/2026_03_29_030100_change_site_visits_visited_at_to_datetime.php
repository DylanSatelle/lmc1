<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE site_visits MODIFY visited_at DATETIME NOT NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE site_visits MODIFY visited_at TIMESTAMP NOT NULL');
    }
};
