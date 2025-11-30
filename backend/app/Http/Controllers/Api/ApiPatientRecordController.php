<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PatientRecord;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ApiPatientRecordController extends Controller
{
    
    public function records()
    {
        return response()->json([
            'records' => PatientRecord::where('patient_id', Auth::id())
                ->get()
                ->map(fn (PatientRecord $record) =>  $record->only([
                    'status' => $record->status,
                    'date_reported' => $record->date_reported,
                    'date_recovered' => $record->date_recovered,
                    'doctor_name' => $record->doctor_name,
                    'hospital_name' => $record->hospital_name,
                    'disease_name' => $record->disease_name,
                    'reported_remarks' => $record->reported_remarks,
                    'recovered_remarks' => $record->recovered_remarks,
                ]))->toArray()
        ], 200);
    }
   
}