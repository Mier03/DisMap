<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Hospital;
use App\Models\Barangay;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    /**
     * Display a listing of patients and hospitals.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $searchTerm = $request->input('q');

        $patients = Patient::query()
            ->when($searchTerm, function($query, $searchTerm) {
                $query->where('name', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('diagnosis', 'LIKE', "%{$searchTerm}%");
            })
            ->get();
            
        $userId = Auth::id();
        $hospitals = Hospital::whereHas('users', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->get();
        $barangays = Barangay::all();
        return view('admin.managepatients', [
            'patients' => $patients,
            'hospitals' => $hospitals,
            'barangays' => $barangays,
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
        // Validate the incoming request data
        $request->validate([
            'fullName' => 'required|string|max:255',
            'age' => 'required|integer|min:0',
            'barangay_id' => 'required|exists:barangays,id',
            'diagnosis' => 'required|string|max:255',
            'email' => 'required|email|unique:patients,email',
            'hospital_id' => 'required|exists:hospitals_table,id',
        ]);

        // Create a new patient record
        $patient = new Patient();
        $patient->name = $request->input('fullName');
        $patient->age = $request->input('age');
        $patient->barangay_id = $request->input('barangay_id');
        $patient->diagnosis = $request->input('diagnosis');
        $patient->hospital_id = $request->input('hospital_id');
        $patient->date_reported = now();
        $patient->status = 'Active';
        
        // Generate a username based on the full name
        $nameParts = explode(' ', $request->input('fullName'));
        $firstName = strtolower($nameParts[0]);
        $lastName = strtolower(end($nameParts));
        $patient->username = $firstName . '.' . $lastName . rand(1000, 9999);
        $patient->email = $request->input('email');

        $patient->save();

        return redirect()->route('admin.managepatients')->with('success', 'Patient record added successfully!');
    }

    /**
     * Update the specified patient record in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Patient $patient)
    {
        $request->validate([
            'fullName' => 'required|string|max:255',
            'age' => 'required|integer|min:0',
            'barangay_id' => 'required|exists:barangays,id',
            'diagnosis' => 'required|string|max:255',
            'status' => 'required|string|in:Active,Recovered,Deceased',
        ]);

        $patient->name = $request->input('fullName');
        $patient->age = $request->input('age');
        $patient->barangay_id = $request->input('barangay_id');
        $patient->diagnosis = $request->input('diagnosis');
        $patient->status = $request->input('status');
        
        $patient->save();

        return redirect()->route('admin.managepatients')->with('success', 'Patient record updated successfully!');
    }

    /**
     * Remove the specified patient from the database.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()->route('admin.managepatients')->with('success', 'Patient record deleted successfully!');
    }
}