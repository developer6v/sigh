<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DemoUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'medico@example.com'],
            [
                'name' => 'Dr. Demo',
                'password' => Hash::make('secret123'),
                'role' => 'gestor',
                'crm' => 'CRM-12345',
            ]
        );

        User::updateOrCreate(
            ['email' => 'paciente@example.com'],
            [
                'name' => 'Paciente Demo',
                'password' => Hash::make('secret123'),
                'role' => 'cliente',
                'birthdate' => '1990-01-01',
            ]
        );
    }
}
