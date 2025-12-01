<x-app-layout>
    <div class="bg-g-bg flex min-h-screen w-full">
        {{-- Sidebar --}}
        @include('layouts.sidebar')

        {{-- Main Content --}}
        <div class="ml-64 flex-1 py-12 px-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden">
                    <div class="p-6 bg-inherit text-gray-900">
                        {{-- Header with Back Button --}}
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <div class="flex items-center gap-3 mb-2">
                                    <a href="{{ route('diseaserecords') }}" 
                                       class="text-g-dark hover:text-g-dark/80 transition-colors">
                                        @svg('gmdi-arrow-back', 'w-5 h-5')
                                    </a>
                                    <h1 class="text-2xl font-bold text-g-dark">{{ $disease->specification }} - Patient Records</h1>
                                </div>
                                <p class="text-gray-600">Detailed view of all patients with {{ $disease->specification }} under your care</p>
                            </div>
                        </div>

                        {{-- Search Form --}}
                        <form action="{{ route('diseaserecords.details', $disease) }}" method="GET" class="mb-6">
                            <x-search-bar 
                                name="search"
                                placeholder="Search patients, remarks, status..."
                                value="{{ $search }}"
                            />
                        </form>

                        {{-- Stat Cards --}}
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                            <x-cards.stat-card :value="$stats['total_cases']" label="Total Cases" />
                            <x-cards.stat-card :value="$stats['active_cases']" label="Active Cases" /> 
                            <x-cards.stat-card :value="$stats['recovered_cases']" label="Recovered" />
                            <x-cards.stat-card :value="$stats['pending_cases']" label="Pending" />
                        </div>

                        {{-- Patient Records Table using your component --}}
                        @php
                        $tableData = $patientRecords->map(function($record) use ($disease) {
                            return [
                                'id' => $record->id,
                                'patient' => [
                                    'id' => $record->patient->id,
                                    'name' => $record->patient->name,
                                    'age' => $record->patient->age,
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

                        <x-tables 
                            tableType="diseasePatientRecords"
                            :data="$tableData"
                            title="Patient Records"
                            icon="gmdi-people-alt-o"
                        />

                        {{-- Disease Information Card --}}
                        <div class="mt-6 bg-white rounded-lg shadow p-6">
                            <h3 class="text-lg font-semibold text-g-dark mb-4 flex items-center gap-2">
                                @svg('gmdi-medical-information-o', 'w-5 h-5 text-g-dark')
                                Disease Information
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Disease Name</label>
                                    <p class="text-gray-900">{{ $disease->name }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Specification</label>
                                    <p class="text-gray-900">{{ $disease->specification }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Total Cases (Your Patients)</label>
                                    <p class="text-gray-900">{{ $stats['total_cases'] }}</p>
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Last Updated</label>
                                    <p class="text-gray-900">{{ $disease->updated_at->format('M j, Y g:i A') }}</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>