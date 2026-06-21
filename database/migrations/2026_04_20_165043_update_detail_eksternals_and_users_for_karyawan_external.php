<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah kolom alamat di users
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'alamat')) {
                $table->string('alamat', 255)->nullable()->after('hp');
            }
        });

        // Update detail_eksternals
        Schema::table('detail_eksternals', function (Blueprint $table) {
            // Tambah kolom baru
            if (!Schema::hasColumn('detail_eksternals', 'vendor')) {
                $table->string('vendor', 100)->nullable()->after('institusi');
            }
            if (!Schema::hasColumn('detail_eksternals', 'approval_status')) {
                $table->enum('approval_status', ['pending', 'approved', 'rejected'])
                      ->default('approved')
                      ->after('status');
            }
            if (!Schema::hasColumn('detail_eksternals', 'approval_note')) {
                $table->text('approval_note')->nullable()->after('approval_status');
            }
            if (!Schema::hasColumn('detail_eksternals', 'approved_by')) {
                $table->unsignedBigInteger('approved_by')->nullable()->after('approval_note');
            }
            if (!Schema::hasColumn('detail_eksternals', 'approved_at')) {
                $table->timestamp('approved_at')->nullable()->after('approved_by');
            }
            // id_unit nullable untuk karyawan external
            $table->uuid('id_unit')->nullable()->change();
            // tanggal_mulai & tanggal_selesai nullable untuk karyawan external
            $table->date('tanggal_mulai')->nullable()->change();
            $table->date('tanggal_selesai')->nullable()->change();
        });

        // Update ENUM jenis & status
        \DB::statement("ALTER TABLE detail_eksternals MODIFY COLUMN jenis ENUM(
            'pkl','magang','orientasi',
            'karyawan_iss','karyawan_bss','karyawan_adidaya',
            'karyawan_bayi_tabung','karyawan_koperasi','karyawan_lotus_spa'
        )");

        \DB::statement("ALTER TABLE detail_eksternals MODIFY COLUMN status ENUM(
            'aktif','selesai','tidak_lanjut','tidak_aktif'
        ) DEFAULT 'aktif'");
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('alamat');
        });
        Schema::table('detail_eksternals', function (Blueprint $table) {
            $table->dropColumn(['vendor','approval_status','approval_note','approved_by','approved_at']);
        });
    }
};