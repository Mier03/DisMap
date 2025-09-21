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

    /**
     * Store a newly created patient record in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'fullName' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'barangay_id' => 'required|exists:barangays,id',
            'disease_id' => 'required|array',
            'disease_id.*' => 'required|exists:diseases,id', 
            'email' => 'required|email|unique:users,email',
            'hospital_id' => 'required|exists:hospitals,id',
            'reported_remarks' => 'required|string',
            'recovered_remarks' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            $nameParts = explode(' ', $request->input('fullName'));
            $firstName = strtolower($nameParts[0]);
            $lastName = strtolower(end($nameParts));
            $username = $firstName . '.' . $lastName . rand(1000, 9999);

            // Create the user
            $user = User::create([
                'name' => $request->input('fullName'),
                'username' => $username,
                'email' => $request->input('email'),
                'password' => Hash::make('12345678'),    
                'birthdate' => $request->input('birthdate'),
                'barangay_id' => $request->input('barangay_id'),
                'user_type' => 'patient',
                'is_approved' => true,
                'profile_image' => 'images/profiles/default.png',
                'status' => 'Active'
            ]);

            // Create doctor-hospital relationship
            $doctorHospital = DoctorHospital::firstOrCreate([
                'doctor_id' => Auth::id(),
                'hospital_id' => $request->input('hospital_id'),
            ]);

            // Create a patient record for each selected disease
            foreach ($request->input('disease_id') as $diseaseId) {
                PatientRecord::create([
                    'patient_id' => $user->id,
                    'reported_dh_id' => $doctorHospital->id,
                    'disease_id' => $diseaseId,
                    'status' => 'Active',
                    'reported_remarks' => $request->input('reported_remarks'),
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
    public function viewPatient($id)
    {
        $patient = User::with([
            'barangay',
            'patientRecords.disease',
            'patientRecords.doctorHospital.hospital'
        ])->findOrFail($id);

        $userId = Auth::id();
        $hospitals = Hospital::whereHas('doctors', function ($query) use ($userId) {
            $query->where('doctor_id', $userId);
        })->get();

        return view('admin.patient_details', compact('patient', 'hospitals'));
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
}