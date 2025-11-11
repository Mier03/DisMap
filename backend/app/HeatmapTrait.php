<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Barangay;
use App\Models\Disease;
use App\Models\PatientRecord;
use App\Models\User;

trait HeatmapTrait
{
    public function getHeatmap(Request $request)
    {
         $activeDiseases = Disease::whereIn('id',  PatientRecord::distinct('disease_id')
            ->where('status', 'Active')
            ->pluck('disease_id')
        )->withCount([
            'patientRecords as active_patient_count' => function ($query) {
                $query->where('status', 'Active');
            }
        ])->get(['id', 'specification']);

        $activeBarangays = User::whereHas('patientRecords', function ($subQuery) {
                    $subQuery->where('status', 'Active'); // only Active records
                })
                ->with('barangay:id,name,latitude,longitude')
                ->get()
                ->pluck('barangay')
                ->filter() // remove nulls (if some users have no barangay)
                ->unique('id')
                ->values(); // its return a collection of Barangays
        
        $filterQuery = DB::table('barangays')
            ->join('users', 'users.barangay_id', '=', 'barangays.id')
            ->join('patient_records', 'patient_records.patient_id', '=', 'users.id')
            ->join('diseases', 'diseases.id', '=', 'patient_records.disease_id')
            ->select(
                'barangays.id',
                'barangays.name',
                'barangays.latitude',
                'barangays.longitude',
                'diseases.specification',
                DB::raw('COUNT(patient_records.id) as patient_count'),
            )
            ->where('patient_records.status', 'Active')
            // allow searching by a free-form term that matches disease specification or barangay name
            ->when(
                $request->filled('term'),
                function ($q) use ($request) {
                    $term = '%'.$request->term.'%';
                    $q->where(function ($sub) use ($term) {
                        $sub->where('diseases.specification', 'like', $term)
                            ->orWhere('barangays.name', 'like', $term);
                    });
                }
            )
            ->when(
                $request->filled('barangays'), 
                fn($q) => $q->whereIn('barangays.id', $request->barangays)
            )->when(
                $request->filled('disease_type'), 
                fn($q) => $q->whereIn('diseases.id', $request->disease_type)
            )->groupBy('barangays.id', 'barangays.name', 'barangays.latitude', 'barangays.longitude', 'diseases.specification')
            ->get();

        $filterResults = $filterQuery->groupBy('name')
            ->map(function ($items) {
                $barangay = $items->first();

                return [
                    ...collect($barangay)->only(['id', 'name', 'latitude', 'longitude']),
                    'total_patient_count' => $items->sum('patient_count'),
                    'diseases' => $items->map(function ($d) {
                        return [
                            'name' => $d->specification,
                            'patient_count' => $d->patient_count,
                        ];
                    })
                ];
        }); 
       
        $activeFilters = $this->formatActiveFilters($request);

        return compact('activeBarangays', 'activeDiseases', 'filterResults', 'activeFilters');
    }
    
      public function diseaseRecords()
    {
        // Ensure the diseaserecords view is always rendered by DiseaseController@index
        // which supplies the required stat variables. Redirecting prevents accidental
        // direct rendering of the view without those variables.
        return redirect()->route('diseaserecords');
    }

     protected function formatActiveFilters($request)
    {
         // Build a human-friendly list of active filters, including an optional search term
        $activeFilters = [
            ...Barangay::whereIn('id', $request->barangays ?? [])
                ->pluck('name')
                ->toArray(),
            ...Disease::whereIn('id', $request->disease_type ?? [])
                ->pluck('specification')
                ->toArray(),
            ...$request->filled('term') ? [$request->term] : [],
        ];

        if (empty($activeFilters)) {
            return;
        }

        $html = '';

        foreach ($activeFilters as $filter) {
            $html .= '<span class="inline-flex items-center bg-green-50 text-green-700 border border-green-200 px-3 py-1 rounded-full text-sm mr-2 hover:bg-green-100 transition">
                <span>'.$filter.'</span>
                <button class="ml-2 w-4 h-4 flex items-center justify-center text-green-500 hover:text-green-700 focus:outline-none rounded-full hover:bg-green-200 transition remove-filter" data-value="4">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </span>';
        }

        return $html;
    }
}
