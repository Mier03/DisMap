<x-app-layout>
    <div class="bg-g-bg flex min-h-screen w-full">
        @include('layouts.sidebar')

        <div class="ml-64 flex-1 py-12 px-6">
            <div class="max-w-7xl mx-auto">
                <div class="bg-white shadow rounded-lg p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Patient Details</h2>
                        <a href="{{ route('admin.managepatients') }}" class="text-blue-600 hover:underline">← Back to list</a>
                    </div>
                    
                    {{-- Patient Information --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Personal Information</h3>
                            <div class="space-y-2">
                                <p><strong>Name:</strong> {{ $patient->name }}</p>
                                <p><strong>Email:</strong> {{ $patient->email }}</p>
                                <p><strong>Username:</strong> {{ $patient->username }}</p>
                                <p><strong>Birthdate:</strong> {{ \Carbon\Carbon::parse($patient->birthdate)->format('F j, Y') }}</p>
                                <p><strong>Age:</strong> {{ \Carbon\Carbon::parse($patient->birthdate)->age }}</p>
                                <p><strong>Barangay:</strong> {{ $patient->barangay->name ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Medical History Table --}}
                    <div class="mt-6">
                        <div class="flex items-start justify-between">
                            {{-- Search medical records --}}
                            <div class="w-full mr-4">
                                <form method="GET" action="{{ route('admin.managepatients') }}">
                                    <x-search-bar placeholder="Search medical history..." value="{{ request('q') }}" />
                                </form>
                            </div>
                            <button
                                onclick="openModal('addPatientModal')" {{-- change the modal to open--}}
                                class="bg-g-dark text-white px-4 py-2 rounded-lg hover:bg-[#296E5B]/90 transition shrink-0">
                                + New
                            </button>
                        </div>
                        <x-Tables.tables
                            tableType="patientRecords"
                            :data="$patient->patientRecords"
                            title="Medical History"
                            icon="gmdi-medical-information-o"
                        />
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

</x-app-layout>

