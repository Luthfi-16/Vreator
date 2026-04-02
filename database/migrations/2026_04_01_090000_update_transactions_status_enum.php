<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE transactions MODIFY status ENUM('pending', 'paid', 'failed') NOT NULL DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("UPDATE transactions SET status = 'pending' WHERE status = 'failed'");
        DB::statement("ALTER TABLE transactions MODIFY status ENUM('pending', 'paid') NOT NULL DEFAULT 'pending'");
    }
};
