<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'admin@easyshop.com'], // ✅ correspond à ce que tu testes dans Tinker
            [
                'name' => 'Admin',
                'password' => Hash::make('password'), // 🔒 change si besoin
                'is_admin' => true, // ✅ très important
            ]
        );
    }
}
