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
}