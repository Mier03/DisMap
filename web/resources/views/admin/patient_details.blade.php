<x-app-layout>
    <div class="bg-g-bg flex min-h-screen w-full">
        @include('layouts.sidebar')

        <div class="ml-64 flex-1 py-12 px-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-6 bg-inherit text-gray-900">
                <!-- Header with back button on the right -->
                <div class="flex justify-between items-center">
                    <x-page-header title="Patient Details" subtitle="Patient information and medical history" />

                    <a href="{{ route('admin.managepatients') }}"
                        class="flex items-center text-g-dark hover:text-g-dark/80 transition">
                        <span class="material-icons mr-2">arrow_back</span>
                        <span>Back to list</span>
                    </a>
                </div>

                <div>
                    <!-- Patient Information Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Personal Information Card -->
                        <div class="bg-white border border-g-dark rounded-lg p-4">
                            <div class="flex items-center mb-3">
                                <span class="material-icons text-g-dark mr-2">person</span>
                                <h3 class="text-lg font-semibold text-g-dark">Personal Information</h3>
                            </div>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center py-2 border-b border-g-light/50">
                                    <span class="text-sm font-medium text-gray-600">Name:</span>
                                    <span class="text-gray-800" id="patient-name">{{ $patient->name }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-g-light/50">
                                    <span class="text-sm font-medium text-gray-600">Birthdate (Age):</span>
                                    <span class="text-gray-800" id="patient-birthdate">{{ \Carbon\Carbon::parse($patient->birthdate)->format('F j, Y') }} ({{ \Carbon\Carbon::parse($patient->birthdate)->age }})</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-g-light/50">
                                    <span class="text-sm font-medium text-gray-600">Sex:</span>
                                    <span class="text-gray-800" id="patient-age">{{ $patient->sex }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-g-light/50">
                                    <span class="text-sm font-medium text-gray-600">Ethnicity:</span>
                                    <span class="text-gray-800" id="patient-age">{{ $patient->ethnicity }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-sm font-medium text-gray-600">Address:</span>
                                    <span class="text-gray-800" id="patient-address">{{ $patient->street_address ?? 'N/A'}}, {{ $patient->barangay->name ?? 'N/A' }}, Cebu City</span>
                                </div>
                            </div>
                        </div>

                        <!-- Account Information Card -->
                        <div class="bg-white border border-g-dark rounded-lg p-4">
                            <div class="flex items-center mb-3">
                                <span class="material-icons text-g-dark mr-2">verified_user</span>
                                <h3 class="text-lg font-semibold text-g-dark">Account Information</h3>
                            </div>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center py-2 border-b border-g-light/50">
                                    <span class="text-sm font-medium text-gray-600">Email:</span>
                                    <span class="text-gray-800" id="patient-email">{{ $patient->email }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-g-light/50">
                                    <span class="text-sm font-medium text-gray-600">Username:</span>
                                    <span class="text-gray-800" id="patient-username">{{ $patient->username }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-sm font-medium text-gray-600">Account Status:</span>
                                    <span class="px-3 py-1 rounded-full text-xs font-medium {{ $patient->status === 'Active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($patient->status ?? 'Inactive') }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-g-light/50">
                                    <span class="text-sm font-medium text-gray-600">User Type:</span>
                                    <span class="text-gray-800" id="patient-username">{{ $patient->user_type }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-g-light/50">
                                    <span class="text-sm font-medium text-gray-600">Contact Number:</span>
                                    <span class="text-gray-800" id="patient-username">{{ $patient->contact_number }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Medical History Table -->
                    <div class="mt-6">
                        <div class="flex items-start justify-between">
                            <!-- Search medical records -->
                            <div class="w-full mr-4">
                                <form method="GET" action="{{ route('admin.view_patients', ['id' => $patient->id]) }}">
                                    <x-search-bar placeholder="Search medical history..." value="{{ request('q') }}" />
                                </form>
                            </div>
                           <button
                                onclick="openModal('addRecordModal')"
                                class="bg-g-dark text-white px-4 py-2 rounded-lg hover:bg-[#296E5B]/90 transition shrink-0">
                                + New
                            </button>
                        </div>
                        <x-Tables.tables
                            tableType="patientRecords"
                            :data="$patientRecords"
                            title="Medical History"
                            icon="gmdi-medical-information-o"
                        />
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>

    <x-modals.form_modals
        id="patientDetailsModal"
        title="Patient Details"
        cancelText="Close"
        :isConfirmation="false"
        :hospitals="$hospitals"
    />
    <x-modals.addPatientModal 
        id="addRecordModal" 
        :hospitals="$hospitals" 
        :diseases="$diseases" 
        :patient="$patient" 
    />
</x-app-layout>