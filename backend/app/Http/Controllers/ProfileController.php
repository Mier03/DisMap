<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information and profile photo.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Fill name/email/username
        $user->fill($request->validated());

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if not default
            if ($user->profile_image && $user->profile_image !== 'images/profiles/default.png') {
                Storage::disk('public')->delete($user->profile_image);
            }

            // Store new image in /storage/app/public/profiles/{username}
            $path = $request->file('profile_image')->store(
                'profiles/' . $user->username,
                'public'
            );

            // Save relative path to DB
            $user->profile_image = $path;
        }

        // Reset verification if email changed
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();
        dd($request->file('profile_image'));
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
