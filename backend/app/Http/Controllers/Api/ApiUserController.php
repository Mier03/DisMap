<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        ]);
    }
}
