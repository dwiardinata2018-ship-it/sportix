<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OwnerSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat atau memperbarui akun Owner percobaan.
        DB::table('users')->updateOrInsert(
            ['email' => 'owner@sportix.com'],
            [
                'name' => 'Owner Sportix',
                'phone' => '081234567890',
                'password' => Hash::make('OwnerSportix123!'),
                'role' => 'owner',
                'account_status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Mengambil ID akun Owner.
        $owner = DB::table('users')
            ->where('email', 'owner@sportix.com')
            ->first();

        // Membuat profil Owner.
        DB::table('owner_profiles')->updateOrInsert(
            ['user_id' => $owner->id],
            [
                'business_name' => 'Sportix Demo Venue',
                'verification_status' => 'verified',
                'updated_at' => now(),
            ]
        );
    }
}