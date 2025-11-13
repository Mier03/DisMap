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
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Patient Information Cards -->
                    <x-cards.info_cards
                        title="Personal Information"
                        icon="person"
                        :items="[
                            [
                                'label' => 'Name:',
                                'value' => $patient->name
                            ],
                            [
                                'label' => 'Birthdate (Age):',
                                'value' => \Carbon\Carbon::parse($patient->birthdate)->format('F j, Y') . ' (' . \Carbon\Carbon::parse($patient->birthdate)->age . ')'
                            ],
                            [
                                'label' => 'Sex:',
                                'value' => $patient->sex
                            ],
                            [
                                'label' => 'Ethnicity:',
                                'value' => $patient->ethnicity
                            ],
                            [
                                'label' => 'Address:',
                                'value' => ($patient->street_address ?? 'N/A') . ', ' . ($patient->barangay->name ?? 'N/A') . ', Cebu City'
                            ],
                        ]"
                    />

                    <!-- Account Information Card -->
                    <x-cards.info_cards
                        title="Account Information"
                        icon="verified_user"
                        :items="[
                            [
                                'label' => 'Email:',
                                'value' => $patient->email
                            ],
                            [
                                'label' => 'Username:',
                                'value' => $patient->username
                            ],
                            [
                                'label' => 'User Type:',
                                'value' => $patient->user_type
                            ],
                            [
                                'label' => 'Contact Number:',
                                'value' => $patient->contact_number ?? 'N/A'
                            ],
                            [
                                'label' => 'Account Status:',
                                'badge' => [
                                    'text' => ucfirst($patient->status ?? 'Inactive'),
                                    'class' => $patient->status === 'Active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
                                ]
                            ],
                        ]"
                    />
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