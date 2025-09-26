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

        // NOTE: The database schema does not currently have a way to identify "critical" cases.
        $totalCriticalCases = 9;

        // Fetch barangays and diseases for the modal filters
        $barangays = Barangay::all();
        $diseases = Disease::all();

        return view('welcome', [
            'totalCases' => $totalCases,
            'totalActiveCases' => $totalActiveCases,
            'totalCriticalCases' => $totalCriticalCases,
            'barangays' => $barangays,
            'diseases' => $diseases,
        ]);
    }
}