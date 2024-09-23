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
                'username' => 'john_doe',
                'name' => 'John Doe',
                'role' => '0',
                'active' => '0',
                'no_pegawai' => 'EMP001',
                'profile' => null,
                'email' => 'john@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'), // Encrypting the password
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'jane_doe',
                'name' => 'Jane Doe',
                'role' => '1',
                'active' => '1',
                'no_pegawai' => 'EMP002',
                'profile' => null,
                'email' => 'jane@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('cc'),
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
