<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Sisipkan user master admin jika belum ada
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'id' => (string) Str::uuid(),
                'email' => 'master@admin.com',
                'password' => Hash::make('admin'),
                'role' => 1,
                'status' => 'active',
                'last_login' => null,
                'people_id' => null,
            ]
        );
    }
}
