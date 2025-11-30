<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PatientRecord;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
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
                    'disease_name',
                    'reported_remarks' ,
                    'recovered_remarks' 
                ]))->toArray()
        ], 200);
    }
    public function exportPdf()
    {
        $patientRecords = PatientRecord::where('patient_id', Auth::id())->get();

        $pdf = Pdf::loadView('pdf.patient-report', [
            'patientRecords' => $patientRecords,
            'fromDate' => null,
            'toDate' => null,
            'isFilterApplied' => false,
            'hospitalId' => null,
            'hospitalName' => null,
            'diseaseId' => null,
            'diseaseName' => null,
            'addDiseaseColumn' => false,
            'addHospitalColumn' => false,
        ]);

        return $pdf->download('patient-records-' . now()->format('Y-m-d-His') . '.pdf');
    }

   
}