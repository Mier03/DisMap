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
        return view('diseaserecords');
    }
}
