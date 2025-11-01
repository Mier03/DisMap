<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barangay;
use App\Models\Disease;
use App\Models\PatientRecord;
use App\Models\User;

class HeatmapController extends Controller
{
 

 public function index(Request $request)
    {
        // 1. Initialize the query for PatientRecords
        $query = PatientRecord::query();
        
        // 2. Load necessary lookup data (Users and Diseases)
        // We eager-load the barangay relationship from the user for efficiency
        $usersWithBarangay = User::with('barangay')->get()->keyBy('id');
        $diseasesLookup = Disease::get()->keyBy('id');


        // 3. Apply Filters

        if ($request->barangay_id) {
            $userIds = User::whereIn('barangay_id', explode(',', $request->barangay_id))->pluck('id');
            $query->whereIn('patient_id', $userIds);
        }

        if ($request->disease_id) {
            $query->whereIn('disease_id', explode(',', $request->disease_id));
        }

        // The severity filter has been removed as it is not used on the frontend.
        

        // 4. Execute query and aggregate
        $filteredPatientRecords = $query->get();

        // 5. Group records by their associated Barangay ID (retrieved via the User relationship)
        $data = $filteredPatientRecords
            ->groupBy(function ($record) use ($usersWithBarangay) {
                // Safely check if the User exists before trying to access the barangay_id
                $user = $usersWithBarangay[$record->patient_id] ?? null;
                return $user->barangay_id ?? null; // Returns null if user or barangay_id is missing
            })
            // Remove groups where the Barangay ID could not be found
            ->filter(fn ($group, $barangayId) => $barangayId !== null)
            ->map(function ($group) use ($usersWithBarangay, $diseasesLookup) {
                $firstRecord = $group->first();
                $user = $usersWithBarangay[$firstRecord->patient_id]; // User is guaranteed to exist here due to $usersWithBarangay load
                $barangay = $user->barangay;

                // Return the aggregated data structure expected by the frontend
                return [
                    'barangay_name' => $barangay->name ?? 'Unknown',
                    // CRITICAL: Cast to float to ensure Leaflet.Heat accepts the coordinates
                    'latitude' => (float) $barangay->latitude,
                    'longitude' => (float) $barangay->longitude,
                    'count' => $group->count(),
                    'diseases' => $group->pluck('disease_id')
                        ->unique()
                        ->map(fn ($id) => $diseasesLookup[$id]->specification ?? 'Unknown Disease')
                        ->filter()
                        ->values(),
                ];
            })
            ->values();

        return response()->json($data);
    }
    
    public function filters()
    {
        // return response()->json(compact('barangays', 'diseases'));
    }
}
