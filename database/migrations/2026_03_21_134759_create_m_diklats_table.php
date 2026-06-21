<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('m_diklats', function (Blueprint $table) {
            $table->id();
            $table->string('img')->nullable();
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->string('namaNarasumber');
            $table->string('jenisDiklat');
            $table->string('tglJamMulai');
            $table->string('tglJamSelesai');
            $table->string('tempat');
            $table->string('durasi');
            $table->integer('kuota')->default(0);
            $table->tinyInteger('publish')->default(0);
            $table->string('slug')->unique()->nullable();
            $table->string('status')->default('Draft');
            $table->string('linkPretest')->nullable();
            $table->string('linkPosttest')->nullable();
            $table->string('QRcode', 100)->unique()->nullable();
            $table->tinyInteger('IsActive')->default(0);
            $table->timestamps();
            $table->softDeletes();

            // Index
            $table->index('QRcode');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('m_diklats');
    }
};