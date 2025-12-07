<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear usuario administrador único
        User::firstOrCreate(
            ['email' => 'vfjunior117@gmail.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('9317anm'),
                'role' => 'admin',
            ]
        );
    }
}
