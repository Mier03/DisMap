<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\DoctorHospital;
use Illuminate\Support\Facades\DB;

class SuperAdminController extends Controller
{
    public function verifyAdmins(Request $request)
    {
        $searchTerm = $request->input('q');
        
        $pendingAdmins = User::pendingAdmins()
            ->when($searchTerm, function ($query) use ($searchTerm) {
                return $query->where('name', 'LIKE', "%{$searchTerm}%")
                             ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                             ->orWhere('username', 'LIKE', "%{$searchTerm}%");
            })
            ->with('hospitals')
            ->get();

        $allAdmins = User::approvedAdmins()
            ->when($searchTerm, function ($query) use ($searchTerm) {
                return $query->where('name', 'LIKE', "%{$searchTerm}%")
                             ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                             ->orWhere('username', 'LIKE', "%{$searchTerm}%");
            })
            ->with('hospitals')
            ->get();
        
        if ($request->ajax()) {
            return response()->json([
                'pendingAdmins' => $pendingAdmins,
                'allAdmins' => $allAdmins
            ]);
        }
        
        return view('superadmin.verify_admins', compact('pendingAdmins', 'allAdmins', 'searchTerm'));
    }
    

   public function approveAdmin($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $user = User::findOrFail($id);

                // Verify this is actually a Doctor user
                if ($user->user_type !== 'Doctor') {
                    return back()->with('error', 'User is not a doctor');
                }

                // Update the is_approved status on the users table
                $user->is_approved = true;
                $user->save();
            });

            return back()->with('success', 'Doctor approved successfully');
        } catch (\Exception $e) {
            Log::error('Error approving doctor: ' . $e->getMessage());
            return back()->with('error', 'Error approving doctor');
        }
    }

    //----------------------------------------------------

    /**
     * Reject a pending admin.
     */
    public function rejectAdmin($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $user = User::findOrFail($id);

                // Verify this is actually a Doctor user
                if ($user->user_type !== 'Doctor') {
                    return back()->with('error', 'User is not a doctor');
                }
                
                // If you don't have ON DELETE CASCADE, detach first
                $user->hospitals()->detach();

                // Delete the user record, which effectively rejects them
                $user->delete();
            });
            
            return back()->with('success', 'Doctor rejected successfully');
        } catch (\Exception $e) {
            Log::error('Error rejecting doctor: ' . $e->getMessage());
            return back()->with('error', 'Error rejecting doctor');
        }
    }

    //----------------------------------------------------

    /**
     * Delete an admin.
     */
    public function deleteAdmin($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $user = User::findOrFail($id);

                // Verify this is actually a Doctor user
                if ($user->user_type !== 'Doctor') {
                    return back()->with('error', 'User is not a doctor');
                }
                
                // If you don't have ON DELETE CASCADE, detach first
                $user->hospitals()->detach();

                // Delete the user record
                $user->delete();
            });

            return back()->with('success', 'Doctor deleted successfully');
        } catch (\Exception $e) {
            Log::error('Error deleting doctor: ' . $e->getMessage());
            return back()->with('error', 'Error deleting doctor');
        }
    }


    public function viewAdmin($id)
    {
        try {
            // $admin = User::findOrFail($id);
            $admin = User::with('hospitals')->findOrFail($id);
            
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