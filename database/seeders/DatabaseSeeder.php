<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::create([
            'name' => 'Gestionnaire LIC',
            'email' => 'gestionnaire@pressinglic.com',
            'password' => Hash::make('password123'),
            'role' => 'gestionnaire'
        ]);

        User::create([
            'name' => 'Client Démo',
            'email' => 'client.demo@pressinglic.com',
            'password' => Hash::make('password123'),
            'role' => 'client',
        ]);

        $this->call([
            ServiceSeeder::class,
            TicketSeeder::class,
        ]);
    }
}
