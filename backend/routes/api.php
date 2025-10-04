<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (!Auth::attempt($credentials)) {
        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    $user = Auth::user();

    // Only allow Patients
    if ($user->user_type !== 'Patient') {
        return response()->json(['error' => 'Only patients can login'], 403);
    }

    // Generate token
    $token = $user->createToken('mobile-app')->plainTextToken;

    return response()->json([
        'token' => $token,
        'user'  => $user
    ]);
});
