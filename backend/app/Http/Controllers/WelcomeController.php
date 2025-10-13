<?php

namespace App\Http\Controllers;

use App\Models\PatientRecord;
use App\Models\Barangay; 
use App\Models\Disease; 
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    /**
     * Display the welcome page with statistics.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        
        $totalCases = PatientRecord::count();
        $totalActiveCases = PatientRecord::where('status', 'Active')->count();
        $totalRecoveredCases = PatientRecord::where('status', 'Recovered')->count();

        // Fetch barangays and diseases for the modal filters
        $barangays = Barangay::all();
        $diseases = Disease::all();

        return view('welcome', [
            'totalCases' => $totalCases,
            'totalActiveCases' => $totalActiveCases,
            'totalRecoveredCases' => $totalRecoveredCases,
            'barangays' => $barangays,
            'diseases' => $diseases,
        ]);
    }
}