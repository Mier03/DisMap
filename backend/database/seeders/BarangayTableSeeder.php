<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Barangay;

class BarangayTableSeeder extends Seeder
{
    public function run(): void
    {
        $barangays = [
             ['name' => 'Adlaon', 'latitude' => 10.456520489593613,  'longitude' => 123.87843705852869],
            ['name' => 'Agsungot', 'latitude' => 10.446098358100562, 'longitude' =>  123.90407670138003],
            ['name' => 'Apas', 'latitude' => 10.343322482584595, 'longitude' => 123.90382948043549],
            ['name' => 'Bacayan', 'latitude' => 10.387637422411398,'longitude' => 123.9191211132759],
            ['name' => 'Banilad', 'latitude' => 10.364814091874019,  'longitude' => 123.89644780221339],
            ['name' => 'Binaliw', 'latitude' => 10.430680444782611,  'longitude' => 123.91684151751707],
            ['name' => 'Budla-an', 'latitude' => 10.38326732109386,  'longitude' => 123.89095186080841],
            ['name' => 'Busay', 'latitude' => 10.371780620994224, 'longitude' => 123.87729350672065 ],
            ['name' => 'Cambinocot', 'latitude' => 10.473482279907502,  'longitude' => 123.90008863129316],
            ['name' => 'Camputhaw', 'latitude' => 10.32035887346045, 'longitude' => 123.89512958148622 ],
            ['name' => 'Capitol Site', 'latitude' => 10.319423638900528, 'longitude' => 123.89140054287574 ],
            ['name' => 'Carreta', 'latitude' => 10.31003412408741,  'longitude' => 123.91359975498729],
            ['name' => 'Cogon Ramos', 'latitude' => 10.310158668544652,  'longitude' => 123.89823697719838],
            ['name' => 'Day-as', 'latitude' => 10.30268737977657,  'longitude' => 123.90142929990711],
            ['name' => 'Ermita', 'latitude' => 10.292350881704325,  'longitude' => 123.89676905402327],
            ['name' => 'Guba', 'latitude' => 10.43703407391319, 'longitude' => 123.89133979226976],
            ['name' => 'Hipodromo', 'latitude' => 10.316330946831243, 'longitude' => 123.90797794597586 ],
            ['name' => 'Kalubihan', 'latitude' => 10.29838676254619,  'longitude' => 123.89664848139766],
            ['name' => 'Kamagayan', 'latitude' => 10.300767956929901,  'longitude' => 123.89985268719357],
            ['name' => 'Kasambagan', 'latitude' => 10.33548520797776,  'longitude' => 123.91325139395089],
            ['name' => 'Lahug', 'latitude' => 10.338940570182007, 'longitude' =>  123.89254613815542],
            ['name' => 'Lorega-San Miguel', 'latitude' => 10.309060587174864,  'longitude' => 123.90496491514925],
            ['name' => 'Lusaran', 'latitude' => 10.486020574563957, 'longitude' => 123.88002761606002],
            ['name' => 'Luz', 'latitude' => 10.323064704444935,  'longitude' => 123.90700528170483],
            ['name' => 'Mabini', 'latitude' => 10.459601629155609,  'longitude' => 123.91658002205074],
            ['name' => 'Mabolo', 'latitude' => 10.32304890869213,  'longitude' => 123.91852262989448],
            ['name' => 'Malubog', 'latitude' => 10.396863885102354,  'longitude' => 123.8704290625437],
            ['name' => 'Pahina Central', 'latitude' => 10.297690963361868,  'longitude' => 123.89275579593713],
            ['name' => 'Parian', 'latitude' => 10.299774054366104,  'longitude' => 123.90212216695741],
            ['name' => 'Paril', 'latitude' => 10.4789408726056,  'longitude' => 123.91134155353213],
            ['name' => 'Pit-os', 'latitude' => 10.407364371636351,  'longitude' => 123.9188404645705],
            ['name' => 'Pulangbato', 'latitude' => 10.406516042836312,  'longitude' => 123.90717845373239],
            ['name' => 'Sambag I', 'latitude' => 10.302384635414542, 'longitude' => 123.89118179223524 ],
            ['name' => 'Sambag II', 'latitude' => 10.307571785433343,  'longitude' => 123.89198171761262],
            ['name' => 'San Antonio', 'latitude' => 10.302384695191718,  'longitude' =>123.8978741112806],
            ['name' => 'San Jose', 'latitude' => 10.385529491236271, 'longitude' => 123.90436594503427 ],
            ['name' => 'San Roque', 'latitude' => 10.295586958727279,  'longitude' => 123.90407014125071],
            ['name' => 'Santa Cruz', 'latitude' => 10.306845214073187,  'longitude' => 123.8960386237642],
            ['name' => 'Santo Niño (Central)', 'latitude' => 10.296621422311715,  'longitude' => 123.90102605095396],
            ['name' => 'Sirao', 'latitude' => 10.414499724311844, 'longitude' => 123.86760419009919],
            ['name' => 'T. Padilla', 'latitude' => 10.304142142637534,  'longitude' => 123.90507689540124],
            ['name' => 'Talamban', 'latitude' => 10.36935978746795,  'longitude' => 123.91006610565374],
            ['name' => 'Taptap', 'latitude' => 10.42683992450101, 'longitude' => 123.84860412631056 ],
            ['name' => 'Tejero', 'latitude' => 10.306443107786022, 'longitude' => 123.9075078150703],
            ['name' => 'Tinago', 'latitude' => 10.299160130983061, 'longitude' =>  123.90792327267319],
            ['name' => 'Zapatera', 'latitude' => 10.309706022732648, 'longitude' => 123.9001395986553 ],
            ['name' => 'Babag', 'latitude' => 10.382184409661079, 'longitude' => 123.84868097604522],
            ['name' => 'Basak Pardo', 'latitude' =>10.283354904441461,  'longitude' => 123.86520990960035],
            ['name' => 'Basak San Nicolas', 'latitude' => 10.289612837012964, 'longitude' => 123.8675632529519],
            ['name' => 'Bonbon', 'latitude' => 10.373051787310608, 'longitude' => 123.81895614449881],
            ['name' => 'Buhisan', 'latitude' => 10.323298595519026,  'longitude' => 123.84702474659518],
            ['name' => 'Bulacao', 'latitude' => 10.298242307925431,  'longitude' => 123.8335030532171],
            ['name' => 'Buot-Taup Pardo', 'latitude' => 10.346100226175405, 'longitude' => 123.81142285392579],
            ['name' => 'Calamba', 'latitude' => 10.305139690235146,  'longitude' => 123.88525420182077],
            ['name' => 'Cogon Pardo', 'latitude' => 10.27703931717319,  'longitude' =>123.85933274006705],
            ['name' => 'Duljo Fatima', 'latitude' => 10.2910, 'longitude' => 123.8947],
            ['name' => 'Guadalupe', 'latitude' => 10.323080870679869, 'longitude' => 123.86923469220888 ],
            ['name' => 'Inayawan', 'latitude' => 10.26801809642014,  'longitude' => 123.85967163921224],
            ['name' => 'Kalunasan', 'latitude' => 10.339331930392095, 'longitude' => 123.8776317744201 ],
            ['name' => 'Kinasang-an Pardo', 'latitude' => 10.294171431047117, 'longitude' => 123.84923831245241 ],
            ['name' => 'Labangon', 'latitude' => 10.300335877584853,  'longitude' => 123.88164542105056 ],
            ['name' => 'Mambaling', 'latitude' => 10.288537596118845,  'longitude' => 123.87837833707314],
            ['name' => 'Pahina San Nicolas', 'latitude' => 10.29438448423724, 'longitude' =>  123.8929418319112],
            ['name' => 'Pamutan', 'latitude' => 10.35275723426741,  'longitude' => 123.84138282216938],
            ['name' => 'Pasil', 'latitude' => 10.290976565039125,  'longitude' => 123.89486440334058],
            ['name' => 'Poblacion Pardo', 'latitude' => 10.2731, 'longitude' => 123.8669],
            ['name' => 'Pung-ol Sibugay', 'latitude' => 10.39522657360598, 'longitude' => 123.84919891814813 ],
            ['name' => 'Punta Princesa', 'latitude' => 10.29528701787511, 'longitude' => 123.86590494952044],
            ['name' => 'Quiot Pardo', 'latitude' => 10.291229646607183,  'longitude' => 123.85679989704634],
            ['name' => 'San Nicolas Proper', 'latitude' => 10.2949, 'longitude' => 123.8955],
            ['name' => 'Sapangdaku', 'latitude' => 10.3245, 'longitude' => 123.8822],
            ['name' => 'Sawang Calero', 'latitude' => 10.2905, 'longitude' => 123.8989],
            ['name' => 'Sinsin', 'latitude' => 10.3642, 'longitude' => 123.8404],
            ['name' => 'Suba', 'latitude' => 10.2927, 'longitude' => 123.8983],
            ['name' => 'Sudlon I', 'latitude' => 10.3637, 'longitude' => 123.8517],
            ['name' => 'Sudlon II', 'latitude' => 10.3669, 'longitude' => 123.8425],
            ['name' => 'Tabunan', 'latitude' => 10.426993950813953, 'longitude' => 123.82400144069857],
            ['name' => 'Tagbao', 'latitude' => 10.4189, 'longitude' => 123.8856],
            ['name' => 'Tisa', 'latitude' => 10.303314806753582,  'longitude' => 123.86610446111487],
            ['name' => 'Toong', 'latitude' => 10.2898, 'longitude' => 123.8749],
        ];

        
        foreach ($barangays as $barangay) {
            Barangay::updateOrCreate(
                ['name' => $barangay['name']], 
                [
                    'latitude'  => $barangay['latitude'],
                    'longitude' => $barangay['longitude'],
                ]
            );
        }
    }
}
