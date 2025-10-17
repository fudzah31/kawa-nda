<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'username' => 'admin1',
                'name' => 'Admin Satu',
                'nip' => '1234567890',
                'email' => 'admin1@example.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ],
            [
                'username' => 'admin2',
                'name' => 'Admin Dua',
                'nip' => '9876543210',
                'email' => 'admin2@example.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ],
            [
                'username' => 'user1',
                'name' => 'User Satu',
                'nip' => '1122334455',
                'email' => 'user1@example.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->updateOrInsert(
                ['email' => $user['email']], // cek berdasarkan email
                array_merge($user, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }
}
