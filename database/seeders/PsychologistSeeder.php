<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PsychologistSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Jonatan Alves',
            'email' => 'psicologo@example.com',
            'password' => Hash::make('psicologo'),
            'role' => 'psicologo',
        ]);

        // Adicione mais instâncias de Psychologist conforme necessário
    }
}
