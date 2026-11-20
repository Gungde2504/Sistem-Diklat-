<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengingat_jam_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user')->index();
            $table->unsignedSmallInteger('tahun');
            $table->string('slot', 5);              // format MM-DD, mis. "11-15"
            $table->decimal('jam_saat_ini', 6, 2)->default(0);
            $table->decimal('target_jam', 6, 2)->default(0);
            $table->boolean('email_terkirim')->default(false);
            $table->timestamp('dikirim_at')->nullable();
            $table->timestamps();

            // Satu pengingat per pegawai per tahap per tahun (mencegah kirim ganda)
            $table->unique(['id_user', 'tahun', 'slot']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengingat_jam_logs');
    }
};
