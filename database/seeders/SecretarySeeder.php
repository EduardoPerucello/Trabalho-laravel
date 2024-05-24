<?php

namespace Database\Seeders;

// database/seeders/SecretarySeeder.php
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SecretarySeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Secretaria',
            'email' => 'secretaria@example.com',
            'password' => Hash::make('password'),
            'role' => 'secretaria',
        ]);
    }
}

