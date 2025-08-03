<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@easyshop.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'), // 🔐 TOUJOURS hashé
                'is_admin' => true,
                'email_verified_at' => now(), // ✅ Pour éviter blocage "non vérifié"
            ]
        );
    }
}
