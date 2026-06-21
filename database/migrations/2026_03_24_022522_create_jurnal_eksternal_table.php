<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jurnal_eksternals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
            $table->date('tanggal');
            $table->text('aktivitas');
            $table->text('kendala')->nullable();
            $table->text('rencana_besok')->nullable();
            $table->timestamps();

            $table->unique(['id_user', 'tanggal']);
            $table->index('id_user');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jurnal_eksternals');
    }
};