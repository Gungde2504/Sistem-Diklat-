<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('record_absensi_diklats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->foreignId('id_diklat')->constrained('m_diklats')->cascadeOnDelete();
            $table->string('namaPeserta');
            $table->integer('durasi')->default(0); // menit
            $table->date('date');
            $table->boolean('is_hadir')->default(false);
            $table->timestamps();

            // Unique: satu user hanya bisa absen sekali per acara
            $table->unique(['id_user', 'id_diklat']);
            $table->index(['id_diklat', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('record_absensi_diklats');
    }
};