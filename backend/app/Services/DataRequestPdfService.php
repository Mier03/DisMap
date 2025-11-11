<?php

namespace App\Services;

use App\Models\DataRequest;
use App\Models\PatientRecord;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DataRequestPdfService
{
    public function generateDataRequestPdf(DataRequest $dataRequest)
    {
        // Get the requested data based on the data request criteria
        $patientRecords = $this->getRequestedData($dataRequest);
        
        $pdf = Pdf::loadView('pdf.data-request-report', [
            'dataRequest' => $dataRequest,
            'patientRecords' => $patientRecords,
            'generatedAt' => now()->format('M j, Y g:i A'),
            'hasRecords' => $patientRecords->count() > 0 // Add this flag
        ]);
        
        $filename = "data-request-{$dataRequest->id}-" . now()->format('Y-m-d') . ".pdf";
        $filePath = storage_path("app/temp/{$filename}");
        
        // Ensure directory exists
        if (!file_exists(dirname($filePath))) {
            mkdir(dirname($filePath), 0755, true);
        }
        
        // Save the PDF to file
        $pdf->save($filePath);
        
        return $filePath;
    }

    protected function getRequestedData(DataRequest $dataRequest)
    {
        $query = PatientRecord::with([
            'patient',
            'disease',
            'reportedByDoctorHospital.doctor',
            'reportedByDoctorHospital.hospital'
        ]);

        // Filter by disease if specified
        if ($dataRequest->requested_disease && $dataRequest->requested_disease !== 'All') {
            $query->whereHas('disease', function ($q) use ($dataRequest) {
                $q->where('specification', 'like', "%{$dataRequest->requested_disease}%");
            });
        }

        // Filter by date range if specified
        if ($dataRequest->from_date && $dataRequest->from_date !== 'Not specified') {
            try {
                $fromDate = Carbon::parse($dataRequest->from_date);
                $query->where('date_reported', '>=', $fromDate);
            } catch (\Exception $e) {
                Log::error("Failed to parse from_date: {$dataRequest->from_date}");
            }
        }

        if ($dataRequest->to_date && $dataRequest->to_date !== 'Not specified') {
            try {
                $toDate = Carbon::parse($dataRequest->to_date);
                $query->where('date_reported', '<=', $toDate);
            } catch (\Exception $e) {
                Log::error("Failed to parse to_date: {$dataRequest->to_date}");
            }
        }

        return $query->orderBy('date_reported', 'desc')->get();
    }
}