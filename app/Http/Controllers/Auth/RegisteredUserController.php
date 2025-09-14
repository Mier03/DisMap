<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\Hospital;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
            $hospitals = Hospital::all(); // fetch all hospitals
           return view('auth.register', compact('hospitals')); // naa ni siya sa views then auth folder the makita ni siya sa register.blade.php
    }
 
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
   public function store(Request $request): RedirectResponse
        {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'hospital_id' => ['required', 'exists:hospitals,id'],
                'username' => ['required', 'string', 'max:255', 'unique:'.User::class],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'certification' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            ]);

            // Store certification file
            $certificationPath = $request->file('certification')->store(
                'certifications/'.$request->username,
                'public'
            );
            // Set default profile image path
                $profileImagePath = 'images/profiles/default.png'; // default image in public/images/profiles

                // If user uploaded a custom profile image, store it in their folder
                if ($request->hasFile('profile_image')) {
                    $profileImagePath = $request->file('profile_image')->store(
                        'profiles/' . $request->username, // stored in storage/app/public/profiles/username
                        'public'
                    );
                }

            // Create user with hospital_id instead of hospital_name
            $user = User::create([
                'name' => $request->name,
                'hospital_id' => $request->hospital_id,
                'username' => $request->username,
                'user_type' => 'Doctor',
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'certification' => $certificationPath,
                'profile_image' => $profileImagePath,
                'is_approved' => false, 
            ]);



            event(new Registered($user));

            // Don’t log them in yet
            return redirect()->route('welcome')
                ->with('success', 'Your account has been created. Please wait for admin approval.');
        }

}
