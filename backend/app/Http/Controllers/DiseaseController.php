<?php

namespace App\Http\Controllers;

use App\Models\Disease;
use Illuminate\Http\Request;
use App\Models\PatientRecord;

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
        ->has('patientRecords', '>=', 1)
        ->get();

        $statsTotalTypes = PatientRecord::distinct('disease_id')->count('disease_id');
        $statsTotalCases = PatientRecord::count();
        $statsActive = PatientRecord::where('status', 'Active')->count();
        $statsRecovered = PatientRecord::where('status', 'Recovered')->count();

        return response()->view('diseaserecords', compact(
            'diseaseRecords',
            'statsTotalTypes',
            'statsTotalCases',
            'statsActive',
            'statsRecovered'
        ));
    }
}

