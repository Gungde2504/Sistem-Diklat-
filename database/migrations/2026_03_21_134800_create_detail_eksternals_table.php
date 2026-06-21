<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_eksternals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user')->unique(); // relasi 1:1
            $table->enum('jenis', ['pkl', 'magang', 'orientasi']);
            $table->string('institusi', 200);
            $table->uuid('id_unit');
            $table->unsignedBigInteger('id_supervisor')->nullable();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->enum('status', ['aktif', 'selesai', 'tidak_lanjut'])->default('aktif');
            $table->string('cert_qr_token', 100)->unique()->nullable();
            $table->string('cert_file_path', 255)->nullable();
            $table->unsignedBigInteger('created_by');
            $table->timestamps();

            $table->foreign('id_unit')->references('id')->on('m_units');
            $table->index('cert_qr_token');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_eksternals');
    }
};