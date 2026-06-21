<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detail_eksternals', function (Blueprint $table) {
            if (!Schema::hasColumn('detail_eksternals', 'cert_qr_token')) {
                $table->string('cert_qr_token')->nullable()->after('status');
            }
            if (!Schema::hasColumn('detail_eksternals', 'cert_file_path')) {
                $table->string('cert_file_path')->nullable()->after('cert_qr_token');
            }
            if (!Schema::hasColumn('detail_eksternals', 'cert_back_path')) {
                $table->string('cert_back_path')->nullable()->after('cert_file_path');
            }
            if (!Schema::hasColumn('detail_eksternals', 'nilai_akhir')) {
                $table->decimal('nilai_akhir', 5, 2)->nullable()->after('cert_back_path');
            }
        });
    }

    public function down(): void
    {
        Schema::table('detail_eksternals', function (Blueprint $table) {
            $table->dropColumn(['cert_qr_token', 'cert_file_path', 'cert_back_path', 'nilai_akhir']);
        });
    }
};