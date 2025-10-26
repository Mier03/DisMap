@props([
    'id',
    'hospitals' => [],
    'barangays' => [],
    'diseases' => [],
    'patient' => null,
])

<div>
{{-- =========================
    Add Patient Modal
========================= --}}
@if($id=='addPatientModal')
    <x-modals.modal-popup
        modal-id="addPatientModal"
        title="Add Patient"
        description="Record a new patient case"
        icon="person_add"
    >
                <form id="addPatientForm" action="{{ route('admin.patients.store') }}" method="POST">
                    @csrf

                    {{-- Phase 1: Personal Information --}}
                    <div id="phase1">
                        <h3 class="text-2xl font-bold text-g-dark my-4">Personal Information</h3>

                        {{-- First Name, Middle Name, Last Name --}}
                        <div class="grid grid-cols-3 gap-4 mb-4">
                            <div>
                                <x-input-label for="first_name" :value="__('First Name')" />
                                <x-text-input id="first_name" class="block mt-1 w-full"
                                    type="text" name="first_name" :value="old('first_name')"
                                    required placeholder="First Name" />
                                <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="middle_name" :value="__('Middle Name')" />
                                <x-text-input id="middle_name" class="block mt-1 w-full"
                                    type="text" name="middle_name" :value="old('middle_name')"
                                    placeholder="Middle Name" />
                                <x-input-error :messages="$errors->get('middle_name')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="last_name" :value="__('Last Name')" />
                                <x-text-input id="last_name" class="block mt-1 w-full"
                                    type="text" name="last_name" :value="old('last_name')"
                                    required placeholder="Last Name" />
                                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                            </div>
                        </div>

                        {{-- Date of Birth, Sex, Ethnicity --}}
                        <div class="grid grid-cols-3 gap-4 mb-4">
                            <div>
                                <x-input-label for="birthdate" :value="__('Date of Birth')" />
                                <x-text-input id="birthdate" class="block mt-1 w-full"
                                    type="date" name="birthdate" :value="old('birthdate')"
                                    required />
                            </div>
                            <div>
                                <x-input-label for="sex" :value="__('Sex')" />
                                <x-dropdown-select id="sex" name="sex" required>
                                    <option value="" disabled selected>Select sex...</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </x-dropdown-select>
                                <x-input-error :messages="$errors->get('sex')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="ethnicity" :value="__('Ethnicity')" />
                                <x-dropdown-select id="ethnicity" name="ethnicity" required>
                                    <option value="" disabled selected>Select ethnicity...</option>
                                    <option value="Filipino">Filipino</option>
                                    <option value="Chinese">Chinese</option>
                                    <option value="American">American</option>
                                    <option value="Other">Other</option>
                                </x-dropdown-select>
                            </div>
                        </div>

                        {{-- Street Address --}}
                        <div class="mb-4">
                            <x-input-label for="street_address" :value="__('Street Address')" />
                            <x-text-input id="street_address" class="block mt-1 w-full"
                                type="text" name="street_address" :value="old('street_address')"
                                required placeholder="Enter street address..." />
                            <x-input-error :messages="$errors->get('street_address')" class="mt-2" />
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

                        {{-- Contact Number --}}
                        <div class="mb-4">
                            <x-input-label for="contact_number_input" :value="__('Contact Number')" />
                            <div class="flex items-center space-x-2">
                                <div class="relative">
                                    <select id="country_code" name="country_code" disabled
                                        class="block w-[90px] mt-1 rounded-l border border-g-dark bg-[#F2F2F2] pl-3 pr-3 py-2 text-sm text-g-dark focus:outline-none focus:ring-2 focus:ring-g-dark/50">
                                        <option value="+63" selected>PH +63</option>
                                    </select>
                                </div>
                                <x-text-input id="contact_number_input" class="block mt-1 flex-1"
                                    type="tel" :value="old('contact_number_input')"
                                    required placeholder="XXXXXXXXXX"
                                    pattern="[0-9]{9,10}"
                                    onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"
                                    oninput="updateContactNumber()" />
                                <input type="hidden" id="contact_number" name="contact_number" :value="old('contact_number')" />
                            </div>
                            <x-input-error :messages="$errors->get('contact_number')" class="mt-2" />
                        </div>

                        {{-- Email --}}
                        <div class="mb-4">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full"
                                type="email" name="email" :value="old('email')"
                                required placeholder="Enter valid email address..." />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div class="flex flex-col sm:flex-row gap-40 mt-10">
                            <x-secondary-button type="button" onclick="closeModal('{{ $id }}')">
                                Cancel
                            </x-secondary-button>
                            <x-primary-button type="button" onclick="nextPhase(1)">
                                Next
                            </x-primary-button>

                        </div>
                    </div>

                    {{-- Phase 2: Medical Information --}}
                    <div id="phase2" class="hidden">
                        <h3 class="text-2xl font-bold text-g-dark mb-4">Medical Information</h3>

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

                        {{-- Diseases Container --}}
                        <div id="diseases-container">
                            <div class="disease-entry mb-4">
                                <div class="mb-2">
                                    <x-input-label for="disease_id_0" :value="__('Disease')" />
                                    <x-dropdown-select id="disease_id_0" name="disease_id[]" required onchange="toggleCustomDiseaseInput(this, 0)">
                                        <option value="" disabled selected>Select disease...</option>
                                        @foreach($diseases as $disease)
                                            <option value="{{ $disease->id }}">{{ $disease->specification }}</option>
                                        @endforeach
                                        <option value="other_specify">Other (Specify)</option>
                                    </x-dropdown-select>
                                    <x-input-error :messages="$errors->get('disease_id.0')" class="mt-2" />
                                </div>

                                <div id="custom_disease_container_0" class="mb-2 hidden">
                                    <h4 class="text-md font-semibold text-g-dark mb-2">Specify New Disease</h4>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <x-input-label for="custom_disease_name_0" :value="__('General Name (e.g., Dementia)')" />
                                            <x-text-input id="custom_disease_name_0" class="block mt-1 w-full"
                                                type="text" name="custom_disease_name[]"
                                                placeholder="Enter general disease name..." />
                                            <x-input-error :messages="$errors->get('custom_disease_name.0')" class="mt-2" />
                                        </div>
                                        <div>
                                            <x-input-label for="custom_disease_spec_0" :value="__('Specification (e.g., Alzheimer)')" />
                                            <x-text-input id="custom_disease_spec_0" class="block mt-1 w-full"
                                                type="text" name="custom_disease_spec[]"
                                                placeholder="Enter specific disease name..." />
                                            <x-input-error :messages="$errors->get('custom_disease_spec.0')" class="mt-2" />
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <x-input-label for="reported_remarks_0" :value="__('Remarks')" />
                                    <textarea id="reported_remarks_0" name="reported_remarks[]"
                                        class="w-full h-[100px] border border-g-dark rounded px-3 py-2 text-sm text-g-dark bg-[#F2F2F2] resize-none focus:outline-none focus:ring-2 focus:ring-g-dark/50"
                                        placeholder="Enter remarks..." required></textarea>
                                    <x-input-error :messages="$errors->get('reported_remarks.0')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <hr class="my-4 border-t border-gray-200">
                        <a href="#" onclick="addAnotherDisease()" class="text-g-dark hover:underline mb-4 block">+ Add another disease</a>

                        <div class="flex flex-col sm:flex-row gap-40 mt-10">
                            <x-secondary-button type="button" onclick="prevPhase(2)">
                                Back
                            </x-secondary-button>
                            <x-primary-button type="button" onclick="nextPhase(2)">
                                Next
                            </x-primary-button>

                        </div>
                    </div>

                    {{-- Phase 3: Review --}}
                    <div id="phase3" class="hidden">
                        <h3 class="text-2xl font-bold text-g-dark mb-4">Review Patient Details</h3>

                        <div id="review-summary" class="space-y-4">
                            <!-- Summary will be populated by JS -->
                        </div>

                        <div class="flex flex-col sm:flex-row gap-40 mt-10">
                            <x-secondary-button type="button" onclick="prevPhase(3)">
                                Back
                            </x-secondary-button>
                            <x-primary-button type="submit">
                                + Add Patient
                            </x-primary-button>

                        </div>
                    </div>
                </form>
                <button type="button" onclick="closeModal('{{$id}}')"
                    class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
                        ✕
                </button>
    </x-modals.modal-popup>
@endif
@if($id=='addRecordModal' && $patient)
    {{-- The existing patient information (read-only) blocks are fine. --}}

    <x-modals.modal-popup
        modal-id="addRecordModal"
        title="Add New Record"
        description="Record a new patient case"
        icon="assignment_add"
    >
                <form method="POST" action="{{ route('admin.patients.storeRecord') }}">
                    @csrf
                    <input type="hidden" name="patient_id" value="{{ $patient->id }}">

                    {{-- Personal Information (Read-only) --}}
                    <h3 class="text-2xl font-bold text-g-dark my-4">Patient Information</h3>

                    <div class="grid grid-cols-3 gap-4 mb-4">
                        <div>
                            <x-input-label :value="__('Full Name')" />
                            <input type="text" value="{{ $patient->name }}" readonly
                                class="block mt-1 w-full border border-gray-300 rounded bg-gray-100 text-gray-700 px-3 py-2"/>
                        </div>
                    <div>
                            <x-input-label :value="__('Date of Birth')" />
                            <input type="text"
                                value="{{ \Carbon\Carbon::parse($patient->birthdate)->format('F j, Y') }} ({{ \Carbon\Carbon::parse($patient->birthdate)->age }} years old)"
                                readonly
                                class="block mt-1 w-full border border-gray-300 rounded bg-gray-100 text-gray-700 px-3 py-2"/>
                        </div>
                        <div>
                            <x-input-label :value="__('Age')" />
                            <input type="text"
                                value="{{ \Carbon\Carbon::parse($patient->birthdate)->age }}"
                                readonly
                                class="block mt-1 w-full border border-gray-300 rounded bg-gray-100 text-gray-700 px-3 py-2"/>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4 mb-4">
                    <div>
                            <x-input-label :value="__('Sex')" />
                            <input type="text" value="{{ $patient->sex }}" readonly
                                class="block mt-1 w-full border border-gray-300 rounded bg-gray-100 text-gray-700 px-3 py-2"/>
                        </div>
                        <div>
                            <x-input-label :value="__('Ethnicity')" />
                            <input type="text" value="{{ $patient->ethnicity }}" readonly
                                class="block mt-1 w-full border border-gray-300 rounded bg-gray-100 text-gray-700 px-3 py-2"/>
                        </div>
                        <div class="mb-4">
                            <x-input-label :value="__('Contact Number')" />
                            <input type="text" value="{{ $patient->contact_number }}" readonly
                                class="block mt-1 w-full border border-gray-300 rounded bg-gray-100 text-gray-700 px-3 py-2"/>
                        </div>

                    </div>

                    <div class="grid grid-cols-3 gap-4 mb-4">
                            <div class="mb-4">
                                <x-input-label :value="__('Barangay')" />
                                <input type="text" value="{{ $patient->barangay->name ?? '' }}" readonly
                                    class="block mt-1 w-full border border-gray-300 rounded bg-gray-100 text-gray-700 px-3 py-2"/>
                            </div>
                            <div class="mb-4">
                                <x-input-label :value="__('Street Address')" />
                                <input type="text" value="{{ $patient->street_address }}" readonly
                                    class="block mt-1 w-full border border-gray-300 rounded bg-gray-100 text-gray-700 px-3 py-2"/>
                            </div>
                    </div>

                    {{-- Medical Information --}}
                    <h3 class="text-2xl font-bold text-g-dark mb-4 mt-6">Medical Information</h3>

                    <div class="mb-4">
                        <x-input-label for="hospital_id_record" :value="__('Hospital')" />
                        <x-dropdown-select id="hospital_id_record" name="hospital_id" required>
                            <option value="" disabled selected>Select hospital...</option>
                            @if(Auth::check())
                                @foreach(Auth::user()->approvedHospitals as $hospital)
                                    <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
                                @endforeach
                            @endif
                        </x-dropdown-select>
                        <x-input-error :messages="$errors->get('hospital_id')" class="mt-2" />
                    </div>

                    <div id="diseases-container-record">
                        <div class="disease-entry mb-4">
                            <div class="mb-2">
                                <x-input-label for="disease_id_0_record" :value="__('Disease')" />
                                <x-dropdown-select id="disease_id_0_record" name="disease_id[]" required onchange="toggleCustomDiseaseInput(this, 0, 'record')">
                                    <option value="" disabled selected>Select disease...</option>
                                    @foreach($diseases as $disease)
                                        <option value="{{ $disease->id }}">{{ $disease->specification }}</option>
                                    @endforeach
                                    <option value="other_specify">Other (Specify)</option>
                                </x-dropdown-select>
                                <x-input-error :messages="$errors->get('disease_id.0')" class="mt-2" />
                            </div>

                            <div id="custom_disease_container_0_record" class="mb-2 hidden">
                                <h4 class="text-md font-semibold text-g-dark mb-2">Specify New Disease</h4>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <x-input-label for="custom_disease_name_0_record" :value="__('General Name (e.g., Dementia)')" />
                                        <x-text-input id="custom_disease_name_0_record" class="block mt-1 w-full"
                                            type="text" name="custom_disease_name[]"
                                            placeholder="Enter general disease name..." />
                                    </div>
                                    <div>
                                        <x-input-label for="custom_disease_spec_0_record" :value="__('Specification (e.g., Alzheimer)')" />
                                        <x-text-input id="custom_disease_spec_0_record" class="block mt-1 w-full"
                                            type="text" name="custom_disease_spec[]"
                                            placeholder="Enter specific disease name..." />
                                    </div>
                                </div>
                            </div>

                            <div class="mb-2">
                                <x-input-label for="reported_remarks_0_record" :value="__('Remarks')" />
                                <textarea id="reported_remarks_0_record" name="reported_remarks[]"
                                    class="w-full h-[100px] border border-g-dark rounded px-3 py-2 text-sm text-g-dark bg-[#F2F2F2] resize-none focus:outline-none focus:ring-2 focus:ring-g-dark/50"
                                    placeholder="Enter remarks..." required></textarea>
                                <x-input-error :messages="$errors->get('reported_remarks.0')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <a href="#" onclick="addAnotherDisease('record')" class="text-g-dark hover:underline mb-4 block">+ Add another disease</a>

                    {{-- Actions --}}
                    <div class="flex justify-end gap-4 mt-6">
                        <x-secondary-button type="button" onclick="closeModal('{{ $id }}')">Cancel</x-secondary-button>
                        <x-primary-button type="submit">+ Add Record</x-primary-button>
                    </div>

                <button type="button" onclick="closeModal('{{ $id }}')"
                    class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">✕</button>

    </x-modals.modal-popup>
@endif
</div>
<script>
    // JavaScript for addPatientModal

    let diseaseCounter = 1;

    function addAnotherDisease(suffix = '') {
        const containerId = suffix === 'record' ? 'diseases-container-record' : 'diseases-container';
        const container = document.getElementById(containerId);

        const entry = document.createElement('div');
        entry.className = 'disease-entry mb-4';

        // Find the original select to copy its inner options
        const initialSelect = container.querySelector('select[name="disease_id[]"]');
        const allOptionsHtml = initialSelect ? initialSelect.innerHTML : '';

        const currentId = diseaseCounter;
        const selectId = `disease_id_${currentId}${suffix ? '_' + suffix : ''}`;
        const remarksId = `reported_remarks_${currentId}${suffix ? '_' + suffix : ''}`;
        const customContainerId = `custom_disease_container_${currentId}${suffix ? '_' + suffix : ''}`;

        const diseaseHtml = `
        <div class="mb-2">
            <hr class="my-4 border-t border-gray-200">
            <div class="flex justify-between items-center">
                <label for="${selectId}" class="block text-[14px] font-semibold text-g-dark">Disease</label>
                <a href="#" onclick="removeDiseaseEntry(this)" class="text-red-500 font-semibold hover:text-red-700 text-sm">✕</a>
            </div>
            <select id="${selectId}" name="disease_id[]" required
                onchange="toggleCustomDiseaseInput(this, ${currentId}, '${suffix}')"
                class="w-full h-[44px] border border-g-dark rounded px-3 mt-1 text-sm text-g-dark bg-[#F2F2F2] focus:outline-none focus:ring-2 focus:ring-g-dark/50">
                ${allOptionsHtml} </select>
        </div>

        <div id="${customContainerId}" class="mb-2 hidden">
            <h4 class="text-md font-semibold text-g-dark mb-2">Specify New Disease</h4>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="custom_disease_name_${currentId}${suffix ? '_' + suffix : ''}" class="block text-[14px] font-semibold text-g-dark">General Name (e.g., Dementia)</label>
                    <input id="custom_disease_name_${currentId}${suffix ? '_' + suffix : ''}" class="block mt-1 w-full border border-g-dark rounded px-3 py-2 text-sm text-g-dark bg-[#F2F2F2] focus:outline-none focus:ring-2 focus:ring-g-dark/50"
                        type="text" name="custom_disease_name[]"
                        placeholder="Enter general disease name..." />
                </div>
                <div>
                    <label for="custom_disease_spec_${currentId}${suffix ? '_' + suffix : ''}" class="block text-[14px] font-semibold text-g-dark">Specification (e.g., Alzheimer)</label>
                    <input id="custom_disease_spec_${currentId}${suffix ? '_' + suffix : ''}" class="block mt-1 w-full border border-g-dark rounded px-3 py-2 text-sm text-g-dark bg-[#F2F2F2] focus:outline-none focus:ring-2 focus:ring-g-dark/50"
                        type="text" name="custom_disease_spec[]"
                        placeholder="Enter specific disease name..." />
                </div>
            </div>
        </div>

        <div class="mb-2">
            <label for="${remarksId}" class="block text-[14px] font-semibold text-g-dark">Remarks</label>
            <textarea id="${remarksId}" name="reported_remarks[]"
                class="w-full h-[100px] border border-g-dark rounded px-3 py-2 text-sm text-g-dark bg-[#F2F2F2] resize-none focus:outline-none focus:ring-2 focus:ring-g-dark/50"
                placeholder="Enter remarks..." required></textarea>
        </div>
        `;

        entry.innerHTML = diseaseHtml;
        container.appendChild(entry);
        diseaseCounter++;
    }

    function toggleCustomDiseaseInput(selectElement, index, suffix = '') {
        const containerId = `custom_disease_container_${index}${suffix ? '_' + suffix : ''}`;
        const inputNameId = `custom_disease_name_${index}${suffix ? '_' + suffix : ''}`;
        const inputSpecId = `custom_disease_spec_${index}${suffix ? '_' + suffix : ''}`;

        const container = document.getElementById(containerId);
        const inputName = document.getElementById(inputNameId);
        const inputSpec = document.getElementById(inputSpecId);

        if (selectElement.value === 'other_specify') {
            container.classList.remove('hidden');
            if (inputName) inputName.setAttribute('required', 'required');
            if (inputSpec) inputSpec.setAttribute('required', 'required');
        } else {
            container.classList.add('hidden');
            if (inputName) {
                inputName.removeAttribute('required');
                inputName.value = '';
            }
            if (inputSpec) {
                inputSpec.removeAttribute('required');
                inputSpec.value = '';
            }
        }
    }

    function removeDiseaseEntry(link) {
        const entry = link.closest('.disease-entry');
        if (entry) {
            entry.remove();
        }
    }

    function updateContactNumber() {
        const countryCode = document.getElementById('country_code').value;
        const contactNumberInput = document.getElementById('contact_number_input').value;
        const contactNumberField = document.getElementById('contact_number');
        contactNumberField.value = countryCode + contactNumberInput;
    }

    function validatePhase(phase) {
        const phaseDiv = document.getElementById(`phase${phase}`);
        const requiredInputs = phaseDiv.querySelectorAll('[required]');
        let isValid = true;

        requiredInputs.forEach(input => {
            if (!input.value.trim()) {
                isValid = false;
                input.classList.add('border-red-500');
            } else {
                input.classList.remove('border-red-500');
            }
        });

        // validation for contact number
        if (phase === 1) {
            const contactNumberInput = document.getElementById('contact_number_input');
            const contactNumberPattern = /^[0-9]{9,10}$/;
            if (!contactNumberPattern.test(contactNumberInput.value)) {
                isValid = false;
                contactNumberInput.classList.add('border-red-500');
                // ALERT removed for non-blocking UI
            } else {
                contactNumberInput.classList.remove('border-red-500');
            }
        }

        // Validate disease inputs in Phase 2
        const diseaseEntries = document.querySelectorAll('#diseases-container .disease-entry');

        diseaseEntries.forEach((entry, index) => {
            const selectElement = entry.querySelector('select[name="disease_id[]"]');
            const customInputName = entry.querySelector('input[name="custom_disease_name[]"]');
            const customInputSpec = entry.querySelector('input[name="custom_disease_spec[]"]');

            if (selectElement && selectElement.value === 'other_specify') {
                if (!customInputName || !customInputName.value.trim()) {
                    isValid = false;
                    if(customInputName) customInputName.classList.add('border-red-500');
                } else if (customInputName) {
                    customInputName.classList.remove('border-red-500');
                }

                if (!customInputSpec || !customInputSpec.value.trim()) {
                    isValid = false;
                    if(customInputSpec) customInputSpec.classList.add('border-red-500');
                } else if (customInputSpec) {
                    customInputSpec.classList.remove('border-red-500');
                }
            }
        });

        return isValid;
    }

    function nextPhase(current) {
        if (current === 1) {
            updateContactNumber();
        }
        if (!validatePhase(current)) {
            alert('Please fill out all required fields correctly.');
            return;
        }

        document.getElementById(`phase${current}`).classList.add('hidden');
        const next = current + 1;
        document.getElementById(`phase${next}`).classList.remove('hidden');

        if (next === 3) {
            populateReview();
        }
    }

    function prevPhase(current) {
        document.getElementById(`phase${current}`).classList.add('hidden');
        const prev = current - 1;
        document.getElementById(`phase${prev}`).classList.remove('hidden');
    }

    function populateReview() {
        const summary = document.getElementById('review-summary');
        summary.innerHTML = '';

        function createInfoCardHtml(title, icon, items) {
            let content = '';

            items.forEach((item, index) => {
                const borderClass = index < items.length - 1 ? 'border-b border-g-light/50' : '';
                let valueHtml = '';

                if (item.badge) {
                    valueHtml = `<span class="px-3 py-1 rounded-full text-xs font-medium ${item.badge.class ?? ''}">
                                    ${item.badge.text ?? 'N/A'}
                                </span>`;
                } else {
                    valueHtml = `<span class="text-sm text-gray-800 text-right break-words">${item.value ?? 'N/A'}</span>`;
                }

                content += `
                    <div class="flex justify-between items-start py-2 ${borderClass}">
                        <span class="text-sm font-medium text-gray-600 mr-4">${item.label}</span>
                        ${valueHtml}
                    </div>`;
            });
            return `
                <div class="bg-white border border-g-dark rounded-lg p-4 shadow-md transition duration-300 hover:shadow-xl">
                    <div class="flex items-center mb-4 pb-2 border-b border-g-light/50">
                        <span class="material-icons text-g-dark mr-2 text-xl">${icon}</span>
                        <h3 class="text-lg font-semibold text-g-dark">${title}</h3>
                    </div>
                    <div class="space-y-1">
                        ${content}
                    </div>
                </div>`;
        }

        // --- 2. DATA COLLECTION & CARD GENERATION ---

        // A. Personal & Account Info Card Data
        const barangaySelect = document.getElementById('barangay_id');
        const barangayText = barangaySelect.options[barangaySelect.selectedIndex]?.text || 'N/A';

        const personalInfoItems = [
            { label: 'Full Name:', value: `${document.getElementById('first_name').value} ${document.getElementById('middle_name').value} ${document.getElementById('last_name').value}`.trim() },
            { label: 'Date of Birth:', value: document.getElementById('birthdate').value },
            { label: 'Sex:', value: document.getElementById('sex').value },
            { label: 'Ethnicity:', value: document.getElementById('ethnicity').value },
            { label: 'Address:', value: `${document.getElementById('street_address').value}, ${barangayText}, Cebu City, Philippines` },
            { label: 'Contact Number:', value: document.getElementById('contact_number').value },
            { label: 'Email:', value: document.getElementById('email').value },
        ];

        // B. Medical Information Card Data
        const medicalInfoItems = [];

        // Hospital
        const hospitalSelect = document.getElementById('hospital_id');
        const hospitalText = hospitalSelect?.options[hospitalSelect.selectedIndex]?.text || 'Not selected';
        medicalInfoItems.push({ label: 'Hospital:', value: hospitalText });

        // Diseases and Remarks
        const diseaseEntries = document.querySelectorAll('#diseases-container .disease-entry');
        diseaseEntries.forEach((entry, index) => {
            const diseaseSelect = entry.querySelector(`select[name="disease_id[]"]`);
            const remarks = entry.querySelector(`textarea[name="reported_remarks[]"]`);
            const customInputName = entry.querySelector(`input[name="custom_disease_name[]"]`);
            const customInputSpec = entry.querySelector(`input[name="custom_disease_spec[]"]`);

            let diseaseText = 'Not selected';
            if (diseaseSelect.value === 'other_specify' && customInputName && customInputSpec) {
                diseaseText = `General: <strong>${customInputName.value || 'N/A'}</strong>; Specific: <strong>${customInputSpec.value || 'N/A'}</strong>`;
            } else {
                diseaseText = diseaseSelect?.options[diseaseSelect.selectedIndex]?.text || 'Not selected';
            }

            medicalInfoItems.push({ label: `Disease ${index + 1}:`, value: diseaseText });
            medicalInfoItems.push({ label: 'Remarks:', value: remarks.value || 'N/A' });
        });

        const personalCardHtml = createInfoCardHtml('Personal Information', 'person', personalInfoItems);
        const medicalCardHtml = createInfoCardHtml('Medical Information', 'healing', medicalInfoItems); // Using 'healing' icon

        const cardsContainer = document.createElement('div');
        cardsContainer.className = 'grid grid-cols-1 md:grid-cols-1 gap-6 mb-6';

        cardsContainer.innerHTML = personalCardHtml + medicalCardHtml;

        summary.appendChild(cardsContainer);
    }

    function resetAddPatientForm() {
        const form = document.getElementById('addPatientForm');
        form.reset();

        document.getElementById('phase1').classList.remove('hidden');
        document.getElementById('phase2').classList.add('hidden');
        document.getElementById('phase3').classList.add('hidden');

        const container = document.getElementById('diseases-container');

        const initialEntry = container.querySelector('.disease-entry');
        const dynamicEntries = container.querySelectorAll('.disease-entry:not(:first-child)');

        dynamicEntries.forEach(entry => entry.remove());

        // Reset the base elements of the first entry (assuming index 0)
        const select = initialEntry.querySelector('select[name="disease_id[]"]');
        const remarks = initialEntry.querySelector('textarea[name="reported_remarks[]"]');
        const customContainer = document.getElementById('custom_disease_container_0');
        const customName = document.getElementById('custom_disease_name_0');
        const customSpec = document.getElementById('custom_disease_spec_0');


        if (select) select.value = "";
        if (remarks) remarks.value = "";
        if (customContainer) customContainer.classList.add('hidden');
        if (customName) {
            customName.value = "";
            customName.removeAttribute('required');
        }
        if (customSpec) {
            customSpec.value = "";
            customSpec.removeAttribute('required');
        }

        diseaseCounter = 1;
        document.getElementById('contact_number').value = '';
    }

    // Initialize contact number on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateContactNumber();
    });
</script>