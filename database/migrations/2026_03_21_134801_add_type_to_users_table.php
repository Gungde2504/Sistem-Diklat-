<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('type', 20)->default('internal')->after('id');
            $table->string('role', 30)->default('pegawai')->after('type');
            $table->string('nip', 50)->nullable()->unique()->after('name');
            $table->string('nama', 150)->nullable()->after('nip');
            $table->string('unit', 100)->nullable()->after('nama');
            $table->string('profesi', 100)->nullable()->after('unit');
            $table->string('jabatan', 100)->nullable()->after('profesi');
            $table->string('hp', 20)->nullable()->after('jabatan');
            $table->tinyInteger('isActive')->default(1)->after('hp');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['type','role','nip','nama','unit','profesi','jabatan','hp','isActive']);
        });
    }
};