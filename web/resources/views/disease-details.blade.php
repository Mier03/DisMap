<x-app-layout>
    <div class="bg-g-bg flex min-h-screen w-full">
        @include('layouts.sidebar')

        <div class="ml-64 flex-1 py-12 px-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-6 bg-inherit text-gray-900">
                <!-- Header with back button on the right -->
                <div class="flex justify-between items-center">
                    <x-page-header title="Disease Details" subtitle="Detailed view of all patients with {{ $disease->specification }}" />

                    <a href="{{ route('diseaserecords') }}"
                        class="flex items-center text-g-dark hover:text-g-dark/80 transition">
                        <span class="material-icons mr-2">arrow_back</span>
                        <span>Back to list</span>
                    </a>
                </div>

                <div class="mb-6">
                    <!-- Disease Information Cards -->
                    <x-cards.info_cards
                        title="Disease Information"
                        icon="medical_information"
                        layout="columnized"
                        :items="[
                            [
                                'label' => 'Disease Name:',
                                'value' => $disease->name
                            ],
                            [
                                'label' => 'Specification:',
                                'value' => $disease->specification                                ],
                            [
                                'label' => 'Total Cases:',
                                'value' => $stats['total_cases']
                            ],
                            [
                                'label' => 'Last Updated:',
                                'value' => $disease->updated_at->format('M j, Y g:i A')
                            ],
                        ]"
                    />
                </div> 

                <div class="mt-6">
                        <div class="flex items-start justify-between">
                            <!-- Search -->
                            <div class="w-full">
                                <form method="GET" action="{{ route('diseaserecords.details', $disease) }}">
                                    <x-search-bar placeholder="Search patients, remarks, status..." value="{{ request('q') }}" />
                                </form>
                            </div>
                        </div>

                        @php
                        $tableData = $patientRecords->map(function($record) use ($disease) {
                            return [
                                'id' => $record->id,
                                'patient' => [
                                    'id' => $record->patient->id,
                                    'name' => $record->patient->name,
                                    'age' => \Carbon\Carbon::parse($record->patient->birthdate)->age,
                                    'gender' => $record->patient->gender,
                                    'barangay' => $record->patient->barangay->name ?? 'N/A',
                                    'initial' => substr($record->patient->name, 0, 1)
                                ],
                                'disease_specification' => $disease->specification,
                                'status' => $record->status,
                                'date_reported' => $record->date_reported,
                                'hospital' => $record->reportedByDoctorHospital->hospital->name ?? 'N/A',
                            ];
                        });
                    @endphp

                        <x-Tables.tables 
                            tableType="diseasePatientRecords"
                            :data="$tableData"
                            title="Patient Records"
                            icon="gmdi-people-alt-o"
                        />                
                </div>
            </div>
        </div>
    </div>
</x-app-layout>