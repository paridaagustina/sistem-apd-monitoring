<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        // Akun Admin
        User::updateOrCreate(
            ['email' => 'admin@apd.test'],
            [
                'name' => 'Administrator',
                'password' => 'AdminAPD123!',
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Akun Pekerja Lapangan
        User::updateOrCreate(
            ['email' => 'pekerja@apd.test'],
            [
                'name' => 'Pekerja Lapangan',
                'password' => 'PekerjaAPD123!',
                'role' => 'pekerja_lapangan',
                'email_verified_at' => now(),
            ]
        );
    }
}