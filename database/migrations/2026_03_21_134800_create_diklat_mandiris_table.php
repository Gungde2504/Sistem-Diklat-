<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diklat_mandiris', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama', 255);
            $table->string('jenisDiklat', 255)->default('Diklat Mandiri');
            $table->string('tglJamMulai', 255);
            $table->string('tglJamSelesai', 255);
            $table->string('tempat', 255);
            $table->string('durasi', 255); // menit
            $table->string('sertifikat', 255); // path file
            $table->string('materi', 255)->nullable();
            $table->unsignedBigInteger('id_user');
            $table->string('status', 20)->default('pending');
            $table->timestamps();

            $table->index(['id_user', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diklat_mandiris');
    }
};