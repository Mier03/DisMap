<?php

namespace App\Http\Controllers;

use App\Models\Disease;

class DiseaseController extends Controller
{
    public function index()
    {
        $diseaseRecords = Disease::withCount([
            'patientRecords as total_cases',
            'patientRecords as active' => function($q) {
                $q->where('status', 'Active');
            },
            'patientRecords as recovered' => function($q) {
                $q->where('status', 'Recovered');
            },
        ])
        ->with(['patientRecords' => function($q) {
            $q->orderByDesc('date_reported');
        }])
        ->get();

        return view('diseaserecords', compact('diseaseRecords'));
    }
}
