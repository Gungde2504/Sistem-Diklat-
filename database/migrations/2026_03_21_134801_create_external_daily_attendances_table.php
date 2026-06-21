<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('external_daily_attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->date('tanggal');
            $table->timestamp('checkin_at')->nullable();
            $table->timestamp('checkout_at')->nullable();
            $table->enum('mode', ['online', 'offline'])->default('online');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->tinyInteger('is_valid')->default(0);
            $table->string('device_info', 255)->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();

            // Satu absensi per user per hari
            $table->unique(['id_user', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('external_daily_attendances');
    }
};