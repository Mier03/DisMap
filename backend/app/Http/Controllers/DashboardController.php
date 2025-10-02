<?php

namespace App\Http\Controllers;

use App\Models\Barangay;
use App\Models\Disease;

class DashboardController extends Controller
{
    public function index()
    {
        $barangays = Barangay::all();
        $diseases = Disease::all();

        return view('dashboard', compact('barangays', 'diseases'));
    }

    public function diseaseRecords()
    {
        // Ensure the diseaserecords view is always rendered by DiseaseController@index
        // which supplies the required stat variables. Redirecting prevents accidental
        // direct rendering of the view without those variables.
        return redirect()->route('diseaserecords');
    }
}
