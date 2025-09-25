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
            ['id' => 1, 'name' => 'Chong Hua Hospital', 'type' => 'Private','address'=>'Don Mariano Cui Street, Fuente Osmeña Cir, Cebu City, 6000 Cebu'],
            ['id' => 2, 'name' => 'Cebu Doctors’ University Hospital', 'type' => 'Private','address'=>'Osmeña Blvd, Cebu City'],
            ['id' => 3, 'name' => 'Vicente Sotto Memorial Medical Center', 'type' => 'Government','address'=>'B. Rodriguez St, Cebu City, 6000 Cebu'],
            ['id' => 4, 'name' => 'Perpetual Succour Hospital of Cebu, Inc.', 'type' => 'Private','address'=>'Gorordo Ave, Cebu City, 6000 Cebu'],
            ['id' => 5, 'name' => 'North General Hospital (North Gen)', 'type' => 'Private','address'=>'Dr. P.V. Larrazabal Jr. Avenue, Cebu City'],
            ['id' => 6, 'name' => 'St. Anthony Mother and Child Hospital', 'type' => 'Government','address'=>'Cabreros St, Cebu City, 6000 Cebu'],
            ['id' => 7, 'name' => 'Eversley Childs Sanitarium and General Hospital', 'type' => 'Government','address'=>'9X83+HFV, Upper Jagobiao Rd, Mandaue, Cebu'],
            ['id' => 8, 'name' => 'Cebu North General Hospital', 'type' => 'Private','address'=>'Kauswagan Road, Cebu City, 6000 Lalawigan ng Cebu'],
            ['id' => 9, 'name' => 'Sacred Heart Hospital', 'type' => 'Private','address'=>'53 J. Urgello St, Cebu City, 6000 Cebu'],
            ['id' => 10, 'name' => 'Saint Vincent General Hospital', 'type' => 'Private','address'=>'210 R. Landon Ext, Cebu City, 6000 Cebu'],
            ['id' => 11, 'name' => 'Cebu Velez General Hospital', 'type' => 'Private','address'=>'41 F. Ramos St, Cebu City, 6000 Cebu'],
            ['id' => 12, 'name' => 'Adventist Hospital-Cebu, Inc.', 'type' => 'Private','address'=>'Cebu City, 6000 Cebu'],
            ['id' => 13, 'name' => 'Cebu City Medical Center', 'type' => 'Government','address'=>'Natalio B. Bacalso Ave, Panganiban St, Cebu City, 6000 Cebu'],
            ['id' => 14, 'name' => 'Visayas Community Medical Center', 'type' => 'Private','address'=>'85 Osmeña Blvd, Cebu City, 6000 Cebu'],
            ['id' => 15, 'name' => 'South General Hospital', 'type' => 'Private','address'=>'6QJC+RFC, Natalio B. Bacalso S National Hwy, Naga, 6037 Cebu'],
        ];

       DB::table('hospitals')->insert($hospitals);
    }
}
