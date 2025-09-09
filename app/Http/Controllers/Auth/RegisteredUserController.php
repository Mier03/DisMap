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

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register'); // naa ni siya sa views then auth folder the makita ni siya sa register.blade.php
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
                'hospital_name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255', 'unique:'.User::class],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'certification' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            ]);

            // Store certification file
            $certificationPath = $request->file('certification')->store(
                'certifications/'.$request->username, // makita ni siya sa storage-app-puclic-certifications-username
                'public'
            );

            // Create user with pending approval
            $user = User::create([
                'name' => $request->name,
                'hospital_name' => $request->hospital_name,
                'username' => $request->username,
                'user_type' => 'Doctor',
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'certification' => $certificationPath,
                'is_approved' => false, 
            ]);

            event(new Registered($user));

            // Don’t log them in yet
            return redirect()->route('welcome')
                ->with('success', 'Your account has been created. Please wait for admin approval.');
        }

}
