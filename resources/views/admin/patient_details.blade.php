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
                                    onclick="openModal('newRecordModal')"
                                    class="bg-g-dark text-white px-4 py-2 rounded-lg hover:bg-[#296E5B]/90 transition shrink-0">
                                    + New
                                </button>
                            </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                                <thead>
                                    <tr class="bg-gray-100 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                                        <th class="px-6 py-3 border-b-2 border-gray-200">Disease</th>
                                        <th class="px-6 py-3 border-b-2 border-gray-200">Date Reported</th>
                                        <th class="px-6 py-3 border-b-2 border-gray-200">Date Recovered</th>
                                        <th class="px-6 py-3 border-b-2 border-gray-200">Status</th>
                                        <th class="px-6 py-3 border-b-2 border-gray-200">Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($patient->patientRecords as $record)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ $record->disease->specification ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">{{ \Carbon\Carbon::parse($record->date_reported)->format('F j, Y') }}</p>
                                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                            @if($record->date_recovered)
                                                {{ \Carbon\Carbon::parse($record->date_recovered)->format('F j, Y') }}
                                            @else
                                                -
                                            @endif
                                        </td>                                        
                                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                            @php
                                            $statusType = 'No Records'; 
                                            $statusClass = 'bg-gray-100 text-gray-800'; 

                                            if ($record->date_recovered && $record->recovered_dh_id){
                                                $statusType = 'Recovered';
                                                $statusClass = 'bg-green-100 text-green-800';
                                            } else {
                                                if ($record->patient->status === 'Active') {
                                                    $statusType = 'Active';
                                                    $statusClass = 'bg-yellow-100 text-yellow-800';
                                                }
                                            }
                                            @endphp

                                            <span class="px-2 py-1 rounded text-sm {{ $statusClass }}">
                                                {{ $statusType }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                            <button 
                                                onclick="showRemarks(
                                                    '{{ htmlspecialchars($record->reported_remarks, ENT_QUOTES) }}',
                                                    '{{ htmlspecialchars($record->reportedByDoctorHospital->doctor->name ?? 'N/A', ENT_QUOTES) }}',
                                                    '{{ htmlspecialchars($record->reportedByDoctorHospital->hospital->name ?? 'N/A', ENT_QUOTES) }}',
                                                    '{{ htmlspecialchars($record->recovered_remarks ?? 'N/A', ENT_QUOTES) }}',
                                                    '{{ htmlspecialchars($record->recoveredByDoctorHospital ? $record->recoveredByDoctorHospital->doctor->name : 'N/A', ENT_QUOTES) }}',
                                                    '{{ htmlspecialchars($record->recoveredByDoctorHospital ? $record->recoveredByDoctorHospital->hospital->name : 'N/A', ENT_QUOTES) }}',
                                                    {{ $record->id }}
                                                )"
                                                class="text-blue-600 hover:underline font-medium">
                                                {{ $record->date_recovered ? 'View' : 'Update' }}
                                            </button>
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

    {{-- Include the form modals with patient data --}}
    <x-modals.form-modals id="newRecordModal" />

</x-app-layout>

<script>
    // Pass hospitals data from the controller
    const hospitals = @json($hospitals);

    function openNewRecordModal() {
        // Set today's date as default
        document.getElementById('new_date_reported').value = new Date().toISOString().split('T')[0];
        
        // Reset form fields
        document.getElementById('new_disease_id').value = '';
        document.getElementById('new_hospital_id').value = '';
        document.getElementById('new_reported_remarks').value = '';
        
        openModal('newRecordModal');
    }

    function handleNewRecordSubmit() {
        // Basic form validation
        const diseaseId = document.getElementById('new_disease_id').value;
        const hospitalId = document.getElementById('new_hospital_id').value;
        const dateReported = document.getElementById('new_date_reported').value;
        
        if (!diseaseId || !hospitalId || !dateReported) {
            alert('Please fill in all required fields.');
            return;
        }
        
        // Since you don't want functionality, just show a message and close the modal
        alert('This is a UI demonstration. The record would be saved in a real implementation.');
        closeModal('newRecordModal');
    }

    function showRemarks(reportedRemarks, reportedDoctor, reportedHospital, recoveredRemarks, recoveredDoctor, recoveredHospital, recordId) {
        const modal = document.getElementById('remarksModal');
        const contentDiv = modal.querySelector('.text-g-dark.mb-6');
        
        let htmlContent = '';

        // Reported Info
        htmlContent += `
            <h4 class="font-bold text-lg mb-2">Reported Details</h4>
            <p><strong>Remarks:</strong> ${reportedRemarks || 'N/A'}</p>
            <p><strong>Attending Doctor:</strong> ${reportedDoctor || 'N/A'}</p>
            <p><strong>Hospital:</strong> ${reportedHospital || 'N/A'}</p>
        `;

        // Check if recovery details exist
        if (recoveredRemarks !== 'N/A' || recoveredDoctor !== 'N/A' || recoveredHospital !== 'N/A') {
            htmlContent += `
                <hr class="my-4 border-t border-gray-200">
                <h4 class="font-bold text-lg mb-2">Recovery Details</h4>
                <p><strong>Remarks:</strong> ${recoveredRemarks || 'N/A'}</p>
                <p><strong>Attending Doctor:</strong> ${recoveredDoctor || 'N/A'}</p>
                <p><strong>Hospital:</strong> ${recoveredHospital || 'N/A'}</p>
            `;
        } else {
            htmlContent += `
                <hr class="my-4 border-t border-gray-200">
                <button id="addRecoveryDetailsBtn" class="text-blue-600 hover:underline font-medium">Add Recovery Details</button>
                <form id="recoveryForm" class="hidden mt-4" method="POST" action="${'{{ route("admin.patient_records.update_recovery", ["id" => "__RECORD_ID__"]) }}'.replace('__RECORD_ID__', recordId)}">
                    @csrf
                    <div class="mb-4">
                        <label for="date_recovered" class="block text-sm font-medium text-g-dark">Date Recovered</label>
                        <input type="date" id="date_recovered" name="date_recovered" class="mt-1 block w-full border border-gray-300 rounded-md p-2" required>
                    </div>
                    <div class="mb-4">
                        <label for="hospital_id" class="block text-sm font-medium text-g-dark">Hospital</label>
                        <select id="hospital_id" name="hospital_id" class="mt-1 block w-full border border-gray-300 rounded-md p-2" required>
                            <option value="">Select a hospital</option>
                            ${hospitals.map(hospital => `<option value="${hospital.id}">${hospital.name}</option>`).join('')}
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="recovered_remarks" class="block text-sm font-medium text-g-dark">Remarks</label>
                        <textarea id="recovered_remarks" name="recovered_remarks" class="mt-1 block w-full border border-gray-300 rounded-md p-2" rows="4" required></textarea>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" id="cancelRecoveryForm" class="border border-g-dark text-g-dark px-4 py-2 rounded-md font-semibold hover:bg-gray-100">Cancel</button>
                        <button type="submit" class="bg-g-dark text-white px-4 py-2 rounded-md font-semibold hover:bg-g-dark/90">Save Changes</button>
                    </div>
                </form>
            `;
        }

        contentDiv.innerHTML = htmlContent;
        openModal('remarksModal');

        // Event listeners for the recovery form
        const addRecoveryBtn = document.getElementById('addRecoveryDetailsBtn');
        const recoveryForm = document.getElementById('recoveryForm');
        const cancelBtn = document.getElementById('cancelRecoveryForm');

        if (addRecoveryBtn && recoveryForm) {
            addRecoveryBtn.addEventListener('click', () => {
                addRecoveryBtn.classList.add('hidden');
                recoveryForm.classList.remove('hidden');
            });
        }

        if (cancelBtn) {
            cancelBtn.addEventListener('click', () => {
                recoveryForm.classList.add('hidden');
                addRecoveryBtn.classList.remove('hidden');
            });
        }

        if (recoveryForm) {
            recoveryForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const formData = new FormData(recoveryForm);
                try {
                    const response = await fetch(recoveryForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    });
                    const result = await response.json();
                    if (response.ok) {
                        alert('Recovery details saved successfully!');
                        window.location.reload();
                    } else {
                        alert('Error: ' + (result.message || 'Failed to save recovery details.'));
                    }
                } catch (error) {
                    alert('Error: ' + error.message);
                }
            });
        }
    }

    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
        document.getElementById(id).classList.add('flex');
    }
    
    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
        document.getElementById(id).classList.remove('flex');
    }
</script>