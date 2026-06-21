<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        \DB::statement("ALTER TABLE external_daily_attendances MODIFY COLUMN mode ENUM('online', 'offline', 'gps', 'manual') DEFAULT 'gps'");
    }

    public function down(): void
    {
        \DB::statement("ALTER TABLE external_daily_attendances MODIFY COLUMN mode ENUM('online', 'offline') DEFAULT 'online'");
    }
};