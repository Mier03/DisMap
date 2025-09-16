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
        ->with(['barangay', 'patientRecords.disease', 'patientRecords.doctorHospital']) // Change 'hospital' to 'doctorHospital'
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
            'disease_id' => 'required|exists:diseases,id',
            'email' => 'required|email|unique:users,email',
            'hospital_id' => 'required|exists:hospitals,id',
            'remarks' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            $nameParts = explode(' ', $request->input('fullName'));
            $firstName = strtolower($nameParts[0]);
            $lastName = strtolower(end($nameParts));
            $username = $firstName . '.' . $lastName . rand(1000, 9999);
            
            $user = User::create([
                'name' => $request->input('fullName'),
                'username' => $username,
                'email' => $request->input('email'),
                'password' => Hash::make($username),
                'birthdate' => $request->input('birthdate'),
                'barangay_id' => $request->input('barangay_id'),
                'user_type' => 'patient',
                'is_approved' => true,
                'profile_image' => 'images/profiles/default.png',
                'status' => 'Active'
            ]);
            // doctor-hospital relationship
            $doctorHospital = DoctorHospital::firstOrCreate([
                'doctor_id'   => Auth::id(),
                'hospital_id' => $request->input('hospital_id'),
            ]);

            PatientRecord::create([
                'patient_id' => $user->id,
                'doctor_id' => Auth::id(), 
                'doctor_hospital_id' => $doctorHospital->id, 
                'disease_id' => $request->input('disease_id'),
                'date_reported' => now(),
                'remarks' => $request->input('remarks'),
            ]);
        });

        return redirect()->route('admin.managepatients')->with('success', 'Patient record added successfully!');
    }

    /**
     * Display the specified patient's details and medical history.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */

    public function viewPatient(User $patient)
    {
        $patient->load([
            'barangay',
            'patientRecords.disease',
            'patientRecords.doctorHospital.hospital'
        ]);
        
        return view('admin.patient_details', compact('patient'));
    }
    
}