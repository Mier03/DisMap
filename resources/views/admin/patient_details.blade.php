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
                        <h3 class="text-lg font-semibold mb-4">Medical History</h3>
                            <div class="flex items-start justify-between">
                                {{-- Search medical records --}}
                                <div class="w-full mr-4">
                                    <form method="GET" action="{{ route('admin.managepatients') }}">
                                        <x-search-bar placeholder="Search medical history..." value="{{ request('q') }}" />
                                    </form>
                                </div>
                                <button
                                    onclick="openModal('addPatientModal')"
                                    class="bg-g-dark text-white px-4 py-2 rounded-lg hover:bg-[#296E5B]/90 transition shrink-0">
                                    + New
                                </button>
                            </div>
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
                                    @forelse($patient->patientRecords as $record)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ \Carbon\Carbon::parse($record->created_at)->format('F j, Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $record->disease->specification ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                            @php
                                            $statusType = $record->patient->status ?? 'No Records';
                                            $statusClass = '';
                                            if ($statusType === 'Active') {
                                                $statusClass = 'bg-yellow-100 text-yellow-800';
                                            } elseif ($statusType === 'Recovered') {
                                                $statusClass = 'bg-green-100 text-green-800';
                                            } elseif ($statusType === 'Deceased') {
                                                $statusClass = 'bg-red-100 text-red-800';
                                            } else {
                                                $statusClass = 'bg-gray-100 text-gray-800';
                                            }
                                            @endphp
                                            <span class="px-2 py-1 rounded text-sm {{ $statusClass }}">
                                                {{ $statusType }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $record->doctorHospital->hospital->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                            @if($record->remarks)
                                                <button onclick="showRemarks('{{ htmlspecialchars($record->remarks, ENT_QUOTES) }}')" class="text-blue-600 hover:underline font-medium">View</button>
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No medical history found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <x-modals.pop-up-modals
        id="remarksModal"
        title="Remarks"
        cancelText="Close"
        :isConfirmation="false"
    />

</x-app-layout>

<script>
    function showRemarks(remarks) {
        const modal = document.getElementById('remarksModal');
        const contentDiv = modal.querySelector('.text-g-dark.mb-6');
        
        contentDiv.innerHTML = `<p>${remarks}</p>`;
        openModal('remarksModal');
    }

    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }
    
    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }
</script>
```