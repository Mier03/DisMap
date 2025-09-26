<?php

namespace App\Http\Controllers;

use App\Models\PatientRecord;
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
        // Fetch total number of patient records
        $totalCases = PatientRecord::count();

        // Fetch the number of records with 'Active' status
        $totalActiveCases = PatientRecord::where('status', 'Active')->count();

        // NOTE: The database schema does not currently have a way to identify "critical" cases.
        // This could be a separate 'status' like 'Critical' or a property on the disease model.
        // We are using a placeholder value from your design for now.
        $totalCriticalCases = 9; // Placeholder

        return view('welcome', [
            'totalCases' => $totalCases,
            'totalActiveCases' => $totalActiveCases,
            'totalCriticalCases' => $totalCriticalCases,
        ]);
    }
}