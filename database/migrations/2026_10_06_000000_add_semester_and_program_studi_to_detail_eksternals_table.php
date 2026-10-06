<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detail_eksternals', function (Blueprint $table) {
            $table->string('program_studi', 150)->nullable()->after('institusi');
            $table->unsignedTinyInteger('semester')->nullable()->after('program_studi');
        });
    }

    public function down(): void
    {
        Schema::table('detail_eksternals', function (Blueprint $table) {
            $table->dropColumn(['program_studi', 'semester']);
        });
    }
};
