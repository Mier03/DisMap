<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Show the edit profile page.
     */
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile (name, username, email).
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . Auth::id()],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . Auth::id()],
            'profile_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        $user = $request->user();
        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null; // re-verify if email changes
        }

                if ($request->hasFile('profile_image')) {
            // Delete old image (if not default)
            if ($user->profile_image && $user->profile_image !== 'images/profiles/defaultprofile.jpg') {
                Storage::disk('public')->delete($user->profile_image);
            }

            // Store new one under public/profiles/username/
            $path = $request->file('profile_image')->store(
                'profiles/' . $user->username,
                'public'
            );

            $user->profile_image = $path;
        }

        $user->save();

        return back()->with('status', 'profile-updated');

    }
}