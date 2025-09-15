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

        $barangay = Barangay::first();
        if (!$barangay) {
            $barangay = Barangay::factory()->create(); 
        }

        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'username' => 'testuser',
                'password' => Hash::make('password'),
                'birthdate' => '1990-01-01', 
                'barangay_id' => $barangay->id, 
                'email_verified_at' => now(), 
                'profile_image' => 'default_profile.jpg',
            ]
        );
    }
}