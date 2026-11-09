<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FacilitySeeder extends Seeder
{
    public function run(): void
    {
        $facilities = [
            'Ruang Ganti',
            'Toilet',
            'Parkir',
            'Mushola',
            'Wi-Fi',
            'Kantin',
            'Shower',
            'Tribun Penonton',
        ];

        foreach ($facilities as $facility) {
            DB::table('facilities')->updateOrInsert(
                ['name' => $facility],
                [
                    'is_active' => true,
                    'created_at' => now(),
                ]
            );
        }
    }
}

