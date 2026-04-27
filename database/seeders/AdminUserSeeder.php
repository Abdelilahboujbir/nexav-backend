<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Nexav',
            'email' => 'admin@nexav.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);
    }
}
