<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hospital;
use App\Models\DoctorHospital; // if you use this pivot model
class DoctorHospitalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        // Get all hospitals already linked (approved or pending)
        $assignedHospitalIds = DoctorHospital::where('doctor_id', $user->id)->pluck('hospital_id');

        // Fetch only hospitals not yet linked
        $hospitals = Hospital::whereNotIn('id', $assignedHospitalIds)->get();

        // Return dashboard / settings view (the one including form-modals.blade.php)
        return view('admin.accountsettings', [  // replace with your actual view name
            'user' => $user,
            'hospitals' => $hospitals,
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'hospital_id' => 'required|exists:hospitals,id',
            'certification' => 'required|file|mimes:pdf,jpg,png|max:2048',
        ]);
        
        $user = auth()->user();  // <-- this defines $user
        
         // Upload file to a folder specific for the user
        $certificationPath = $request->file('certification')->store(
            'certifications/' . $user->username, // folder per doctor
            'public'
        );

        // Check if this doctor already has an existing record for this hospital
    $existing = DoctorHospital::where('doctor_id', $user->id)
        ->where('hospital_id', $request->hospital_id)
        ->first();

    if ($existing) {
        // If record exists, update status and certification file
        $existing->update([
            'status' => 'pending',
            'certification' => $certificationPath,
        ]);

        return back()->with('success', 'Hospital reapplication submitted successfully! Status set to pending.');
    }

        // Save to doctor_hospitals
        DoctorHospital::create([
            'doctor_id' => auth()->id(),
            'hospital_id' => $request->hospital_id,
            'certification' =>$certificationPath,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Hospital request submitted successfully! Pending approval.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

   /**
 * Mark a hospital as removed instead of deleting the record.
 */
    public function unassign($hospitalId)
    {
        $user = auth()->user();

        // Find the pivot record
        $doctorHospital = DoctorHospital::where('doctor_id', $user->id)
            ->where('hospital_id', $hospitalId)
            ->first();

        if (!$doctorHospital) {
            return back()->with('error', 'Hospital relationship not found.');
        }

        // Update status to "removed"
        $doctorHospital->status = 'removed';
        $doctorHospital->save();

        return back()->with('success', 'Hospital has been marked as removed.');
    }
}
