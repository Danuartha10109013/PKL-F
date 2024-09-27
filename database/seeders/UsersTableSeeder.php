<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'username' => 'hc',
                'name' => 'hc hc hc',
                'role' => '0',
                'active' => '0',
                'no_pegawai' => 'EMP001',
                'profile' => null,
                'email' => 'hc@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('hc'), // Encrypting the password
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'pegawai',
                'name' => 'pegawai pegawai',
                'role' => '1',
                'active' => '1',
                'no_pegawai' => 'EMP002',
                'profile' => null,
                'email' => 'pegawai@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('pegawai'),
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'kapro',
                'name' => 'kapro kapro',
                'role' => '2',
                'active' => '1',
                'no_pegawai' => 'EMP003',
                'profile' => null,
                'email' => 'kapro@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('kapro'),
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'manajerhc',
                'name' => 'manajerhc manajerhc',
                'role' => '3',
                'active' => '1',
                'no_pegawai' => 'EMP004',
                'profile' => null,
                'email' => 'manajerhc@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('manajerhc'),
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'pusat',
                'name' => 'pusat pusat',
                'role' => '4',
                'active' => '1',
                'no_pegawai' => 'EMP005',
                'profile' => null,
                'email' => 'pusat@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('pusat'),
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
