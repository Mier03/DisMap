<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ApiUserController extends Controller
{
    /**
     * Get the logged-in user's profile (name and birthday).
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile(Request $request)
    {
        $user = Auth::user();

        return response()->json([
            'name' => $user->name,
            'birthdate' => $user->birthdate,
            'email' => $user->email,
            'ethnicity' =>$user->ethnicity,
            'street_address' =>$user->street_address,
            'contact_number' =>$user->contact_number,
            'profile_image' =>$user->profile_image,
        ]);
    }

    public function updatePassword(Request $request)
    {
        // 1. Validation
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // 2. Get the authenticated user via the 'auth:sanctum' middleware
        $user = $request->user();

        // Check if the user object was retrieved
        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized or user not found.'
            ], 401);
        }

        // 3. Update the password and clear the default flag
        $user->forceFill([
            'password' => Hash::make($request->password),
            // ASSUMPTION: You have a column to flag default passwords.
            // This is CRITICAL to prevent users from being routed back to the update page.
            'is_default_password' => false, 

        ])->save();

        // 4. Return success response
        return response()->json([
            'message' => 'Password updated successfully.',
        ], 200);
    }

    public function uploadProfileImage(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();

        $image = $request->file('profile_image');
        $imageName = time().'_'.$image->getClientOriginalName();
        $image->move(public_path('uploads/profile_images'), $imageName);

        $user->profile_image = url('uploads/profile_images/'.$imageName);
        $user->save();

        return response()->json([
            'message' => 'Profile image updated successfully',
            'profile_image' => $user->profile_image
        ]);
    }
}
