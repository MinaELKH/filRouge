<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Traiteur',
                'description' => 'Service de restauration pour mariages et grands événements.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Photographe',
                'description' => 'Professionnels pour immortaliser les moments de votre mariage.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Musique',
                'description' => 'Groupes, DJs et animations musicales pour vos soirées.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Esthétique coiffure',
                'description' => 'Coiffure, maquillage et soins esthétiques pour la mariée.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Voiture mariage',
                'description' => 'Location de voitures de luxe et décorées pour les mariés.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Negafa',
                'description' => 'Habilleuse traditionnelle pour mariée (robes, bijoux, service).',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Décoration',
                'description' => 'Décorateurs professionnels pour les salles et les espaces extérieurs.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Salle de fête',
                'description' => 'Salles de réception disponibles à la location pour vos événements.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
