<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('elearning_modules', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 200);
            $table->text('deskripsi')->nullable();
            $table->longText('konten')->nullable();
            $table->string('kategori', 100)->nullable();
            $table->string('file_path', 255)->nullable();
            $table->string('link_video', 500)->nullable();
            $table->decimal('estimasi_durasi_jam', 4, 2)->default(1);
            $table->decimal('min_quiz_score', 5, 2)->nullable();
            $table->char('id_target_unit', 36)->nullable();
            $table->tinyInteger('publish')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('publish');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('elearning_modules');
    }
};