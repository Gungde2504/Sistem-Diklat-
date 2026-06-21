<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin
        User::create([
            'type'     => 'internal',
            'role'     => 'super_admin',
            'name'     => 'Super Admin',
            'nama'     => 'Super Admin',
            'nip'      => '000001',
            'email'    => 'superadmin@diklat.com',
            'password' => Hash::make('password'),
            'isActive' => 1,
        ]);

        // Admin Diklat
        User::create([
            'type'     => 'internal',
            'role'     => 'admin_diklat',
            'name'     => 'Admin Diklat',
            'nama'     => 'Admin Diklat',
            'nip'      => '000002',
            'email'    => 'admin@diklat.com',
            'password' => Hash::make('password'),
            'isActive' => 1,
        ]);

        // Pegawai
        User::create([
            'type'     => 'internal',
            'role'     => 'pegawai',
            'name'     => 'Budi Santoso',
            'nama'     => 'Budi Santoso',
            'nip'      => '100001',
            'email'    => 'budi@diklat.com',
            'password' => Hash::make('password'),
            'unit'     => 'keperawatan',
            'isActive' => 1,
        ]);

        // Peserta Eksternal
        User::create([
            'type'     => 'external',
            'role'     => 'peserta_eksternal',
            'name'     => 'Siti Rahayu',
            'nama'     => 'Siti Rahayu',
            'nip'      => null,
            'email'    => 'siti@mahasiswa.com',
            'password' => Hash::make('password'),
            'isActive' => 1,
        ]);
    }
}