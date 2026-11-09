<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SportSeeder extends Seeder
{
    public function run(): void
    {
        $sports = [
            [
                'name' => 'Badminton',
                'description' => 'Olahraga raket yang dimainkan menggunakan shuttlecock.',
                'is_active' => true,
            ],
            [
                'name' => 'Futsal',
                'description' => 'Olahraga sepak bola yang dimainkan di lapangan berukuran kecil.',
                'is_active' => true,
            ],
            [
                'name' => 'Basket',
                'description' => 'Olahraga bola basket yang dimainkan oleh dua tim.',
                'is_active' => true,
            ],
            [
                'name' => 'Tenis',
                'description' => 'Olahraga raket yang dimainkan menggunakan bola tenis.',
                'is_active' => true,
            ],
            [
                'name' => 'Voli',
                'description' => 'Olahraga bola voli yang dimainkan oleh dua tim.',
                'is_active' => true,
            ],
            [
                'name' => 'Renang',
                'description' => 'Olahraga air yang dilakukan di kolam renang.',
                'is_active' => true,
            ],
        ];

        foreach ($sports as $sport) {
            DB::table('sports')->updateOrInsert(
                ['name' => $sport['name']],
                array_merge($sport, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }
}