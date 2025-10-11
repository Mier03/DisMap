<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DataRequest;
class DataRequestController extends Controller
{
   /**
     * Store a new data request submission.
     */
    public function store(Request $request)
    {
        // ✅ Validate inputs
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'requested_disease' => 'required|string|max:255',
            'fromDate' => 'required|date',
            'toDate' => 'required|date|after_or_equal:fromDate',
            'reason' => 'required|string|max:1000',
        ]);

        // ✅ Save to database
        DataRequest::create([
            'name' => $validated['full_name'],
            'email' => $validated['email'],
            'purpose' => $validated['reason'],
            'requested_disease' => $validated['requested_disease'],
            'from_date' => $validated['fromDate'],
            'to_date' => $validated['toDate'],
            'status' => 'pending', // Default status
        ]);

        return redirect()->back()->with('success', 'Your data request has been submitted successfully!');
    }
}
