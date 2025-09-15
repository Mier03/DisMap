<x-app-layout>
    <x-certificate-modal />

    <div class="bg-g-bg flex min-h-screen w-full">
        {{-- Sidebar --}}
        @include('layouts.sidebar')

        {{-- Main Content --}}
        <div class="ml-64 flex-1 py-12 px-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden">
                    <div class="p-6 bg-inherit text-gray-900">
                        
                        {{-- Header --}}
                        <x-page-header title="Manage Patients" subtitle="Patient Records" buttonText="Export"/>

                        {{-- Search --}}
                        <div class="flex items-start justify-between">
                            <div class="w-full mr-4">
                                <form method="GET" action="{{ route('admin.managepatients') }}">
                                    <x-search-bar placeholder="Search patients..." value="{{ request('q') }}" />
                                </form>
                            </div>
                            <button
                                onclick="openModal('addPatientModal')"
                                class="bg-g-dark text-white px-4 py-2 rounded-lg hover:bg-[#296E5B]/90 transition shrink-0">
                                + Add Patient
                            </button>
                        </div>
                        
                        {{-- All Patient Records Table --}}
                        @php
                            $patients = $patients ?? [];
                            $patientColumns = ['Name', 'Birthdate', 'Barangay', 'Disease', 'Hospital', 'Date Reported', 'Status'];
                            $patientRows = collect($patients)->map(function ($patient) {
                                $latestRecord = $patient->patientRecords->first();

                                // Default values if no record exists
                                $disease = $latestRecord->disease->specification ?? 'N/A';
                                $hospital = $latestRecord->hospital->name ?? 'N/A';
                                $dateReported = $latestRecord->date_reported ? \Carbon\Carbon::parse($latestRecord->date_reported)->format('F j, Y') : 'N/A';
                                $statusType = $latestRecord->status_type ?? 'No Records';
                                $statusClass = $latestRecord
                                    ? ($latestRecord->status_type === 'Active' ? 'bg-yellow-200 text-yellow-800' : ($latestRecord->status_type === 'Recovered' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800'))
                                    : 'bg-gray-200 text-gray-800';
                                    
                                return [
                                    "<a href='".route('admin.view_patients', $patient->id)."' class='text-blue-600 hover:underline'>{$patient->name}</a>",
                                    \Carbon\Carbon::parse($patient->birthdate)->format('F j, Y'),
                                    $patient->barangay->name ?? 'N/A',
                                    $disease,
                                    $hospital,
                                    $dateReported,
                                    "<span class='px-2 py-1 rounded text-sm {$statusClass}'>{$statusType}</span>",
                                ];
                            })->toArray();
                        @endphp
                        
                        <x-table
                            :columns="$patientColumns"
                            :rows="$patientRows"
                            table_title="All Patient Records"
                            icon="gmdi-people-alt-o"
                        />

                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-modal
        id="addPatientModal"
        title="Add Patient"
        message="Record a new patient case"
        confirmButtonText="+ Add Patient"
        cancelButtonText="Cancel"
        buttonId="addPatientButton"
        action="{{ route('admin.patients.store') }}"
        method="POST"
        :fields="[
            ['name' => 'fullName', 'label' => 'Full Name', 'type' => 'text', 'placeholder' => 'Enter patient full name...', 'required' => true],
            ['name' => 'birthdate', 'label' => 'Birthdate', 'type' => 'date', 'placeholder' => '', 'required' => true],
            ['name' => 'barangay_id', 'label' => 'Barangay', 'type' => 'select', 'placeholder' => 'Select barangay...', 'required' => true, 'options' => $barangays->map(function($b) { return ['value' => $b->id, 'label' => $b->name]; })->toArray()],
            ['name' => 'disease_id', 'label' => 'Disease', 'type' => 'select', 'placeholder' => 'Select patient\'s disease...', 'required' => true, 'options' => $diseases->map(function($d) { return ['value' => $d->id, 'label' => $d->specification]; })->toArray()],
            ['name' => 'remarks', 'label' => 'Remarks', 'type' => 'text', 'placeholder' => 'Enter any relevant remarks...', 'required' => false],
            ['name' => 'hospital_id', 'label' => 'Hospital', 'type' => 'select', 'placeholder' => 'Select hospital...', 'required' => true, 'options' => $hospitals->map(function($h) { return ['value' => $h->id, 'label' => $h->name]; })->toArray()],
            ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'placeholder' => 'Enter valid email address...', 'required' => true]
        ]"
    />
</x-app-layout>