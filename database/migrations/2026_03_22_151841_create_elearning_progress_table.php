<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('elearning_progress', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->foreignId('id_modul')->constrained('elearning_modules')->cascadeOnDelete();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->decimal('quiz_score', 5, 2)->nullable();
            $table->enum('status', ['in_progress', 'completed', 'failed'])->default('in_progress');
            $table->decimal('jam_dikontribusikan', 4, 2)->default(0);
            $table->timestamps();

            $table->unique(['id_user', 'id_modul']);
            $table->index(['id_user', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('elearning_progress');
    }
};