<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hospital;

class HospitalTableSeeder extends Seeder
{
    public function run(): void
    {
        $hospitals = [
            ['name' => 'Chong Hua Hospital', 'type' => 'Private', 'address' => 'Don Mariano Cui Street, Fuente Osmeña Cir, Cebu City, 6000 Cebu'],
            ['name' => 'Cebu Doctors’ University Hospital', 'type' => 'Private', 'address' => 'Osmeña Blvd, Cebu City'],
            ['name' => 'Vicente Sotto Memorial Medical Center', 'type' => 'Government', 'address' => 'B. Rodriguez St, Cebu City, 6000 Cebu'],
            ['name' => 'Perpetual Succour Hospital of Cebu, Inc.', 'type' => 'Private', 'address' => 'Gorordo Ave, Cebu City, 6000 Cebu'],
            ['name' => 'North General Hospital (North Gen)', 'type' => 'Private', 'address' => 'Dr. P.V. Larrazabal Jr. Avenue, Cebu City'],
            ['name' => 'St. Anthony Mother and Child Hospital', 'type' => 'Government', 'address' => 'Cabreros St, Cebu City, 6000 Cebu'],
            ['name' => 'Eversley Childs Sanitarium and General Hospital', 'type' => 'Government', 'address' => '9X83+HFV, Upper Jagobiao Rd, Mandaue, Cebu'],
            ['name' => 'Cebu North General Hospital', 'type' => 'Private', 'address' => 'Kauswagan Road, Cebu City, 6000 Lalawigan ng Cebu'],
            ['name' => 'Sacred Heart Hospital', 'type' => 'Private', 'address' => '53 J. Urgello St, Cebu City, 6000 Cebu'],
            ['name' => 'Saint Vincent General Hospital', 'type' => 'Private', 'address' => '210 R. Landon Ext, Cebu City, 6000 Cebu'],
            ['name' => 'Cebu Velez General Hospital', 'type' => 'Private', 'address' => '41 F. Ramos St, Cebu City, 6000 Cebu'],
            ['name' => 'Adventist Hospital-Cebu, Inc.', 'type' => 'Private', 'address' => 'Cebu City, 6000 Cebu'],
            ['name' => 'Cebu City Medical Center', 'type' => 'Government', 'address' => 'Natalio B. Bacalso Ave, Panganiban St, Cebu City, 6000 Cebu'],
            ['name' => 'Visayas Community Medical Center', 'type' => 'Private', 'address' => '85 Osmeña Blvd, Cebu City, 6000 Cebu'],
            ['name' => 'South General Hospital', 'type' => 'Private', 'address' => '6QJC+RFC, Natalio B. Bacalso S National Hwy, Naga, 6037 Cebu'],
        ];

        foreach ($hospitals as $hospital) {
            Hospital::updateOrCreate(
                ['name' => $hospital['name']], 
                [
                    'type'    => $hospital['type'],
                    'address' => $hospital['address'],
                ]
            );
        }
    }
}