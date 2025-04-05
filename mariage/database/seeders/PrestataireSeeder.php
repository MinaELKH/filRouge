<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrestataireSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
//            [
//                'name' => 'Ali Ben Hassan',
//                'email' => 'ali@prestataire.com',
//                'password' => bcrypt('password123'),
//                'role' => 'prestataire',
//                'created_at' => now(),
//                'updated_at' => now(),
//            ],
//            [
//                'name' => 'Sofia Larbi',
//                'email' => 'sofia@prestataire.com',
//                'password' => bcrypt('password123'),
//                'role' => 'prestataire',
//                'created_at' => now(),
//                'updated_at' => now(),
//            ],
//            [
//                'name' => 'Khaled Amine',
//                'email' => 'khaled@prestataire.com',
//                'password' => bcrypt('password123'),
//                'role' => 'prestataire',
//                'created_at' => now(),
//                'updated_at' => now(),
//            ],
//            [
//                'name' => 'Laila Boudoua',
//                'email' => 'laila@prestataire.com',
//                'password' => bcrypt('password123'),
//                'role' => 'prestataire',
//                'created_at' => now(),
//                'updated_at' => now(),
//            ],
//            [
//                'name' => 'Omar Tazi',
//                'email' => 'omar@prestataire.com',
//                'password' => bcrypt('password123'),
//                'role' => 'prestataire',
//                'created_at' => now(),
//                'updated_at' => now(),
//            ],
//            [
//                'name' => 'Yasmine Ait',
//                'email' => 'yasmine@prestataire.com',
//                'password' => bcrypt('password123'),
//                'role' => 'prestataire',
//                'created_at' => now(),
//                'updated_at' => now(),
//            ],
//            [
//                'name' => 'Karim Idrissi',
//                'email' => 'karim@prestataire.com',
//                'password' => bcrypt('password123'),
//                'role' => 'prestataire',
//                'created_at' => now(),
//                'updated_at' => now(),
//            ],
//            [
//                'name' => 'Meriem Fassi',
//                'email' => 'meriem@prestataire.com',
//                'password' => bcrypt('password123'),
//                'role' => 'prestataire',
//                'created_at' => now(),
//                'updated_at' => now(),
//            ],
            [
                'name' => 'Adil Fahmi',
                'email' => 'Fahmi@prestataire.com',
                'password' => bcrypt('password123'),
                'role' => 'prestataire',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'rahyan',
                'email' => 'rahyan@prestataire.com',
                'password' => bcrypt('password123'),
                'role' => 'prestataire',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'rima',
                'email' => 'rima@prestataire.com',
                'password' => bcrypt('password123'),
                'role' => 'prestataire',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Aziz',
                'email' => 'Aziz@prestataire.com',
                'password' => bcrypt('password123'),
                'role' => 'prestataire',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
