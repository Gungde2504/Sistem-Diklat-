<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('m_diklats', function (Blueprint $table) {
            $table->enum('kategori', ['medis', 'non_medis'])->nullable()->after('jenisDiklat');
        });
    }

    public function down(): void
    {
        Schema::table('m_diklats', function (Blueprint $table) {
            $table->dropColumn('kategori');
        });
    }
};
