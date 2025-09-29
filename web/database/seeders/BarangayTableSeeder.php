<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BarangayTableSeeder extends Seeder
{
    public function run(): void
    {
        $barangays = [
            'Adlaon', 'Agsungot', 'Apas', 'Bacayan', 'Banilad', 'Binaliw', 'Budla-an',
            'Busay', 'Cambinocot', 'Capitol Site', 'Carreta', 'Cogon Ramos', 'Day-as',
            'Ermita', 'Guba', 'Hipodromo', 'Kalubihan', 'Kamagayan', 'Kamputhaw',
            'Kasambagan', 'Lahug', 'Lorega-San Miguel', 'Lusaran', 'Luz', 'Mabini',
            'Mabolo', 'Malubog', 'Pahina Central', 'Parian', 'Paril', 'Pit-os',
            'Pulangbato', 'Sambag I', 'Sambag II', 'San Antonio', 'San Jose', 'San Roque',
            'Santa Cruz', 'Santo Niño (Central)', 'Sirao', 'T. Padilla', 'Talamban',
            'Taptap', 'Tejero', 'Tinago', 'Zapatera', 'Babag', 'Basak Pardo',
            'Basak San Nicolas', 'Bonbon', 'Buhisan', 'Bulacao', 'Buot-Taup Pardo',
            'Calamba', 'Cogon Pardo', 'Duljo Fatima', 'Guadalupe', 'Inayawan',
            'Kalunasan', 'Kinasang-an Pardo', 'Labangon', 'Mambaling',
            'Pahina San Nicolas', 'Pamutan', 'Pasil', 'Poblacion Pardo',
            'Pung-ol Sibugay', 'Punta Princesa', 'Quiot Pardo', 'San Nicolas Proper',
            'Sapangdaku', 'Sawang Calero', 'Sinsin', 'Suba', 'Sudlon I', 'Sudlon II',
            'Tabunan', 'Tagbao', 'Tisa', 'Toong'
        ];

        foreach ($barangays as $barangay) {
            DB::table('barangays')->insert([
                'name' => $barangay,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
