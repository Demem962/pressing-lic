<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['libelle' => 'Nettoyage costume', 'description' => 'Nettoyage à sec complet', 'prix' => 15.50, 'active' => true],
            ['libelle' => 'Nettoyage chemise', 'description' => 'Lavage et repassage', 'prix' => 5.00, 'active' => true],
            ['libelle' => 'Nettoyage pantalon', 'description' => 'Nettoyage à sec', 'prix' => 8.00, 'active' => true],
            ['libelle' => 'Nettoyage robe', 'description' => 'Nettoyage délicat', 'prix' => 18.00, 'active' => true],
            ['libelle' => 'Lavage couette', 'description' => 'Lavage grand format', 'prix' => 22.00, 'active' => true],
            ['libelle' => 'Repassage seul', 'description' => 'Sans nettoyage', 'prix' => 3.50, 'active' => false],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
