<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;

class UserPasswordResetController extends Controller
{
    /**
     * Handle user password change.
     */
    public function update(Request $request): RedirectResponse
    {
        // Validate all fields
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();

        // Verify the old password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'The current password is incorrect.',
            ]);
        }

        // Update the password
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Optionally regenerate session to prevent old session reuse
        $request->session()->regenerate();

        // Redirect back with success message
        return back()
        ->with('success', 'Password updated successfully!');
    }
}
