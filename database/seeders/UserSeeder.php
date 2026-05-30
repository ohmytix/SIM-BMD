<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ADMIN
        User::updateOrCreate(
            ['email' => 'admin@bmd.com'],
            [
                'name' => 'Admin PMD',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // OPERATOR
        User::updateOrCreate(
            ['email' => 'operator@bmd.com'],
            [
                'name' => 'Operator BMD',
                'password' => Hash::make('operator123'),
                'role' => 'operator',
            ]
        );
    }
}
