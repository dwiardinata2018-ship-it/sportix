<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class VenueSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {

            // Mengambil akun Owner dan Admin.
            $owner = DB::table('users')
                ->where('email', 'owner@sportix.com')
                ->first();

            $admin = DB::table('users')
                ->where('email', 'admin@sportix.com')
                ->first();

            // Mengambil kategori Badminton.
            $sport = DB::table('sports')
                ->where('name', 'Badminton')
                ->first();

            if (!$owner || !$admin || !$sport) {
                throw new RuntimeException(
                    'Akun Owner, Admin, atau kategori Badminton belum tersedia.'
                );
            }

            // Membuat venue percobaan.
            DB::table('venues')->updateOrInsert(
                ['slug' => 'sportix-badminton-center'],
                [
                    'owner_id' => $owner->id,
                    'sport_id' => $sport->id,
                    'name' => 'Sportix Badminton Center',
                    'description' => 'Venue badminton percobaan untuk demonstrasi aplikasi Sportix.',
                    'address' => 'Jl. Contoh Sportix No. 1',
                    'city' => 'Cimahi',
                    'province' => 'Jawa Barat',
                    'venue_type' => 'indoor',
                    'verification_status' => 'verified',
                    'venue_status' => 'active',
                    'verified_by' => $admin->id,
                    'verified_at' => now(),
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );

            // Mengambil ID venue.
            $venue = DB::table('venues')
                ->where('slug', 'sportix-badminton-center')
                ->first();

            // Membuat dua unit lapangan.
            $units = [
                'Lapangan Badminton 1',
                'Lapangan Badminton 2',
            ];

            foreach ($units as $unitName) {
                DB::table('venue_units')->updateOrInsert(
                    [
                        'venue_id' => $venue->id,
                        'name' => $unitName,
                    ],
                    [
                        'unit_type' => 'court',
                        'description' => 'Lapangan badminton indoor.',
                        'capacity' => 4,
                        'default_price' => 50000,
                        'is_active' => true,
                    ]
                );
            }

            // Menghubungkan fasilitas dengan venue.
            $facilityNames = [
                'Parkir',
                'Toilet',
                'Ruang Ganti',
                'Mushola',
                'Wi-Fi',
            ];

            foreach ($facilityNames as $facilityName) {
                $facility = DB::table('facilities')
                    ->where('name', $facilityName)
                    ->first();

                if ($facility) {
                    DB::table('venue_facilities')->insertOrIgnore([
                        'venue_id' => $venue->id,
                        'facility_id' => $facility->id,
                    ]);
                }
            }

            // Membuat jam operasional setiap hari.
            for ($day = 1; $day <= 7; $day++) {
                DB::table('operating_hours')->updateOrInsert(
                    [
                        'venue_id' => $venue->id,
                        'weekday' => $day,
                    ],
                    [
                        'open_time' => '08:00:00',
                        'close_time' => '22:00:00',
                        'is_closed' => false,
                    ]
                );
            }

            // Membuat harga untuk setiap unit lapangan.
            $venueUnits = DB::table('venue_units')
                ->where('venue_id', $venue->id)
                ->get();

            foreach ($venueUnits as $unit) {
                DB::table('pricing_rules')->updateOrInsert(
                    [
                        'venue_id' => $venue->id,
                        'unit_id' => $unit->id,
                        'name' => 'Harga Reguler - ' . $unit->name,
                    ],
                    [
                        'weekday' => null,
                        'start_time' => '08:00:00',
                        'end_time' => '22:00:00',
                        'price_per_hour' => 50000,
                        'effective_from' => null,
                        'effective_until' => null,
                        'is_active' => true,
                    ]
                );
            }
        });
    }
}
