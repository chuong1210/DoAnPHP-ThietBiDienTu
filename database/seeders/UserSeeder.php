<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        // Admin account
        User::create([
            'email' => 'admin@shop.com',
            'password' => Hash::make('admin123'),
            'full_name' => 'Administrator',
            'phone' => '0901234567',
            'role' => 'admin',
            'status' => 'active',
        ]);

        // Sample users
        $users = [
            [
                'email' => 'user1@gmail.com',
                'password' => Hash::make('user123'),
                'full_name' => 'Nguyễn Văn A',
                'phone' => '0912345678',
                'role' => 'user',
                'status' => 'active',
            ],
            [
                'email' => 'user2@gmail.com',
                'password' => Hash::make('user123'),
                'full_name' => 'Trần Thị B',
                'phone' => '0923456789',
                'role' => 'user',
                'status' => 'active',
            ],
            [
                'email' => 'user3@gmail.com',
                'password' => Hash::make('user123'),
                'full_name' => 'Lê Văn C',
                'phone' => '0934567890',
                'role' => 'user',
                'status' => 'active',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
