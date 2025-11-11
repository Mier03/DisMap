<?php

namespace App\Http\Controllers;

use App\Models\PatientRecord;
use App\Models\Barangay; 
use App\Models\Disease; 
use Illuminate\Http\Request;
use App\HeatmapTrait;   

class WelcomeController extends Controller
{
    use HeatmapTrait;

    /**
     * Display the welcome page with statistics.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        
        $totalCases = PatientRecord::count();
        $totalActiveCases = PatientRecord::where('status', 'Active')->count();
        $totalRecoveredCases = PatientRecord::where('status', 'Recovered')->count();

        // Fetch barangays and diseases for the modal filters
        $barangays = Barangay::all();
        $diseases = Disease::all();
         $heatmapData= $this->getHeatmap($request);

      return view('welcome', [
            'totalCases' => $totalCases,
            'totalActiveCases' => $totalActiveCases,
            'totalRecoveredCases' => $totalRecoveredCases,
            'barangays' => $barangays,
            'diseases' => $diseases,
            ...$heatmapData
        ]);
    }
   
}