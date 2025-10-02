<?php

namespace App\Http\Controllers;

use App\Models\Disease;
use Illuminate\Http\Request;

class DiseaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Start building the query
        $query = Disease::query();

        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('specification', 'like', '%' . $search . '%');
            });
        }

        
        $diseaseRecords = $query->withCount([
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

        // Compute overall (unfiltered) statistics so the stat cards are
        // not affected by the current search/filter in the table.
        $allDiseases = Disease::withCount([
            'patientRecords as total_cases',
            'patientRecords as active' => function($q) {
                $q->where('status', 'Active');
            },
            'patientRecords as recovered' => function($q) {
                $q->where('status', 'Recovered');
            },
        ])->get();

        $statsTotalTypes = $allDiseases->count();
        $statsActive = $allDiseases->sum('active');
        $statsRecovered = $allDiseases->sum('recovered');

        return view('diseaserecords', compact(
            'diseaseRecords',
            'statsTotalTypes',
            'statsActive',
            'statsRecovered'
        ));
    }
}

