<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barangay;
use App\Models\Disease;


class AdminDashboardController extends Controller
{
    public function homepage()
    {
        $barangays = Barangay::all();
        $diseases = Disease::all();

        return view('admin.home', compact('barangays', 'diseases'));
    }

    public function index()
    {
        $barangays = Barangay::all();
        $diseases = Disease::all();

    // Return the admin dashboard view (full UI)
    return view('admin.dashboard', compact('barangays', 'diseases'));
    }
}
