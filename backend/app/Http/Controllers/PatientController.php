<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DoctorHospital;
use App\Models\Hospital;
use App\Models\Barangay;
use App\Models\Disease;
use App\Models\PatientRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;

class PatientController extends Controller
{
    /**
     * Display a listing of patients, hospitals, and diseases.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $searchTerm = $request->input('q');

        $patients = User::query()
        ->with(['barangay', 'patientRecords.disease', 'patientRecords.reportedByDoctorHospital'])
        ->where('user_type', 'patient')
        ->when($searchTerm, function ($query, $searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                    ->orWhereHas('barangay', function ($b) use ($searchTerm) {
                        $b->where('name', 'LIKE', "%{$searchTerm}%");
                    })
                    ->orWhereHas('patientRecords.disease', function ($dr) use ($searchTerm) {
                        $dr->where('specification', 'LIKE', "%{$searchTerm}%");
                    });
            });
        })
        ->get();
            
        $userId = Auth::id();
        $hospitals = Hospital::whereHas('doctors', function ($query) use ($userId) {
            $query->where('doctor_id', $userId);
        })->get();

        $barangays = Barangay::all();
        $diseases = Disease::all();

        return view('admin.managepatients', [
            'patients' => $patients,
            'hospitals' => $hospitals,
            'barangays' => $barangays,
            'diseases' => $diseases,
        ]);
    }

     public function storeRecord(Request $request)
    {
            // Validate input
        $validated = $request->validate([
            'patient_id' => 'required|exists:users,id',
            'hospital_id' => 'required|exists:hospitals,id',
            'disease_id' => 'required|array',
            // 'disease_id.*' => 'exists:diseases,id',
            'disease_id.*' => 'required|string', 
            'custom_disease_name' => 'nullable|array', 
            'custom_disease_name.*' => 'nullable|string|max:255',
            'custom_disease_spec' => 'nullable|array', 
            'custom_disease_spec.*' => 'nullable|string|max:255',
            'reported_remarks' => 'required|array',
            'reported_remarks.*' => 'string|max:255',
        ]);

        
        $doctorHospital = DoctorHospital::firstOrCreate([
            'doctor_id' => Auth::id(),
            'hospital_id' => $request->input('hospital_id'),
        ]);

        $customNames = $request->input('custom_disease_name', []);
        $customSpecs = $request->input('custom_disease_spec', []);
        $customIndex = 0;

        foreach ($request->input('disease_id') as $index => $diseaseId) {
            $finalDiseaseId = $diseaseId;
            if ($diseaseId === 'other_specify') {
                $generalName = $customNames[$customIndex] ?? null;
                $specification = $customSpecs[$customIndex] ?? null;

                    if ($generalName && $specification) {
                        $newDisease = Disease::firstOrCreate(
                            ['specification' => $specification],
                            ['name' => $generalName, 'specification' => $specification]
                    );
                    $finalDiseaseId = $newDisease->id;
                    }
            $customIndex++; 
            }

            if (!is_numeric($finalDiseaseId)) {
                continue;
            }

            PatientRecord::create([
                'patient_id' => $request->input('patient_id'),
                'reported_dh_id' => $doctorHospital->id,
                'disease_id' => $finalDiseaseId,
                'status' => 'Active',
                'reported_remarks' => $request->input('reported_remarks')[$index],
                'date_reported' => now(),
            ]);
        }
    return redirect()->route('admin.managepatients')
        ->with('success', 'Patient record added successfully!');
    }

    /**
     * Store a newly created patient record in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
{
    $request->validate([
        'first_name' => 'required|string|max:255',
        'middle_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'birthdate' => 'required|date',
        'sex' => 'required|in:Male,Female,Other',
        'ethnicity' => 'required|string|max:255',
        'street_address' => 'required|string|max:255',
        'contact_number' => 'required|string|max:20',
        'barangay_id' => 'required|exists:barangays,id',
        'disease_id' => 'required|array',
        'disease_id.*' => 'required|string',
        'custom_disease_name' => 'nullable|array', 
        'custom_disease_name.*' => 'nullable|string|max:255',
        'custom_disease_spec' => 'nullable|array', 
        'custom_disease_spec.*' => 'nullable|string|max:255',
        'reported_remarks' => 'required|array',
        'reported_remarks.*' => 'required|string',
        'hospital_id' => 'required|exists:hospitals,id',
        'email' => 'required|email|unique:users,email',
    ]);

    DB::transaction(function () use ($request) {
        $username = strtolower(
            str_replace(' ', '', $request->input('first_name')) .
            '.' .
            str_replace(' ', '', $request->input('last_name')) .
            rand(1000, 9999)
        );
        $fullName = $request->input('first_name') . ' ' . $request->input('middle_name') . ' ' . $request->input('last_name');

        // Create the user
        $user = User::create([
            'name' => $fullName,
            'username' => $username,
            'email' => $request->input('email'),
            'password' => Hash::make('12345678'),
            'birthdate' => $request->input('birthdate'),
            'sex' => $request->input('sex'),
            'ethnicity' => $request->input('ethnicity'),
            'street_address' => $request->input('street_address'),
            'contact_number' => $request->input('contact_number'),
            'barangay_id' => $request->input('barangay_id'),
            'user_type' => 'patient',
            'is_approved' => true,
            'profile_image' => 'images/profiles/default.png',
            'status' => 'Active',
        ]);

        // Create doctor-hospital relationship
        $doctorHospital = DoctorHospital::firstOrCreate([
            'doctor_id' => Auth::id(),
            'hospital_id' => $request->input('hospital_id'),
        ]);

        $customNames = $request->input('custom_disease_name', []);
        $customSpecs = $request->input('custom_disease_spec', []);
        $customIndex = 0;

        // Create a patient record for each selected disease with corresponding remarks
        foreach ($request->input('disease_id') as $index => $diseaseId) {
            $finalDiseaseId = $diseaseId;

            if ($diseaseId === 'other_specify') {
                $generalName = $customNames[$customIndex] ?? null;
                $specification = $customSpecs[$customIndex] ?? null;

                if ($generalName && $specification) {
                    $newDisease = Disease::firstOrCreate(
                        ['specification' => $specification],
                        ['name' => $generalName, 'specification' => $specification]
               );
                 $finalDiseaseId = $newDisease->id;
                }
                
                $customIndex++;
            }

            if (!is_numeric($finalDiseaseId)) {
                continue;
            }

            PatientRecord::create([
                'patient_id' => $user->id,
                'reported_dh_id' => $doctorHospital->id,
                'disease_id' => $finalDiseaseId,
                'status' => 'Active',
                'reported_remarks' => $request->input('reported_remarks')[$index],
                'date_reported' => now(),
            ]);
        }
    });

    return redirect()->route('admin.managepatients')->with('success', 'Patient record added successfully!');
}

    /**
     * Display the specified patient's details and medical history.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */

    /**
 * Display a specific patient record.
 *
 * @param  int  $id
 * @return \Illuminate\Http\JsonResponse
 */
    public function show($id)
    {
        try {
            $record = PatientRecord::with([
                'disease',
                'reportedByDoctorHospital.doctor',
                'reportedByDoctorHospital.hospital',
                'recoveredByDoctorHospital.doctor',
                'recoveredByDoctorHospital.hospital'
            ])->findOrFail($id);

            return response()->json([
                'reported_remarks' => $record->reported_remarks ?? 'N/A',
                'reported_doctor' => $record->reportedByDoctorHospital->doctor->name ?? 'N/A',
                'reported_hospital' => $record->reportedByDoctorHospital->hospital->name ?? 'N/A',
                'recovered_remarks' => $record->recovered_remarks,
                'recovered_doctor' => $record->recoveredByDoctorHospital ? $record->recoveredByDoctorHospital->doctor->name : null,
                'recovered_hospital' => $record->recoveredByDoctorHospital ? $record->recoveredByDoctorHospital->hospital->name : null,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching patient record: ' . $e->getMessage());
            return response()->json(['error' => 'Record not found'], 404);
        }
    }

    public function viewPatient($id, Request $request) 
    {
        $patient = User::with([
            'barangay',
        ])->findOrFail($id);

        $searchTerm = $request->input('q');

        $patientRecordsQuery = PatientRecord::where('patient_id', $patient->id)
            ->with(['disease', 'doctorHospital.hospital'])
            ->latest(); // sort latest record first

        // search medical records
        if ($searchTerm) {
            $patientRecordsQuery->where(function ($q) use ($searchTerm) {
                $q->where('reported_remarks', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('recovered_remarks', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('status', 'LIKE', '%' . $searchTerm . '%') 
                    ->orWhereHas('disease', function ($dr) use ($searchTerm) {
                        $dr->where('specification', 'LIKE', '%' . $searchTerm . '%');
                    })
                    ->orWhereHas('reportedByDoctorHospital.doctor', function ($d) use ($searchTerm) {
                        $d->where('name', 'LIKE', '%' . $searchTerm . '%');
                    })
                    ->orWhereHas('reportedByDoctorHospital.hospital', function ($h) use ($searchTerm) {
                        $h->where('name', 'LIKE', '%' . $searchTerm . '%');
                    })
                    ->orWhereHas('recoveredByDoctorHospital.doctor', function ($d) use ($searchTerm) {
                        $d->where('name', 'LIKE', '%' . $searchTerm . '%');
                    })
                    ->orWhereHas('recoveredByDoctorHospital.hospital', function ($h) use ($searchTerm) {
                        $h->where('name', 'LIKE', '%' . $searchTerm . '%');
                    });
            });
        }

        $patientRecords = $patientRecordsQuery->get();

        $userId = Auth::id();
        $hospitals = Hospital::whereHas('doctors', function ($query) use ($userId) {
            $query->where('doctor_id', $userId);
        })->get();
        $diseases = Disease::all();

        return view('admin.patient_details', [
            'patient' => $patient,
            'hospitals' => $hospitals,
            'patientRecords' => $patientRecords,
            'diseases' => $diseases
        ]);
    }

    /**
     * Update the recovery details for a patient record.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateRecovery(Request $request, $id)
    {
        $request->validate([
            'date_recovered' => 'required|date',
            'hospital_id' => 'required|exists:hospitals,id',
            'recovered_remarks' => 'required|string',
        ]);

        try {
            $patientRecord = PatientRecord::findOrFail($id);

            // Verify the hospital is associated with the authenticated doctor
            $userId = Auth::id();
            $hospital = Hospital::whereHas('doctors', function ($query) use ($userId) {
                $query->where('doctor_id', $userId);
            })->findOrFail($request->hospital_id);

            DB::transaction(function () use ($request, $patientRecord, $userId, $hospital) {
                $doctorHospital = DoctorHospital::firstOrCreate([
                    'doctor_id' => $userId,
                    'hospital_id' => $request->hospital_id,
                ]);

                $patientRecord->update([
                    'date_recovered' => $request->date_recovered,
                    'recovered_dh_id' => $doctorHospital->id,
                    'recovered_remarks' => $request->recovered_remarks,
                    'status' => 'Recovered',
                ]);
            });

            return response()->json(['message' => 'Recovery details updated successfully'], 200);
        } catch (\Exception $e) {
            Log::error('Error updating recovery details: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to update recovery details'], 500);
        }
    }
public function exportPdf(Request $request)
{
    $fromDate = $request->input('fromDate');
    $toDate = $request->input('toDate');
    $hospitalId = $request->input('hospital_id');
    $diseaseId = $request->input('disease_id');

    $user = auth()->user(); // Get the logged-in user

    $query = PatientRecord::with([
        'patient',
        'disease',
        'reportedByDoctorHospital.hospital',
        'reportedByDoctorHospital.doctor',
        'recoveredByDoctorHospital.doctor'
    ]);

    // ✅ Apply filters
    if ($fromDate && $toDate) {
        $query->whereBetween('date_reported', [$fromDate, $toDate]);
    } elseif ($fromDate) {
        $query->whereDate('date_reported', '>=', $fromDate);
    } elseif ($toDate) {
        $query->whereDate('date_reported', '<=', $toDate);
    }

    if ($hospitalId) {
        $query->whereHas('reportedByDoctorHospital', fn($q) =>
            $q->where('hospital_id', $hospitalId)
        );
    }

    if ($diseaseId) {
        $query->where('disease_id', $diseaseId);
    }

    // ✅ If no filters applied → show only patients handled by logged-in user
    $isFilterApplied = $fromDate || $toDate || $hospitalId || $diseaseId;

    if (!$isFilterApplied ) {
        $query->where(function ($q) use ($user) {
            $q->whereHas('reportedByDoctorHospital', fn($sub) =>
                $sub->where('doctor_id',$user->id)
            )->orWhereHas('recoveredByDoctorHospital', fn($sub) =>
                $sub->where('doctor_id', $user->id)
            );
        });
    }
    $hospitalName = $hospitalId ? Hospital::find($hospitalId)?->name : null;
    $diseaseName = $diseaseId ? Disease::find($diseaseId)?->specification : null;

    $patientRecords = $query->get();

    // ✅ Generate PDF
    $html = view('pdf.patient-report', compact(
        'patientRecords',
        'fromDate',
        'toDate',
        'hospitalId',
        'diseaseId',
        'isFilterApplied',
        'hospitalName',
        'diseaseName'
    ))->render();

    $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
    $fontDirs = $defaultConfig['fontDir'];
    $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
    $fontData = $defaultFontConfig['fontdata'];

    $mpdf = new \Mpdf\Mpdf([
        'tempDir' => storage_path('app/mpdf'),
        'fontDir' => array_merge($fontDirs, [resource_path('fonts')]),
        'fontdata' => $fontData + [
            'inter' => [
                'R' => 'Inter_18pt-Regular.ttf',
                'B' => 'Inter_18pt-Bold.ttf',
                'I' => 'Inter_18pt-Italic.ttf',
            ],
        ],
        'default_font' => 'inter',
        'margin_left' => 10,
        'margin_right' => 10,
        'margin_top' => 10,
        'margin_bottom' => 10,
    ]);

    $mpdf->WriteHTML($html);
    return $mpdf->Output('patient-records.pdf', 'I');
}

}