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
                            $patientColumns = ['Name', 'Age', 'Barangay', 'Diagnosis', 'Hospital', 'Date Reported', 'Status', 'Actions'];
                            $patientRows = collect($patients)->map(function ($patient) {
                                $statusClass = $patient->status === 'Active' ? 'bg-yellow-200 text-yellow-800' : ($patient->status === 'Recovered' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800');
                                return [
                                    $patient->name,
                                    $patient->age,
                                    $patient->barangay->name ?? 'N/A',
                                    $patient->diagnosis,
                                    $patient->hospital->name ?? 'N/A',
                                    $patient->date_reported,
                                    "<span class='px-2 py-1 rounded text-sm {$statusClass}'>{$patient->status}</span>",
                                    "<div class='space-x-2'>
                                        <button onclick=\"openModal('updatePatientModal_{$patient->id}')\" class=\"bg-g-dark text-white px-2 py-1 rounded hover:bg-g-dark/90 transition\">✎</button>
                                        <button onclick=\"openModal('deletePatientModal_{{ $patient->id }}')\" class=\"bg-[#B64657] text-white px-2 py-1 rounded hover:bg-[#ED556C] transition\">✕</button>
                                    </div>"
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
            ['name' => 'age', 'label' => 'Age', 'type' => 'number', 'placeholder' => 'Enter patient age...', 'required' => true],
            ['name' => 'barangay_id', 'label' => 'Barangay', 'type' => 'select', 'placeholder' => 'Select barangay...', 'required' => true, 'options' => $barangays->map(function($b) { return ['value' => $b->id, 'label' => $b->name]; })->toArray()],
            ['name' => 'diagnosis', 'label' => 'Diagnosis', 'type' => 'text', 'placeholder' => 'Select patient\'s disease...', 'required' => true],
            ['name' => 'hospital_id', 'label' => 'Hospital', 'type' => 'select', 'placeholder' => 'Select hospital...', 'required' => true, 'options' => $hospitals->map(function($h) { return ['value' => $h->id, 'label' => $h->name]; })->toArray()],
            ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'placeholder' => 'Enter valid email address...', 'required' => true]
        ]"
    />

    {{-- Dynamically created update and delete modals for each patient --}}
    @foreach($patients ?? [] as $patient)
        {{-- <x-modal-popup
            id="deletePatientModal_{{ $patient->id }}"
            title="Confirm Deletion"
            message="Are you sure you want to delete {{ $patient->name }}? This action cannot be undone."
            confirmText="Delete"
            cancelText="Cancel"
            action="{{ route('admin.patients.destroy', $patient->id) }}"
            method="DELETE"
        /> --}}

        <x-modal
            id="updatePatientModal_{{ $patient->id }}"
            title="View Patient"
            message="Update patient information"
            confirmButtonText="Save Changes"
            cancelButtonText="Cancel"
            buttonId="updatePatientButton_{{ $patient->id }}"
            action="{{ route('admin.patients.update', $patient->id) }}"
            method="PATCH"
            :fields="[
                ['name' => 'fullName', 'label' => 'Full Name', 'type' => 'text', 'placeholder' => 'Enter full name...', 'value' => $patient->name],
                ['name' => 'username', 'label' => 'Username', 'type' => 'text', 'placeholder' => 'Automatic based on name...', 'value' => $patient->username, 'readonly' => true],
                ['name' => 'age', 'label' => 'Age', 'type' => 'number', 'placeholder' => 'Enter age...', 'value' => $patient->age],
                ['name' => 'barangay_id', 'label' => 'Barangay', 'type' => 'select', 'placeholder' => 'Select barangay...', 'options' => $barangays->map(function($b) { return ['value' => $b->id, 'label' => $b->name]; })->toArray(), 'value' => $patient->barangay_id],
                ['name' => 'diagnosis', 'label' => 'Diagnosis', 'type' => 'text', 'placeholder' => 'Select disease...', 'value' => $patient->diagnosis],
                ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'placeholder' => 'Select status...', 'options' => [['value' => 'Active', 'label' => 'Active'], ['value' => 'Recovered', 'label' => 'Recovered'], ['value' => 'Deceased', 'label' => 'Deceased']], 'value' => $patient->status]
            ]"
        />
    @endforeach
</x-app-layout>