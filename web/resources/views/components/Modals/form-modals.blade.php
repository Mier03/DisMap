@props(['id', 'hospitals', 'barangays', 'diseases'])

{{-- Wrapper that holds ALL modals --}}
<div>

    {{-- =========================
        Add Hospital Modal
    ========================== --}}
    <div id="addHospitalModal" class="hidden fixed inset-0 flex bg-black bg-opacity-50 items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-[500px] p-8 text-left relative">
            <x-input-label class="text-xl font-bold mb-4" :value="__('Add Hospital')" />

            <form id="hospitalForm" method="POST" action="{{ route('admin.doctor_hospitals.store') }}" enctype="multipart/form-data">
                @csrf
                @if(Auth::check())
                <!-- Select Hospital -->
                <div class="mb-4">
                    <x-input-label for="hospitalSelect" :value="__('Select Hospital')" />
                    <x-dropdown-select id="hospitalSelect" name="hospital_id" required>
                        @foreach($hospitals as $hospital)
                        @if(!Auth::user()->approvedHospitals->contains($hospital->id))
                        <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
                        @endif
                        @endforeach
                    </x-dropdown-select>
                    <x-input-error :messages="$errors->get('hospital_id')" class="mt-2" />
                </div>
                @endif

                <!-- Certification Upload -->
                <div class="mb-4">
                    <x-input-label for="certification" :value="__('Upload Certification')" />
                    <input id="certification"
                        class="block mt-1 w-full border border-g-dark rounded px-3 py-2 text-sm text-g-dark bg-[#F2F2F2]"
                        type="file" name="certification" accept=".jpg,.jpeg,.png,.pdf" required />
                    <x-input-error :messages="$errors->get('certification')" class="mt-2" />
                </div>


                <div class="flex justify-center gap-4 mt-8">
                    <x-primary-button>
                        {{ __('Submit') }}
                    </x-primary-button>
                    <x-secondary-button type="button" onclick="closeModal('addHospitalModal')">
                        Cancel
                    </x-secondary-button>
                </div>
            </form>
        </div>
    </div>

    {{-- =========================
        Edit Patient Modal
    ========================== --}}
    <div id="editPatientModal" class="hidden fixed inset-0 flex bg-black bg-opacity-50 items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-[500px] p-8 text-left relative">
            <h2 class="text-2xl font-bold text-g-dark">Edit Patient</h2>
            <p class="text-g-dark text-base">Edit patient details here...</p>
            <x-secondary-button type="button" onclick="closeModal('editPatientModal')">
                Close
            </x-secondary-button>
        </div>
    </div>

    {{-- =========================
        Export Modal
    ========================== --}}
    <div id="exportModal" class="hidden fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-[500px] p-8 text-left relative">
            <div class="flex items-center mb-2">
                <svg class="w-[32px] h-[32px] text-g-dark fill-current"
                    xmlns="resources/svg/filter.svg" viewBox="0 0 24 24">
                    <path d="M3 4h18l-7 9v7l-4-2v-5z" />
                </svg>
                <h2 class="ml-3 text-[28px] font-bold text-g-dark">Export</h2>
            </div>
            <p class="text-g-dark text-[16px] mb-6 ml-1">Filter and export data</p>

            <div class="px-[10px]">
                <div class="flex justify-between items-center mb-2">
                    <x-input-label :value="__('Date Range')" />
                    <button type="button" onclick="resetDateRange()" class="text-g-dark font-semibold text-sm">
                        Reset
                    </button>
                </div>
                <div class="flex gap-3 mb-3">
                    <x-text-input id="fromDate" class="w-full h-[40px] text-sm"
                        type="date" name="fromDate" :value="old('fromDate')" />
                    <x-text-input id="toDate" class="w-full h-[40px] text-sm"
                        type="date" name="toDate" :value="old('toDate')" />
                </div>

                <div class="flex gap-3">
                    <button type="button" onclick="setDateFilter('today')"
                        class="w-full h-[36px] border border-g-dark rounded text-sm font-semibold text-g-dark hover:bg-g-dark hover:text-white transition">
                        Today
                    </button>
                    <button type="button" onclick="setDateFilter('week')"
                        class="w-full h-[36px] border border-g-dark rounded text-sm font-semibold text-g-dark hover:bg-g-dark hover:text-white transition">
                        This Week
                    </button>
                    <button type="button" onclick="setDateFilter('month')"
                        class="w-full h-[36px] border border-g-dark rounded text-sm font-semibold text-g-dark hover:bg-g-dark hover:text-white transition">
                        This Month
                    </button>
                </div>
            </div>

            <div class="mt-6 px-[10px]">
                <div class="flex justify-between items-center mb-2">
                    <x-input-label for="export_hospital_id" :value="__('Hospital')" />
                    <button type="button" onclick="resetHospital()" class="text-g-dark font-semibold text-sm">
                        Reset
                    </button>
                </div>
                <x-dropdown-select id="export_hospital_id" name="hospital_id">
                    <option value="" selected>Select hospital...</option>
                    @foreach($hospitals as $hospital)
                    <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
                    @endforeach
                </x-dropdown-select>
            </div>

            <div class="mt-6 px-[10px]">
                <div class="flex justify-between items-center mb-2">
                    <x-input-label for="export_disease_id" :value="__('Disease Type')" />
                    <button type="button" onclick="resetDisease()" class="text-g-dark font-semibold text-sm">
                        Reset
                    </button>
                </div>
                <x-dropdown-select id="export_disease_id" name="disease_id">
                    <option value="" selected>Select disease...</option>
                    @foreach($diseases as $disease)
                    <option value="{{ $disease->id }}">{{ $disease->specification }}</option>
                    @endforeach
                </x-dropdown-select>
            </div>

            <div class="flex justify-center gap-4 mt-8">
                <x-primary-button>
                    {{ __('Export PDF') }}
                </x-primary-button>
                <x-secondary-button type="button" onclick="closeModal('exportModal')">
                    Cancel
                </x-secondary-button>
            </div>
        </div>
    </div>

    {{-- =========================
        Request Data Modal
    ========================== --}}
    <div id="requestDataModal" class="hidden fixed inset-0 flex z-50 items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg w-[600px] p-8 text-left relative">
            <div class="flex items-center mb-2">
                <svg xmlns="resources/svg/filter.svg" class="w-[32px] h-[32px] text-g-dark fill-current"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z" />
                </svg>
                <h2 class="ml-3 text-[28px] font-bold text-g-dark">Data Request Form</h2>
            </div>
            <p class="text-g-dark text-[16px] mb-6 ml-1">Reason for data request</p>

            <form action="javascript:void(0)" method="POST" class="space-y-5">
                @csrf
                <div>
                    <x-input-label for="full_name" :value="__('Full Name')" />
                    <x-text-input id="full_name" class="block mt-1 w-full"
                        type="text" name="full_name" :value="old('full_name')"
                        placeholder="Enter your full name..." />
                    <x-input-error :messages="$errors->get('full_name')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full"
                        type="email" name="email" :value="old('email')"
                        placeholder="Enter your email address..." />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="reason" :value="__('Reason for Request')" />
                    <textarea id="reason" name="reason" placeholder="Reason for requesting data..."
                        class="w-full h-[218px] border border-g-dark rounded px-3 py-2 text-sm text-g-dark bg-[#F2F2F2] resize-none focus:outline-none focus:ring-2 focus:ring-g-dark/50"></textarea>
                    <x-input-error :messages="$errors->get('reason')" class="mt-2" />
                </div>

                <div class="flex justify-center gap-4 mt-8">
                    <x-primary-button>
                        {{ __('Submit') }}
                    </x-primary-button>
                    <x-secondary-button type="button" onclick="closeModal('requestDataModal')">
                        Cancel
                    </x-secondary-button>
                </div>
            </form>

            <button type="button" onclick="closeModal('requestDataModal')"
                class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
                ✕
            </button>
        </div>
    </div>

    {{-- =========================
        View Reason of Request Modal - SuperAdmin Side
    ========================== --}}
    <!-- <div id="reasonRequestModal" class="hidden fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-[600px] p-8 text-left relative">
            <div class="flex items-center mb-2">
                <svg xmlns="resources/svg/filter.svg" class="w-[32px] h-[32px] text-g-dark fill-current"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z"/>
                </svg>
                <h2 class="ml-3 text-[28px] font-bold text-g-dark">Request Form</h2>
            </div>
            <p class="text-g-dark text-[16px] mb-6 ml-1">Reason for data request</p>

            <form action="javascript:void(0)" method="POST" class="space-y-5">
                @csrf
                <div>
                    <x-input-label for="full_name" :value="__('Full Name')" />
                    <x-text-input id="full_name" class="block mt-1 w-full" 
                        type="text" name="full_name" readonly placeholder="Full Name Here" />
                    <x-input-error :messages="$errors->get('full_name')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" 
                        type="email" name="email" readonly placeholder="Email Address Here" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="reason" :value="__('Reason for Request')" />
                    <textarea id="reason" name="reason" readonly placeholder="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat."
                              class="w-full h-[218px] border border-g-dark rounded px-3 py-2 text-sm text-g-dark bg-[#F2F2F2] resize-none focus:outline-none focus:ring-2 focus:ring-g-dark/50"></textarea>
                    <x-input-error :messages="$errors->get('reason')" class="mt-2" />
                </div>

                <div class="flex justify-center gap-4 mt-8">
                    <x-primary-button>
                        {{ __('Accept') }}
                    </x-primary-button>
                    <x-secondary-button type="button" onclick="closeModal('reasonRequestModal')">
                        Decline
                    </x-secondary-button>
                </div>
            </form>

            <button type="button" onclick="closeModal('reasonRequestModal')"
                    class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
                ✕
            </button>
        </div>
    </div> -->
    <div id="reasonRequestModal" class="hidden fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-[550px] p-6 text-left relative">
            <div class="flex items-center mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-g-dark fill-current" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z" />
                </svg>
                <h2 class="ml-2 text-xl font-bold text-g-dark">Request Details</h2>
            </div>
            <p class="text-g-dark text-sm mb-4 ml-1">Data request information</p>

            <div class="space-y-3">
                {{-- Name & Email in one row --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <x-input-label for="modal_full_name" :value="__('Full Name')" class="text-xs" />
                        <x-text-input id="modal_full_name" class="block mt-1 w-full bg-[#F2F2F2] text-sm py-1"
                            type="text" readonly />
                    </div>
                    <div>
                        <x-input-label for="modal_email" :value="__('Email')" class="text-xs" />
                        <x-text-input id="modal_email" class="block mt-1 w-full bg-[#F2F2F2] text-sm py-1"
                            type="email" readonly />
                    </div>
                </div>

                {{-- Requested Disease & Date Requested in one row --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <x-input-label for="modal_requested_disease" :value="__('Disease')" class="text-xs" />
                        <x-text-input id="modal_requested_disease" class="block mt-1 w-full bg-[#F2F2F2] text-sm py-1"
                            type="text" readonly />
                    </div>
                    <div>
                        <x-input-label for="modal_created_at" :value="__('Date Requested')" class="text-xs" />
                        <x-text-input id="modal_created_at" class="block mt-1 w-full bg-[#F2F2F2] text-sm py-1"
                            type="text" readonly />
                    </div>
                </div>

                {{-- Date Range --}}
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <x-input-label for="modal_from_date" :value="__('From Date')" class="text-xs" />
                        <x-text-input id="modal_from_date" class="block mt-1 w-full bg-[#F2F2F2] text-sm py-1"
                            type="text" readonly />
                    </div>
                    <div>
                        <x-input-label for="modal_to_date" :value="__('To Date')" class="text-xs" />
                        <x-text-input id="modal_to_date" class="block mt-1 w-full bg-[#F2F2F2] text-sm py-1"
                            type="text" readonly />
                    </div>
                </div>

                {{-- Purpose --}}
                <div>
                    <x-input-label for="modal_purpose" :value="__('Purpose')" class="text-xs" />
                    <textarea id="modal_purpose" readonly
                        class="w-full h-[80px] border border-g-dark rounded px-2 py-1 text-xs text-g-dark bg-[#F2F2F2] resize-none focus:outline-none"></textarea>
                </div>

                <div class="flex justify-center gap-4 mt-6">
                    <x-primary-button type="button" onclick="approveRequest()">
                        {{ __('Accept') }}
                    </x-primary-button>
                    <x-secondary-button type="button" onclick="declineRequestModal()">
                        Decline
                    </x-secondary-button>
                </div>
            </div>

            <button type="button" onclick="closeModal('reasonRequestModal')"
                class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
                ✕
            </button>
        </div>
    </div>

    {{-- Decline Reason Modal --}}
    <div id="declineReasonModal" class="hidden fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-[450px] p-5 text-left relative">
            <h2 class="text-lg font-bold text-g-dark mb-3">Decline Request</h2>

            <div class="mb-3">
                <x-input-label for="decline_reason" :value="__('Reason for declining (optional)')" class="text-xs" />
                <textarea id="decline_reason"
                    class="w-full h-[80px] border border-gray-300 rounded px-2 py-1 text-sm text-gray-700 resize-none focus:outline-none focus:ring-1 focus:ring-g-dark/50"
                    placeholder="Enter reason for declining..."></textarea>
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeModal('declineReasonModal')"
                    class="bg-gray-500 text-white px-3 py-1.5 rounded hover:bg-gray-600 transition text-sm">
                    Cancel
                </button>
                <button type="button" onclick="submitDecline()"
                    class="bg-r-dark text-white px-3 py-1.5 rounded hover:bg-red-600 transition text-sm">
                    Confirm Decline
                </button>
            </div>

            <button type="button" onclick="closeModal('declineReasonModal')"
                class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">
                ✕
            </button>
        </div>
    </div>

    {{-- =========================
        Patient Details Modal
    ========================= --}}
    <div id="patientDetailsModal" class="hidden fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50"
        data-update-route="{{ route('admin.patient_records.update_recovery', ['id' => '__RECORD_ID__']) }}">
        <div class="bg-white rounded-lg shadow-lg w-[600px] p-8 text-left relative overflow-y-auto max-h-[80vh]">
            <div class="flex items-center mb-2">
                <h2 class="text-[28px] font-bold text-g-dark">Patient Details</h2>
            </div>
            <p class="text-g-dark text-[16px] mb-6 ml-1">View or update patient record details</p>

            <div class="text-g-dark mb-6" id="patientDetailsContent">
                
            </div>

            <div class="flex justify-center gap-4 mt-8">
                <x-primary-button id="saveRecoveryBtn" class="hidden" type="submit" form="recoveryForm">
                    Save Changes
                </x-primary-button>
                <x-secondary-button type="button" onclick="closeModal('patientDetailsModal')">
                    Close
                </x-secondary-button>
            </div>

            <button type="button" onclick="closeModal('patientDetailsModal')"
                class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
                ✕
            </button>
        </div>
    </div>
</div>

{{-- ========== SCRIPTS ========== --}}
<script>
    // Pass hospitals data from the controller
    const hospitals = @json($hospitals);
    console.log('Hospitals:', hospitals);

    function openModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            const saveBtn = document.getElementById('saveRecoveryBtn');
            const recoveryForm = document.getElementById('recoveryForm');

            if (saveBtn) saveBtn.classList.add('hidden');
            if (recoveryForm) recoveryForm.classList.add('hidden');

            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }

    async function showDetails(recordId) {
        const modal = document.getElementById('patientDetailsModal');
        if (!modal) {
            console.error('Patient Details modal not found');
            return;
        }
        const contentDiv = document.getElementById('patientDetailsContent');
        if (!contentDiv) {
            console.error('Content div not found in patient details modal');
            return;
        }

        const saveRecoveryBtn = document.getElementById('saveRecoveryBtn');
        saveRecoveryBtn.classList.add('hidden');

        try {
            const response = await fetch(`/admin/patient-records/${recordId}`, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            });
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            const record = await response.json();
            console.log('API Response:', record);

            let htmlContent = `
                <div class="mb-6">
                    <h4 class="font-bold text-lg mb-2 text-g-dark">Reported Details</h4>
                    <div class="mb-4">
                        <x-input-label for="reported_remarks" :value="__('Remarks')" />
                        <x-text-input id="reported_remarks" class="block mt-1 w-80" 
                            type="text" value="${record.reported_remarks || 'N/A'}" readonly />
                    </div>
                    <div class="mb-4">
                        <x-input-label for="reported_doctor" :value="__('Attending Doctor')" />
                        <x-text-input id="reported_doctor" class="block mt-1 w-full" 
                            type="text" value="Dr. ${record.reported_doctor || 'N/A'}" readonly />
                    </div>
                    <div class="mb-4">
                        <x-input-label for="reported_hospital" :value="__('Hospital')" />
                        <x-text-input id="reported_hospital" class="block mt-1 w-full" 
                            type="text" value="${record.reported_hospital || 'N/A'}" readonly />
                    </div>
                </div>
            `;

            // Only show recovery details if at least one recovery field exists
            if (record.recovered_remarks || record.recovered_doctor || record.recovered_hospital) {
                htmlContent += `
                    <hr class="my-4 border-t border-gray-200">
                    <h4 class="font-bold text-lg mb-2 text-g-dark">Recovery Details</h4>
                    <div class="mb-4">
                        <x-input-label for="recovered_remarks" :value="__('Remarks')" />
                        <x-text-input id="recovered_remarks" class="block mt-1 w-80" 
                            type="text" value="${record.recovered_remarks || 'N/A'}" readonly />
                    </div>
                    <div class="mb-4">
                        <x-input-label for="recovered_doctor" :value="__('Attending Doctor')" />
                        <x-text-input id="recovered_doctor" class="block mt-1 w-full" 
                            type="text" value="Dr. ${record.recovered_doctor || 'N/A'}" readonly />
                    </div>
                    <div class="mb-4">
                        <x-input-label for="recovered_hospital" :value="__('Hospital')" />
                        <x-text-input id="recovered_hospital" class="block mt-1 w-full" 
                            type="text" value="${record.recovered_hospital || 'N/A'}" readonly />
                    </div>
                `;
            } else {
                // This is the block where the "Add Recovery Details" button is shown when recovery details are null
                const updateRoute = modal.dataset.updateRoute.replace('__RECORD_ID__', recordId);
                htmlContent += `
                    <hr class="my-4 border-t border-gray-200">
                    <button id="addRecoveryDetailsBtn" class="text-blue-600 hover:underline font-medium mb-4">Add Recovery Details</button>
                    <form id="recoveryForm" class="hidden mt-4" method="POST" action="${updateRoute}">
                        @csrf
                        <div class="mb-4">
                            <x-input-label for="date_recovered" :value="__('Date Recovered')" />
                            <x-text-input id="date_recovered" class="block mt-1 w-full" 
                                type="date" name="date_recovered" required />
                            <x-input-error :messages="$errors->get('date_recovered')" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="hospital_id" :value="__('Hospital')" />
                            <x-dropdown-select id="hospital_id" name="hospital_id" required>
                                <option value="" disabled selected>Select hospital...</option>
                                @if(Auth::check())
                                    @foreach(Auth::user()->approvedHospitals as $hospital)
                                        <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
                                    @endforeach
                                @endif
                            </x-dropdown-select>
                            <x-input-error :messages="$errors->get('hospital_id')" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="recovered_remarks" :value="__('Remarks')" />
                            <textarea id="recovered_remarks" name="recovered_remarks" 
                                class="w-full h-[100px] border border-g-dark rounded px-3 py-2 text-sm text-g-dark bg-[#F2F2F2] resize-none focus:outline-none focus:ring-2 focus:ring-g-dark/50" 
                                placeholder="Enter recovery remarks..." required></textarea>
                            <x-input-error :messages="$errors->get('recovered_remarks')" class="mt-2" />
                        </div>
                        <div class="flex justify-center gap-4">
                        </div>
                    </form>
                `;
            }

            contentDiv.innerHTML = htmlContent;
            openModal('patientDetailsModal');

            const addRecoveryBtn = document.getElementById('addRecoveryDetailsBtn');
            const recoveryForm = document.getElementById('recoveryForm');

            if (addRecoveryBtn && recoveryForm) {
                addRecoveryBtn.addEventListener('click', () => {
                    addRecoveryBtn.classList.add('hidden');
                    recoveryForm.classList.remove('hidden');
                    saveRecoveryBtn.classList.remove('hidden');
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
                            const errorMessages = result.errors ? Object.values(result.errors).flat().join('\n') : result.message || 'Failed to save recovery details.';
                            alert('Error: ' + errorMessages);
                        }
                    } catch (error) {
                        alert('Error: ' + error.message);
                    }
                });
            }
        } catch (error) {
            console.error('Error fetching record:', error);
            alert('Failed to load record details.');
        }
    }

    function setDateFilter(type) {
        const fromInput = document.getElementById('fromDate');
        const toInput = document.getElementById('toDate');
        const today = new Date();
        let fromDate, toDate = new Date();

        if (type === 'today') {
            fromDate = new Date();
        } else if (type === 'week') {
            fromDate = new Date();
            fromDate.setDate(today.getDate() - 7);
        } else if (type === 'month') {
            fromDate = new Date();
            fromDate.setDate(today.getDate() - 30);
        }

        fromInput.value = fromDate.toISOString().split('T')[0];
        toInput.value = today.toISOString().split('T')[0];

        highlightActive(type);
    }

    function highlightActive(type) {
        const buttons = document.querySelectorAll('#exportModal button');
        buttons.forEach(btn => {
            if (btn.getAttribute('onclick')?.includes(`setDateFilter('${type}')`)) {
                btn.classList.add('bg-g-dark', 'text-white');
            } else if (btn.getAttribute('onclick')?.includes("setDateFilter")) {
                btn.classList.remove('bg-g-dark', 'text-white');
                btn.classList.add('text-g-dark');
            }
        });
    }

    function resetDateRange() {
        document.getElementById('fromDate').value = '';
        document.getElementById('toDate').value = '';
    }

    function resetHospital() {
        document.getElementById('export_hospital_id').value = "";
    }

    function resetDisease() {
        document.getElementById('export_disease_id').value = "";
    }

    const addHospitalModal = document.getElementById('addHospitalModal');
    if (addHospitalModal) {
        addHospitalModal.addEventListener('click', function(e) {
            if (e.target === addHospitalModal) {
                addHospitalModal.classList.add('hidden');
            }
        });
    }

    // Superadmin Request Details
    let currentRequestId = null;
    let pendingAction = null; // 'approve' or 'decline'

    function viewRequestedData(requestId) {
        currentRequestId = requestId;

        // Show loading state
        document.getElementById('modal_full_name').value = 'Loading...';
        document.getElementById('modal_email').value = 'Loading...';
        document.getElementById('modal_requested_disease').value = 'Loading...';
        document.getElementById('modal_from_date').value = 'Loading...';
        document.getElementById('modal_to_date').value = 'Loading...';
        document.getElementById('modal_created_at').value = 'Loading...';
        document.getElementById('modal_purpose').value = 'Loading...';

        // Fetch request details
        fetch(`/superadmin/data-requests/${requestId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Populate modal with data
                document.getElementById('modal_full_name').value = data.name || 'N/A';
                document.getElementById('modal_email').value = data.email || 'N/A';
                document.getElementById('modal_requested_disease').value = data.requested_disease || 'N/A';
                document.getElementById('modal_from_date').value = data.from_date || 'Not specified';
                document.getElementById('modal_to_date').value = data.to_date || 'Not specified';
                document.getElementById('modal_created_at').value = new Date(data.created_at).toLocaleDateString() || 'N/A';
                document.getElementById('modal_purpose').value = data.purpose || 'N/A';

                // Show modal
                openModal('reasonRequestModal');
            })
            .catch(error => {
                console.error('Error fetching request details:', error);
                alert('Error loading request details. Please try again.');
            });
    }

    function approveRequest() {
        if (!currentRequestId) return;

        pendingAction = 'approve';
        closeModal('reasonRequestModal');
        showConfirmation(
            'Accept Request?',
            'Are you sure you want to accept this data request?',
            'Accept',
            'Cancel'
        );
    }

    function declineRequestModal() {
        closeModal('reasonRequestModal');
        openModal('declineReasonModal');
    }

    function submitDecline() {
        if (!currentRequestId) return;

        const declineReason = document.getElementById('decline_reason').value;

        pendingAction = 'decline';
        const message = 'Are you sure you want to decline this data request?' +
            (declineReason ? '\n\nReason: ' + declineReason : '');
        closeModal('declineReasonModal');
        showConfirmation(
            'Decline Request?',
            message,
            'Decline',
            'Cancel'
        );
    }

    function showConfirmation(title, message, confirmText, cancelText) {
        // Use the pop-up-modals component
        const modal = document.getElementById('confirmationModal');
        const titleElement = modal.querySelector('h2');
        const messageElement = modal.querySelector('p');
        const confirmButton = modal.querySelector('button.bg-g-dark');
        const cancelButton = modal.querySelector('button.border-g-dark');

        // Set the content
        titleElement.textContent = title;
        messageElement.textContent = message;
        confirmButton.textContent = confirmText;
        cancelButton.textContent = cancelText;

        // Style the confirm button based on action
        if (pendingAction === 'decline') {
            confirmButton.classList.remove('bg-g-dark', 'hover:bg-g-dark/90');
            confirmButton.classList.add('bg-r-dark', 'hover:bg-red-600');
        } else {
            confirmButton.classList.remove('bg-r-dark', 'hover:bg-red-600');
            confirmButton.classList.add('bg-g-dark', 'hover:bg-g-dark/90');
        }

        // Replace the form action with custom function
        const form = modal.querySelector('form');
        if (form) {
            form.remove();
        }

        // Create a new button container
        const buttonContainer = modal.querySelector('.flex.justify-center.space-x-3');
        buttonContainer.innerHTML = `
        <button type="button" onclick="processAction()"
                class="bg-g-dark text-white px-4 py-2 rounded-md font-semibold hover:bg-g-dark/90" 
                id="confirmActionButton">
            ${confirmText}
        </button>
        <button type="button" onclick="closeModal('confirmationModal')"
                class="border border-g-dark text-g-dark px-4 py-2 rounded-md font-semibold hover:bg-gray-100">
            ${cancelText}
        </button>
    `;

        // Update the confirm button styling
        const actionButton = document.getElementById('confirmActionButton');
        if (pendingAction === 'decline') {
            actionButton.classList.remove('bg-g-dark', 'hover:bg-g-dark/90');
            actionButton.classList.add('bg-r-dark', 'hover:bg-red-600');
        }

        openModal('confirmationModal');
    }

    function processAction() {
        if (!currentRequestId) return;

        closeModal('confirmationModal');

        if (pendingAction === 'decline') {
            closeModal('declineReasonModal');
        } else {
            closeModal('reasonRequestModal');
        }

        const status = pendingAction === 'approve' ? 'approved' : 'rejected';
        const declineReason = document.getElementById('decline_reason').value;

        // Create form data
        const formData = new FormData();
        formData.append('status', status);
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('_method', 'PATCH');

        if (declineReason) {
            formData.append('decline_reason', declineReason);
        }

        // Send the request
        fetch(`/superadmin/data-requests/${currentRequestId}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(errorData => {
                        throw new Error(errorData.error || `HTTP error! status: ${response.status}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Success - reload the page to update the table
                    location.reload();
                } else {
                    throw new Error(data.error || 'Unknown error occurred');
                }
            })
            .catch(error => {
                console.error('Error updating request:', error);
                alert('Error: ' + error.message);
            });
    }

    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
        document.getElementById(modalId).classList.add('flex');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
        document.getElementById(modalId).classList.remove('flex');

        // Reset decline reason if closing decline modal
        if (modalId === 'declineReasonModal') {
            document.getElementById('decline_reason').value = '';
        }
    }

    // Close modal when clicking outside
    document.addEventListener('click', function(event) {
        const modals = ['reasonRequestModal', 'declineReasonModal', 'confirmationModal'];
        modals.forEach(modalId => {
            const modal = document.getElementById(modalId);
            if (event.target === modal) {
                closeModal(modalId);
            }
        });
    });
</script>