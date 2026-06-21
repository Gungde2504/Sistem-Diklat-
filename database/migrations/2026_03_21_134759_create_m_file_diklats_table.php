<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('m_file_diklats', function (Blueprint $table) {
            $table->id();
            $table->string('file');
            $table->enum('type', ['foto', 'materi', 'sertifikat', 'template_sertifikat']);
            $table->string('nomor_sertifikat')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreignId('id_diklat')->constrained('m_diklats')->cascadeOnDelete();
            $table->timestamps();

            $table->index(['id_diklat', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('m_file_diklats');
    }
};