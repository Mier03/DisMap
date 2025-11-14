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
                    'status',
                    'date_reported',
                    'date_recovered',
                    'doctor_name',
                    'hospital_name',
                    'disease_name'
                ]))->toArray()
        ], 200);
    }
   
}