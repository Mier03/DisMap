@props(['id', 'hospitals', 'barangays', 'diseases'])

{{-- Wrapper that holds ALL modals --}}
<div>
    {{-- =========================
        Add Patient Modal
    ========================== --}}
    <div id="addPatientModal" class="hidden fixed inset-0 items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-[500px] text-left relative overflow-y-auto max-h-[80vh]">
            <h2 class="text-3xl font-bold text-g-dark mt-8 ml-8">Add Patient</h2>
            <p class="text-g-dark text-base mt-2 ml-8">Record a new patient case</p>

            <div class="px-8 py-4">
                <form action="{{ route('admin.patients.store') }}" method="POST">
                    @csrf

                    {{-- Full Name --}}
                    <div class="mb-4">
                        <x-input-label for="fullName" :value="__('Full Name')" />
                        <x-text-input id="fullName" class="block mt-1 w-full" 
                            type="text" name="fullName" :value="old('fullName')" 
                            required placeholder="Enter patient full name..." />
                        <x-input-error :messages="$errors->get('fullName')" class="mt-2" />
                    </div>

                    {{-- Birthdate --}}
                    <div class="mb-4">
                        <x-input-label for="birthdate" :value="__('Birthdate')" />
                        <x-text-input id="birthdate" class="block mt-1 w-full" 
                            type="date" name="birthdate" :value="old('birthdate')" 
                            required />
                        <x-input-error :messages="$errors->get('birthdate')" class="mt-2" />
                    </div>

                    {{-- Barangay --}}
                    <div class="mb-4">
                        <x-input-label for="barangay_id" :value="__('Barangay')" />
                        <x-dropdown-select id="barangay_id" name="barangay_id" required>
                            <option value="" disabled selected>Select barangay...</option>
                            @foreach($barangays as $barangay)
                                <option value="{{ $barangay->id }}">{{ $barangay->name }}</option>
                            @endforeach
                        </x-dropdown-select>
                        <x-input-error :messages="$errors->get('barangay_id')" class="mt-2" />
                    </div>

                    {{-- Diseases --}}
                    <div class="mb-4">
                        <x-input-label for="disease_id" :value="__('Disease')" />
                        <x-dropdown-select id="disease_id" name="disease_select">
                            <option value="" disabled selected>Select patient’s disease...</option>
                            @foreach($diseases as $disease)
                                <option value="{{ $disease->id }}">{{ $disease->specification }}</option>
                            @endforeach
                        </x-dropdown-select>
                        <input type="hidden" name="disease_id[]" id="disease_id_hidden" value="">
                        <div id="disease-tags" class="mt-2 flex flex-wrap gap-2"></div>
                        <x-input-error :messages="$errors->get('disease_id')" class="mt-2" />
                        <x-input-error :messages="$errors->get('disease_id.*')" class="mt-2" />
                    </div>

                    {{-- Remarks --}}
                    <div class="mb-4">
                        <x-input-label for="reported_remarks" :value="__('Remarks')" />
                        <x-text-input id="reported_remarks" class="block mt-1 w-full" 
                            type="text" name="reported_remarks" :value="old('reported_remarks')" 
                            placeholder="Enter any relevant remarks..." />
                        <x-input-error :messages="$errors->get('reported_remarks')" class="mt-2" />
                    </div>

                    {{-- Hospital --}}
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

                    {{-- Email --}}
                    <div class="mb-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" 
                            type="email" name="email" :value="old('email')" 
                            required placeholder="Enter valid email address..." />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="flex justify-between space-x-2 mt-6">
                        <x-primary-button id="addPatientButton">
                            {{ __('+ Add Patient') }}
                        </x-primary-button>
                        <button type="button" onclick="closeModal('addPatientModal')"
                                class="w-[168px] h-[40px] bg-[#F2F2F2] text-g-dark text-[14px] font-semibold rounded hover:bg-gray-200 transition">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- =========================
        Add Hospital Modal
    ========================== --}}
    <div id="addHospitalModal" class="hidden fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-[500px]">
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

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="document.getElementById('addHospitalModal').classList.add('hidden')"
                            class="w-[168px] h-[40px] bg-[#F2F2F2] text-g-dark text-[14px] font-semibold rounded hover:bg-gray-200 transition">Cancel</button>
                    <x-primary-button>
                        {{ __('Submit') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

    {{-- =========================
        Edit Patient Modal
    ========================== --}}
    <div id="editPatientModal" class="hidden fixed inset-0 items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-[500px]">
            <h2 class="text-2xl font-bold text-g-dark">Edit Patient</h2>
            <p class="text-g-dark text-base">Edit patient details here...</p>
            <button onclick="closeModal('editPatientModal')" class="mt-4 w-[168px] h-[40px] bg-[#F2F2F2] text-g-dark text-[14px] font-semibold rounded hover:bg-gray-200 transition">
                Close
            </button>
        </div>
    </div>

    {{-- =========================
        Export Modal
    ========================== --}}
    <div id="exportModal" class="hidden fixed inset-0 items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white rounded-lg shadow-lg w-[500px] p-8 text-left relative">
            <div class="flex items-center mb-2">
                <svg class="w-[32px] h-[32px] text-g-dark fill-current"
                     xmlns="resources/svg/filter.svg" viewBox="0 0 24 24">
                    <path d="M3 4h18l-7 9v7l-4-2v-5z"/>
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

            <div class="flex justify-center gap-4 mt-10">
                <x-primary-button>
                    {{ __('Export PDF') }}
                </x-primary-button>
                <button type="button" onclick="closeModal('exportModal')"
                        class="w-[168px] h-[40px] bg-[#F2F2F2] text-g-dark text-[14px] font-semibold rounded hover:bg-gray-200 transition">
                    Cancel
                </button>
            </div>
        </div>
    </div>

    {{-- =========================
        Request Data Modal
    ========================== --}}
    <div id="requestDataModal" class="hidden fixed inset-0 items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white rounded-lg shadow-lg w-[600px] p-8 text-left relative hidden">
            <div class="flex items-center mb-2">
                <svg xmlns="resources/svg/filter.svg" class="w-[32px] h-[32px] text-g-dark fill-current"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z"/>
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
                    <button type="button" onclick="closeModal('requestDataModal')"
                            class="w-[168px] h-[40px] bg-[#F2F2F2] text-g-dark text-[14px] font-semibold rounded hover:bg-gray-200 transition">
                        Cancel
                    </button>
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
    <div id="reasonRequestModal" class="hidden fixed inset-0 items-center justify-center bg-black bg-opacity-50 z-50">
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
                    <button type="button" onclick="closeModal('reasonRequestModal')"
                            class="w-[168px] h-[40px] bg-[#F2F2F2] text-g-dark text-[14px] font-semibold rounded hover:bg-gray-200 transition">
                        Decline
                    </button>
                </div>
            </form>

            <button type="button" onclick="closeModal('reasonRequestModal')"
                    class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
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
                <!-- Dynamic content will be injected here via JavaScript -->
            </div>

            <div class="flex justify-center gap-4 mt-8">
                <button type="button" onclick="closeModal('patientDetailsModal')"
                        class="w-[168px] h-[40px] bg-[#F2F2F2] text-g-dark text-[14px] font-semibold rounded hover:bg-gray-200 transition">
                    Close
                </button>
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
                            <button type="button" id="cancelRecoveryForm" 
                                class="w-[168px] h-[40px] bg-[#F2F2F2] text-g-dark text-[14px] font-semibold rounded hover:bg-gray-200 transition">
                                Cancel
                            </button>
                            <x-primary-button>Save Changes</x-primary-button>
                        </div>
                    </form>
                `;
            }

            contentDiv.innerHTML = htmlContent;
            openModal('patientDetailsModal');

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

    document.addEventListener('DOMContentLoaded', function() {
        const modals = document.querySelectorAll('.fixed.bg-black.bg-opacity-50');
        modals.forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeModal(modal.id);
                }
            });
        });

        // Handle disease selection and tags
        const diseaseSelect = document.getElementById('disease_id');
        const diseaseTagsContainer = document.getElementById('disease-tags');
        const diseaseHiddenInput = document.getElementById('disease_id_hidden');
        let selectedDiseases = [];

        function updateHiddenInput() {
            if (diseaseHiddenInput) {
                diseaseHiddenInput.value = selectedDiseases.join(',');
                const existingInputs = document.querySelectorAll('input[name="disease_id[]"]');
                existingInputs.forEach(input => input.remove());
                selectedDiseases.forEach(diseaseId => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'disease_id[]';
                    input.value = diseaseId;
                    diseaseTagsContainer.appendChild(input);
                });
                diseaseSelect.required = selectedDiseases.length === 0;
            }
        }

        if (diseaseSelect && diseaseTagsContainer) {
            diseaseSelect.addEventListener('change', function() {
                const selectedValue = diseaseSelect.value;
                const selectedText = diseaseSelect.options[diseaseSelect.selectedIndex].text;

                if (selectedValue && selectedText !== 'Select patient’s disease...' && !selectedDiseases.includes(selectedValue)) {
                    selectedDiseases.push(selectedValue);

                    const tag = document.createElement('span');
                    tag.className = 'bg-gray-200 text-gray-700 text-sm px-2 py-1 rounded flex items-center';
                    tag.textContent = selectedText;

                    const removeBtn = document.createElement('button');
                    removeBtn.textContent = 'x';
                    removeBtn.className = 'ml-2 text-gray-500 hover:text-gray-700';
                    removeBtn.onclick = () => {
                        selectedDiseases = selectedDiseases.filter(id => id !== selectedValue);
                        tag.remove();
                        updateHiddenInput();
                    };
                    tag.appendChild(removeBtn);
                    diseaseTagsContainer.appendChild(tag);

                    diseaseSelect.value = '';
                    updateHiddenInput();
                }
            });
        }

        function resetForm(id) {
            const form = document.querySelector(`#${id} form`);
            if (form) {
                form.reset();
                if (diseaseTagsContainer) {
                    diseaseTagsContainer.innerHTML = '';
                    selectedDiseases = [];
                    updateHiddenInput();
                }
            }
        }

        document.querySelectorAll('button[onclick^="closeModal"]').forEach(button => {
            button.addEventListener('click', () => resetForm('addPatientModal'));
        });

        if (diseaseHiddenInput) {
            updateHiddenInput();
        }
    });

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
</script>