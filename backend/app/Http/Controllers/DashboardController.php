<?php

namespace App\Http\Controllers;

use App\Models\Barangay;
use App\Models\Disease;
use App\Models\PatientRecord;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\HeatmapTrait;

class DashboardController extends Controller
{
    use HeatmapTrait;

    public function index(Request $request)
    {
        $heatmapData= $this->getHeatmap($request);

        // dd(asset('js/heatmap.js'));

        return view('dashboard', $heatmapData);
    }

   
}
