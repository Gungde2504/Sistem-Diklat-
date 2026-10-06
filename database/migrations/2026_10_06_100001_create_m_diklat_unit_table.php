<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('m_diklat_unit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_diklat')->constrained('m_diklats')->cascadeOnDelete();
            $table->uuid('id_unit');
            $table->foreign('id_unit')->references('id')->on('m_units')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['id_diklat', 'id_unit']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('m_diklat_unit');
    }
};
