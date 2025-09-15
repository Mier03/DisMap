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
                                <p><strong>Barangay:</strong> {{ $patient->barangay->name }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Medical History Table --}}
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold mb-4">Medical History</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                                <thead>
                                    <tr class="bg-gray-100 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                        <th class="px-6 py-3 border-b-2 border-gray-200">Date Reported</th>
                                        <th class="px-6 py-3 border-b-2 border-gray-200">Disease</th>
                                        <th class="px-6 py-3 border-b-2 border-gray-200">Status</th>
                                        <th class="px-6 py-3 border-b-2 border-gray-200">Hospital</th>
                                        <th class="px-6 py-3 border-b-2 border-gray-200">Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($patient->patientRecords as $record)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ \Carbon\Carbon::parse($record->date_reported)->format('F j, Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $record->disease->specification }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                            <span class="px-2 py-1 rounded text-sm {{ $record->status_type === 'Active' ? 'bg-yellow-100 text-yellow-800' : ($record->status_type === 'Recovered' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                                {{ $record->status_type }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $record->hospital->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $record->remarks ?? 'N/A' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>