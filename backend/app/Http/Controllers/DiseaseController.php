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
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('specification', 'like', '%' . $search . '%');
            });
        }


        $diseaseRecords = $query->withCount([
            'patientRecords as total_cases',
            'patientRecords as active' => function ($q) {
                $q->where('status', 'Active');
            },
            'patientRecords as recovered' => function ($q) {
                $q->where('status', 'Recovered');
            },
        ])
            ->with(['patientRecords' => function ($q) {
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


    /**
     * Display detailed view for a specific disease showing patient records for current doctor
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Disease  $disease
     * @return \Illuminate\Http\Response
     * @return \Illuminate\Contracts\View\View
     */
    public function showDiseaseDetails(Request $request, Disease $disease): \Illuminate\Contracts\View\View
    {
        $search = $request->input('search');

        // Get ALL patient records for this specific disease (removed the doctor filter)
        $patientRecordsQuery = PatientRecord::with([
            'patient.barangay',
            'reportedByDoctorHospital.hospital',
            'recoveredByDoctorHospital.hospital'
        ])
            ->where('disease_id', $disease->id);

        // Apply search filters
        if ($search) {
            $patientRecordsQuery->where(function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('patient', function ($patientQuery) use ($search) {
                        $patientQuery->where('name', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%');
                    })
                        ->orWhere('reported_remarks', 'like', '%' . $search . '%')
                        ->orWhere('recovered_remarks', 'like', '%' . $search . '%')
                        ->orWhere('status', 'like', '%' . $search . '%');
                });
            });
        }
            
        $patientRecords = $patientRecordsQuery
            ->latest()
            ->get();

        // Get statistics for this specific disease
        $stats = [
            'total_cases' => $patientRecords->count(),
            'active_cases' => $patientRecords->where('status', 'Active')->count(),
            'recovered_cases' => $patientRecords->where('status', 'Recovered')->count(),
            'pending_cases' => $patientRecords->where('status', 'Pending')->count(),
        ];

        return view('disease-details', compact(
            'disease',
            'patientRecords',
            'stats',
            'search'
        ));
    }
}
