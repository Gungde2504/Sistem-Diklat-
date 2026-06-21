<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('elearning_quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_modul')->constrained('elearning_modules')->cascadeOnDelete();
            $table->text('pertanyaan');
            $table->text('pilihan_a');
            $table->text('pilihan_b');
            $table->text('pilihan_c')->nullable();
            $table->text('pilihan_d')->nullable();
            $table->char('jawaban_benar', 1);
            $table->timestamps();

            $table->index('id_modul');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('elearning_quizzes');
    }
};