<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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

        // Generate a unique token for the password reset
        $token = base64_encode(random_bytes(40));

        // Store the token in the database (optional: create a PasswordReset model/table)
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => now()]
        );

        // Use Laravel's Mail facade to send the email
                Mail::send([], [], function ($message) use ($request, $token) {
                $message->to($request->email)
                    ->subject('Password Reset Request')
                    ->html('
                        <div style="font-family: Arial, sans-serif; line-height: 1.6; color: #333333; background-color: #f7f7f7; padding: 20px;">
                            <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 30px; border-radius: 8px; border-top: 5px solid #296E5B; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);">

                                <h2 style="color: #296E5B; margin-bottom: 25px; text-align: center;">🔒 Password Reset Request</h2>

                                <p style="margin-bottom: 20px; font-size: 12px;">
                                    You requested a password reset for the email address: <strong> '.$request->email.'</strong>.
                                </p>
                                <p>Your one-time reset token is below:</p>

                                <div style="background-color: #DCFCE7; padding: 15px 25px; margin: 25px 0; border-radius: 4px; text-align: center; border: 1px dashed #296E5B;">
                                    <p style="font-size: 14px; color: #296E5B; margin: 0;">**Your Reset Token:**</p>
                                    <h1 style="font-size: 14px; color: #296E5B; letter-spacing: 1px;">'
                                        . $token .
                                    '</h1>
                                </div>

                                <p style="font-size: 16px;">
                                    Open your mobile app and paste this token into the password reset screen to complete the process. This token is valid for a limited time.
                                </p>

                                <p style="margin-top: 30px; font-size: 14px; color: #666666; border-top: 1px solid #eeeeee; padding-top: 20px;">
                                    If you did not request a password reset, please ignore this email. Your password will remain unchanged.
                                </p>

                            </div>
                        </div>
                    ');
            });
        return response()->json([
            'message' => 'If the email exists, a password reset link has been sent.',
        ], 200);
    }

    public function resetPassword(Request $request)
    {
                $request->validate([
            'email' => 'required|email|exists:users,email',
            'token' => 'required',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Check token
        $data = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$data) {
            return response()->json([
                'message' => 'Invalid or expired token.'
            ], 400);
        }

        // Reset password
        $user = User::where('email', $request->email)->first();
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Delete used token
        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        return response()->json([
            'message' => 'Your password has been successfully reset.'
        ], 200);
    }
}