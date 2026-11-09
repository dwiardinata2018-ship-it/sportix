<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@sportix.com'],
            [
                'name' => 'Administrator Sportix',
                'phone' => '081234567891',
                'password' => Hash::make('AdminSportix123!'),
                'role' => 'admin',
                'account_status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}