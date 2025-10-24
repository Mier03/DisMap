<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Barangay;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(BarangayTableSeeder::class);
        $this->call(HospitalTableSeeder::class);
        $this->call(DiseaseSeeder::class);
        $this->call(DataRequestSeeder::class);

        $barangay = Barangay::first();
        if (!$barangay) {
            $barangay = Barangay::factory()->create(); 
        }

        User::firstOrCreate(
            ['email' => 'superadmin@gmail.com'],
            [
                'name' => 'Superadmin User',
                'username' => 'superadmin',
                'password' => Hash::make('password'),
                'user_type' => 'Admin',
                'is_approved' => true,
                'birthdate' => '1990-01-01', 
                'profile_image' => 'default_profile.jpg',
            ]
        );
    }
}