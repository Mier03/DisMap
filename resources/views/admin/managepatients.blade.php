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
                            $patientColumns = ['Name', 'Birthdate', 'Barangay', 'Latest Date Reported', 'Status'];
                            $patientRows = collect($patients)->map(function ($patient) {
                                $latestRecord = $patient->patientRecords->first();

                                if ($latestRecord) {
                                    $dateReported = \Carbon\Carbon::parse($latestRecord->created_at)->format('F j, Y') ?? 'N/A';
                                    $statusType = $latestRecord->patient->status ?? 'No Records';                                         
                                    $statusClass = '';
                                    if ($statusType === 'Active') {
                                        $statusClass = 'bg-yellow-200 text-yellow-800';
                                    } elseif ($statusType === 'Recovered') {
                                        $statusClass = 'bg-green-200 text-green-800';
                                    } elseif ($statusType === 'Deceased') {
                                        $statusClass = 'bg-red-200 text-red-800';
                                    } else {
                                        $statusClass = 'bg-gray-200 text-gray-800';
                                    }
                                } else {
                                    // Default values when no record exists
                                    $dateReported = 'N/A';
                                    $statusType = 'No Records';
                                    $statusClass = 'bg-gray-200 text-gray-800';
                                }
                                    
                                return [
                                    "<a href='".route('admin.view_patients', $patient->id)."' class='text-blue-600 hover:underline'>{$patient->name}</a>",
                                    \Carbon\Carbon::parse($patient->birthdate)->format('F j, Y'),
                                    $patient->barangay->name ?? 'N/A',
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

    <x-modals.form-modals
        id="addPatientModal"
        formType="addPatient"
        action="{{ route('admin.patients.store') }}"
        :barangays="$barangays"
        :diseases="$diseases"
        :hospitals="$hospitals"
    />
    
</x-app-layout>