<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('services')->insert([
            [
                'title' => 'Menu gastronomique marocain',
                'description' => 'Un menu complet pour 150 invités, avec buffet traditionnel et service à table.',
                'price' => 15000.00,
                'cover_image' => 'traiteur-marocain.jpg',
                'gallery' => json_encode([
                    'traiteur1.jpg',
                    'traiteur2.jpg',
                    'traiteur3.jpg',
                ]),
                'category_id' => 4,
                'user_id' => 5,
                'ville_id' => 1,
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'title' => 'Pack photo & vidéo HD',
                'description' => 'Reportage complet avec album personnalisé et teaser vidéo.',
                'price' => 7000.00,
                'cover_image' => 'photographe-mariage.jpg',
                'gallery' => json_encode([
                    'photo1.jpg',
                    'photo2.jpg',
                    'photo3.jpg',
                ]),
                'category_id' => 2,
                'user_id' => 6,
                'ville_id' => 1,
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'DJ + Sonorisation complète',
                'description' => 'DJ professionnel, lumières LED, animation et playlist personnalisée.',
                'price' => 5000.00,
                'cover_image' => 'dj-mariage.jpg',
                'gallery' => json_encode([
                    'dj1.jpg',
                    'dj2.jpg',
                    'dj3.jpg',
                ]),
                'category_id' => 6,
                'user_id' => 7,
                'ville_id' => 1,
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Coiffure & maquillage mariée',
                'description' => 'Coiffure, maquillage et retouches pendant l’événement.',
                'price' => 2500.00,
                'cover_image' => 'maquillage-coiffure.jpg',
                'gallery' => json_encode([
                    'beaute1.jpg',
                    'beaute2.jpg',
                ]),
                'category_id' => 3,
                'user_id' => 8,
                'ville_id' => 1,
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Location limousine décorée',
                'description' => 'Limousine avec chauffeur, fleurs, et tapis rouge.',
                'price' => 3000.00,
                'cover_image' => 'limousine-mariage.jpg',
                'gallery' => json_encode([
                    'voiture1.jpg',
                    'voiture2.jpg',
                ]),
                'category_id' => 8,
                'user_id' => 1,
                'ville_id' => 9,
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Pack Negafa royal',
                'description' => '5 tenues traditionnelles, accessoires et accompagnement complet.',
                'price' => 10000.00,
                'cover_image' => 'negafa-marocaine.jpg',
                'gallery' => json_encode([
                    'negafa1.jpg',
                    'negafa2.jpg',
                    'negafa3.jpg',
                ]),
                'category_id' => 9,
                'user_id' => 10,
                'ville_id' => 1,
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Décoration florale et lumineuse',
                'description' => 'Décor personnalisé pour la salle, les tables et l’entrée.',
                'price' => 4500.00,
                'cover_image' => 'decoration-mariage.jpg',
                'gallery' => json_encode([
                    'deco1.jpg',
                    'deco2.jpg',
                ]),
                'category_id' => 10,
                'user_id' => 11,
                'ville_id' => 1,
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Location salle premium 300 pers',
                'description' => 'Salle climatisée avec scène, tables rondes et chaises chiavari.',
                'price' => 12000.00,
                'cover_image' => 'salle-mariage.jpg',
                'gallery' => json_encode([
                    'salle1.jpg',
                    'salle2.jpg',
                    'salle3.jpg',
                ]),
                'category_id' => 11,
                'user_id' => 12,
                'ville_id' => 1,
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Location salle palais',
                'description' => 'Salle climatisée avec scène, tables rondes et chaises chiavari.',
                'price' => 12000.00,
                'cover_image' => 'salle-mariage-palais.jpg',
                'gallery' => json_encode([
                    'salle1.jpg',
                    'salle2.jpg',
                    'salle3.jpg',
                ]),
                'category_id' => 11,
                'user_id' => 12,
                'ville_id' => 1,
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Bateau Mariage ',
                'description' => 'Bateau au bord de la mer',
                'price' => 12000.00,
                'cover_image' => 'bateau-mariage.jpg',
                'gallery' => json_encode([
                    'bateau1.jpg',
                    'bateau2.jpg',
                    'bateau3.jpg',
                ]),
                'category_id' => 11,
                'user_id' => 12,
                'ville_id' => 1,
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now(),
            ],





            //traiteaur


            [
                'title' => 'Menu de mariage royal',
                'description' => 'Un menu prestigieux pour 100 invités, avec un buffet raffiné et service à table de haute qualité.',
                'price' => 18000.00,
                'cover_image' => 'menu_mariage_royal.jpg',
                'gallery' => json_encode([
                    'menu_royal1.jpg',
                    'menu_royal2.jpg',
                    'menu_royal3.jpg',
                ]),
                'category_id' => 6, // Traiteur
                'user_id' => 5, // Prestataire
                'ville_id' => 2, // Ville
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Buffet végétarien deluxe',
                'description' => 'Buffet végétarien complet pour 120 invités, incluant des plats variés et des desserts raffinés.',
                'price' => 13000.00,
                'cover_image' => 'buffet_vegetarien.jpg',
                'gallery' => json_encode([
                    'buffet_vegetarien1.jpg',
                    'buffet_vegetarien2.jpg',
                    'buffet_vegetarien3.jpg',
                ]),
                'category_id' => 4, // Traiteur
                'user_id' => 5, // Prestataire
                'ville_id' => 3, // Ville
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Menu marocain gastronomique avec animations',
                'description' => 'Un menu marocain complet, avec buffet traditionnel et animations culinaires sur place.',
                'price' => 22000.00,
                'cover_image' => 'menu_maroain_animations.jpg',
                'gallery' => json_encode([
                    'menu_maroain1.jpg',
                    'menu_maroain2.jpg',
                    'animations_culinaires.jpg',
                ]),
                'category_id' => 4, // Traiteur
                'user_id' => 5, // Prestataire
                'ville_id' => 4, // Ville
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Menu oriental traditionnel',
                'description' => 'Menu oriental pour 80 invités, composé de plats traditionnels servis avec un buffet oriental et pâtisseries.',
                'price' => 10000.00,
                'cover_image' => 'menu_oriental_traditionnel.jpg',
                'gallery' => json_encode([
                    'menu_oriental1.jpg',
                    'menu_oriental2.jpg',
                    'patisseries_orientales.jpg',
                ]),
                'category_id' => 4, // Traiteur
                'user_id' => 13, // Prestataire
                'ville_id' => 1, // Ville
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Buffet gourmet pour cocktail',
                'description' => 'Buffet haut de gamme pour un cocktail de mariage, incluant des bouchées raffinées et des boissons exquises.',
                'price' => 8500.00,
                'cover_image' => 'buffet_gourmet_cocktail.jpg',
                'gallery' => json_encode([
                    'cocktail_buffet1.jpg',
                    'cocktail_buffet2.jpg',
                    'cocktail_buffet3.jpg',
                ]),
                'category_id' => 4, // Traiteur
                'user_id' => 13, // Prestataire
                'ville_id' => 2, // Ville
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Catering haut de gamme',
                'description' => 'Catering complet pour une réception haut de gamme avec des plats de saison et un service sur mesure.',
                'price' => 25000.00,
                'cover_image' => 'catering_haut_de_gamme.jpg',
                'gallery' => json_encode([
                    'catering1.jpg',
                    'catering2.jpg',
                    'catering3.jpg',
                ]),
                'category_id' => 4, // Traiteur
                'user_id' => 14, // Prestataire
                'ville_id' => 3, // Ville
                'status' => 'approved',
                'created_at' => now(),
                'updated_at' => now(),
            ],


        ]);
    }
}
