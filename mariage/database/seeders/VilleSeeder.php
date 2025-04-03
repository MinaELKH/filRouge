<?php

namespace Database\Seeders;
use App\Models\Ville;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
class VilleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $villes = [
            'Casablanca', 'Rabat', 'Marrakech', 'Fès', 'Tanger', 'Agadir', 'Meknès', 'Oujda',
            'Kenitra', 'Tetouan', 'Safi', 'El Jadida', 'Beni Mellal', 'Errachidia', 'Nador'
        ];
        foreach ($villes as $ville) {
            Ville::create(['name' => $ville]);
        }
    }
}
