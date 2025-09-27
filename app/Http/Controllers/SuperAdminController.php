<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\DoctorHospital;
use App\Models\Hospital;
use App\Models\Barangay;
use App\Models\Disease;
use App\Models\DataRequest;
use Illuminate\Support\Facades\DB;

class SuperAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function verifyAdmins(Request $request)
    {
        $searchTerm = $request->input('q');

        // This function defines the base search logic for reuse
        $baseQuery = function ($query) use ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('username', 'LIKE', "%{$searchTerm}%")
                    // Search within the related 'hospitals' table by name
                    ->orWhereHas('hospitals', function ($subQuery) use ($searchTerm) {
                        $subQuery->where('name', 'LIKE', "%{$searchTerm}%");
                    });
            });
        };

        // Get pending admins matching the search term
        $pendingAdmins = User::pendingAdmins()
            ->when($searchTerm, $baseQuery)
            ->with('hospitals')
            ->get();

        // Get all approved admins matching the search term
        $allAdmins = User::approvedAdmins()
            ->when($searchTerm, $baseQuery)
            ->with('hospitals')
            ->get();

        // For AJAX requests, return rendered HTML of the tables
        if ($request->ajax()) {
            // Render the pending admins table component into an HTML string
            $pendingHtml = view('components.tables', [
                'tableType' => 'pendingAdmins',
                'data' => $pendingAdmins,
                'title' => 'Pending Approvals',
                'icon' => 'gmdi-person-search-o'
            ])->render();

            // Render the all admins table component into an HTML string
            $allHtml = view('components.tables', [
                'tableType' => 'allAdmins',
                'data' => $allAdmins,
                'title' => 'All Administrators',
                'icon' => 'gmdi-admin-panel-settings'
            ])->render();

            return response()->json([
                'pendingHtml' => $pendingHtml,
                'allHtml' => $allHtml
            ]);
        }

        // For standard page loads, return the full view
        return view('superadmin.verify_admins', compact('pendingAdmins', 'allAdmins', 'searchTerm'));
    }

    /**
     * Approve a pending admin.
     */
    public function approveAdmin($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $user = User::findOrFail($id);

                if ($user->user_type !== 'Doctor') {
                    throw new \Exception('User is not a doctor');
                }

                $user->is_approved = true;
                $user->status = 'Active';
                $user->save();
            });

            return redirect()->route('superadmin.verify_admins')->with('success', 'Doctor approved successfully');
        } catch (\Exception $e) {
            Log::error('Error approving doctor: ' . $e->getMessage());
            $errorMessage = $e->getMessage() === 'User is not a doctor' ? $e->getMessage() : 'Error approving doctor';
            return back()->with('error', $errorMessage);
        }
    }

    /**
     * Reject a pending admin.
     */
    public function rejectAdmin($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $user = User::findOrFail($id);

                if ($user->user_type !== 'Doctor') {
                    throw new \Exception('User is not a doctor');
                }

                $user->hospitals()->detach();
                $user->delete();
            });
            return redirect()->route('superadmin.verify_admins')->with('success', 'Doctor rejected successfully');
        } catch (\Exception $e) {
            Log::error('Error rejecting doctor: ' . $e->getMessage());
            $errorMessage = $e->getMessage() === 'User is not a doctor' ? $e->getMessage() : 'Error rejecting doctor';
            return back()->with('error', $errorMessage);
        }
    }

    /**
     * Delete an admin.
     */
    public function deleteAdmin($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $user = User::findOrFail($id);

                if ($user->user_type !== 'Doctor') {
                    throw new \Exception('User is not a doctor');
                }

                $user->hospitals()->detach();
                $user->delete();
            });

            return redirect()->route('superadmin.verify_admins')->with('success', 'Doctor deleted successfully');
        } catch (\Exception $e) {
            Log::error('Error deleting doctor: ' . $e->getMessage());
            $errorMessage = $e->getMessage() === 'User is not a doctor' ? $e->getMessage() : 'Error deleting doctor';
            return back()->with('error', $errorMessage);
        }
    }

    /**
     * Display the specified admin.
     */
    public function viewAdmin($id)
    {
        try {
            $admin = User::with('hospitals')->findOrFail($id);
            $hospitals = Hospital::all();

            if ($admin->user_type !== 'Doctor') {
                return back()->with('error', 'User is not a doctor');
            }

            return view('superadmin.admin_details', compact('admin', 'hospitals'));
        } catch (\Exception $e) {
            Log::error('Error fetching doctor details: ' . $e->getMessage());
            return back()->with('error', 'Error fetching doctor details');
        }
    }

    /**
     * Update the specified admin in storage.
     */
    public function updateAdmin(Request $request, $id)
    {
        try {
            $admin = User::findOrFail($id);

            // Define validation rules
            $validationRules = [
                'name' => 'required|string|max:255',
                'username' => 'required|string|unique:users,username,' . $id,
            ];

            // Add status validation based on whether admin is approved
            if ($admin->is_approved) {
                $validationRules['status'] = 'required|in:Active,Inactive';
            } else {
                $validationRules['is_approved'] = 'required|boolean';
            }

            $request->validate($validationRules);

            DB::transaction(function () use ($request, $admin) {
                $updateData = [
                    'name' => $request->name,
                    'username' => $request->username
                ];

                // Update status based on whether admin is approved
                if ($admin->is_approved) {
                    $updateData['status'] = $request->status;
                } else {
                    $updateData['is_approved'] = $request->is_approved;
                    // If approving for the first time, set status to Active
                    if ($request->is_approved && !$admin->is_approved) {
                        $updateData['status'] = 'Active';
                    }
                }

                $admin->update($updateData);
            });

            return redirect()->route('superadmin.view_admin', $admin->id)
                ->with('success', 'Admin updated successfully');
        } catch (\Exception $e) {
            Log::error('Error updating admin: ' . $e->getMessage());
            return back()->with('error', 'Error updating admin: ' . $e->getMessage());
        }
    }

    /**
     * Show superadmin dashboard with required filter data.
     */
    public function home()
    {
        $barangays = Barangay::all();
        $diseases = Disease::all();

        return view('dashboard', compact('barangays', 'diseases'));
    }

    /**
     * Full dashboard for superadmin that includes filters/map.
     */
    public function dashboard()
    {
        $barangays = Barangay::all();
        $diseases = Disease::all();

        return view('superadmin.dashboard', compact('barangays', 'diseases'));
    }


    /**
     * Display data requests with search functionality.
     */
    public function datarequest(Request $request)
    {
        $searchTerm = $request->input('q');

        // Get data requests with search
        $dataRequests = DataRequest::with('handledBy')
        ->where('status', 'pending') 
            ->when($searchTerm, function ($query) use ($searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('name', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('requested_disease', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('purpose', 'LIKE', "%{$searchTerm}%");
                });
            })
            ->latest()
            ->get();

        $pendingHospitals = DoctorHospital::with(['doctor', 'hospital'])
            ->where('status', 'pending')
            ->when($searchTerm, function ($query) use ($searchTerm) {
                $query->whereHas('doctor', function ($q) use ($searchTerm) {
                    $q->where('name', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                        ->orWhere('username', 'LIKE', "%{$searchTerm}%");
                })
                    ->orWhereHas('hospital', function ($q) use ($searchTerm) {
                        $q->where('name', 'LIKE', "%{$searchTerm}%");
                    });
            })
            ->get();

        // return view('superadmin.datarequest', compact('pendingHospitals', 'searchTerm'));
        return view('superadmin.datarequest', compact('dataRequests', 'pendingHospitals', 'searchTerm'));
    }


    /**
     * Store new data request from public users
     */
    public function storeDataRequest(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'purpose' => 'required|string',
            'requested_disease' => 'required|string|max:255',
        ]);

        DataRequest::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'purpose' => $validated['purpose'],
            'requested_disease' => $validated['requested_disease'],
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Data request submitted successfully!');
    }

    /**
 * Update data request status (approve/reject)
 */
public function updateDataRequestStatus(Request $request, $id)
{
    try {
        $dataRequest = DataRequest::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $dataRequest->update([
            'status' => $validated['status'],
            'handled_by_admin_id' => auth()->id(),
            'updated_at' => now(),
        ]);

        // For AJAX requests (modal form), return JSON response
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Data request status updated!']);
        }

        // For regular form submissions (table buttons), redirect
        return redirect()->route('superadmin.datarequest')->with('success', 'Data request status updated!');
    } catch (\Exception $e) {
        Log::error('Error updating data request: ' . $e->getMessage());
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => false, 'error' => 'Error updating data request'], 500);
        }
        
        return back()->with('error', 'Error updating data request');
    }
}

    /**
     * Get individual data request details for modal
     */
    public function getDataRequest($id)
    {
        try {
            $dataRequest = DataRequest::findOrFail($id);
            
            return response()->json([
                'name' => $dataRequest->name,
                'email' => $dataRequest->email,
                'requested_type' => $dataRequest->requested_type,
                'requested_disease' => $dataRequest->requested_disease,
                'purpose' => $dataRequest->purpose,
                'status' => $dataRequest->status,
                'created_at' => $dataRequest->created_at,
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching data request: ' . $e->getMessage());
            return response()->json(['error' => 'Data request not found'], 404);
        }
    }
}
