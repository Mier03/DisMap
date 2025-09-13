<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SuperAdminController extends Controller
{
    /**
     * Display the admin management page with search functionality
     */
    public function verifyAdmins(Request $request)
    {
        $searchTerm = $request->input('q');
        
        // Fetch pending admin users (Doctors with is_approved = false)
        $pendingAdmins = User::pendingAdmins()
            ->select('id', 'name', 'hospital_id', 'email', 'username', 'certification')
            ->when($searchTerm, function($query) use ($searchTerm) {
                return $query->where(function($q) use ($searchTerm) {
                    $q->where('name', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('username', 'LIKE', "%{$searchTerm}%");
                });
            })
             ->with('hospital') 
            ->get();
        
        // Fetch all approved admin users (Doctors with is_approved = true)
        $allAdmins = User::approvedAdmins()
            ->select('id', 'name', 'hospital_id', 'email', 'username', 'certification')
            ->when($searchTerm, function($query) use ($searchTerm) {
                return $query->where(function($q) use ($searchTerm) {
                    $q->where('name', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('username', 'LIKE', "%{$searchTerm}%");
                });
            })
            ->get();
        
        // If it's an AJAX request, return JSON
        if ($request->ajax()) {
            return response()->json([
                'pendingAdmins' => $pendingAdmins,
                'allAdmins' => $allAdmins
            ]);
        }
        
        return view('superadmin.verify_admins', compact('pendingAdmins', 'allAdmins', 'searchTerm'));
    }
    
    /**
     * Approve a pending admin.
     */
    public function approveAdmin($id)
    {
        try {
            $admin = User::findOrFail($id);
            
            // Verify this is actually a Doctor user
            if ($admin->user_type !== 'Doctor') {
                return back()->with('error', 'User is not a doctor');
            }
            
            $admin->is_approved = true;
            $admin->save();
            
            return back()->with('success', 'Doctor approved successfully');
        } catch (\Exception $e) {
            Log::error('Error approving doctor: ' . $e->getMessage());
            return back()->with('error', 'Error approving doctor');
        }
    }
    
    /**
     * Reject a pending admin.
     */
    public function rejectAdmin($id)
    {
        try {
            $admin = User::findOrFail($id);
            
            // Verify this is actually a Doctor user
            if ($admin->user_type !== 'Doctor') {
                return back()->with('error', 'User is not a doctor');
            }
            
            $admin->delete();
            
            return back()->with('success', 'Doctor rejected successfully');
        } catch (\Exception $e) {
            Log::error('Error rejecting doctor: ' . $e->getMessage());
            return back()->with('error', 'Error rejecting doctor');
        }
    }
    
    /**
     * Delete an admin.
     */
    public function deleteAdmin($id)
    {
        try {
            $admin = User::findOrFail($id);
            
            // Verify this is actually a Doctor user
            if ($admin->user_type !== 'Doctor') {
                return back()->with('error', 'User is not a doctor');
            }
            
            $admin->delete();
            
            return back()->with('success', 'Doctor deleted successfully');
        } catch (\Exception $e) {
            Log::error('Error deleting doctor: ' . $e->getMessage());
            return back()->with('error', 'Error deleting doctor');
        }
    }
    
    /**
     * View admin details.
     */
    public function viewAdmin($id)
    {
        try {
            $admin = User::findOrFail($id);
            
            // Verify this is actually a Doctor user
            if ($admin->user_type !== 'Doctor') {
                return back()->with('error', 'User is not a doctor');
            }
            
            return view('superadmin.admin_details', compact('admin'));
        } catch (\Exception $e) {
            Log::error('Error fetching doctor details: ' . $e->getMessage());
            return back()->with('error', 'Error fetching doctor details');
        }
    }
}