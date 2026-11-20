<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Slot kini bisa berisi sesi: "11-15" (pagi) atau "11-15-m" (malam)
    public function up(): void
    {
        Schema::table('pengingat_jam_logs', function (Blueprint $table) {
            $table->string('slot', 8)->change();
        });
    }

    public function down(): void
    {
        Schema::table('pengingat_jam_logs', function (Blueprint $table) {
            $table->string('slot', 5)->change();
        });
    }
};
