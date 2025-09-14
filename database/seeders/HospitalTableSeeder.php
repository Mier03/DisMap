<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HospitalTableSeeder extends Seeder
{
    public function run(): void
    {
        $hospitals = [
            ['id' => 1, 'name' => 'Chong Hua Hospital (Cebu City & Mandaue)', 'type' => 'Private'],
            ['id' => 2, 'name' => 'Cebu Doctors’ University Hospital', 'type' => 'Private'],
            ['id' => 3, 'name' => 'Vicente Sotto Memorial Medical Center', 'type' => 'Government'],
            ['id' => 4, 'name' => 'Perpetual Succour Hospital of Cebu, Inc.', 'type' => 'Private'],
            ['id' => 5, 'name' => 'North General Hospital (North Gen)', 'type' => 'Private'],
            ['id' => 6, 'name' => 'St. Anthony Mother and Child Hospital', 'type' => 'Government'],
            ['id' => 7, 'name' => 'Eversley Childs Sanitarium and General Hospital', 'type' => 'Government'],
            ['id' => 8, 'name' => 'Cebu North General Hospital', 'type' => 'Private'],
            ['id' => 9, 'name' => 'Sacred Heart Hospital', 'type' => 'Private'],
            ['id' => 10, 'name' => 'Saint Vincent General Hospital', 'type' => 'Private'],
            ['id' => 11, 'name' => 'Cebu Velez General Hospital', 'type' => 'Private'],
            ['id' => 12, 'name' => 'Adventist Hospital-Cebu, Inc.', 'type' => 'Private'],
            ['id' => 13, 'name' => 'Cebu City Medical Center', 'type' => 'Government'],
            ['id' => 14, 'name' => 'Visayas Community Medical Center', 'type' => 'Private'],
            ['id' => 15, 'name' => 'South General Hospital (Naga)', 'type' => 'Private'],
        ];

        foreach ($hospitals as $hospital) {
            DB::table('hospitals')->insert([
                'id' => $hospital['id'],
                'name' => $hospital['name'],
                'type' => $hospital['type'],
            ]);
        }
    }
}
