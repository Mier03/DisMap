<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ApiAuthController extends Controller
{
    // ==============================
    //        LOGIN
    // ==============================
    public function login(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'email'    => 'required|email|exists:users,email',
            'password' => 'required',
        ]);

        if($validated->fails()){
            return response()->json([
                'message' => $validated->errors()->first()
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (! $user 
            || !Hash::check($request->password, $user->password)
        ) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        return response()->json([
            'token' => $user->createToken('authToken')->plainTextToken,
            'user' => $user
        ]);
    }

    public function forgotPasswordRequest(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'The provided email address was not found.',
        ]);
        
        return response()->json([
            'message' => 'If the email exists, a password reset link has been sent.',
        ], 200);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email', // Check if user exists
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'email.exists' => 'The provided email address was not found.',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'message' => 'User not found.'
            ], 404);
        }

        $user->forceFill([
            'password' => Hash::make($request->password),
            'is_default_password' => false, 
        ])->save();

        return response()->json([
            'message' => 'Your password has been successfully reset.'
        ], 200);
    }

}