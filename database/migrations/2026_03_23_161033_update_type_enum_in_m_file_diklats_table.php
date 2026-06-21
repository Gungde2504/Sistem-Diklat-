<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Update enum untuk tambah nilai template_sertifikat
        DB::statement("ALTER TABLE m_file_diklats MODIFY COLUMN type ENUM('foto', 'materi', 'sertifikat', 'template_sertifikat')");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE m_file_diklats MODIFY COLUMN type ENUM('foto', 'materi', 'sertifikat')");
    }
};