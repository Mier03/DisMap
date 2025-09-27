@props(['id', 'hospitals', 'barangays', 'diseases'])

{{-- =========================
    Add Patient Modal
========================= --}}
<div id="addPatientModal" class="hidden fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg w-[600px] p-8 text-left relative overflow-y-auto max-h-[80vh]">
        <h2 class="text-3xl font-bold text-g-dark mt-8 ml-8">Add Patient</h2>
        <p class="text-g-dark text-base mt-2 ml-8">Record a new patient case</p>

        <div class="px-8 py-4">
            <form id="addPatientForm" action="{{ route('admin.patients.store') }}" method="POST">
                @csrf

                {{-- Phase 1: Personal Information --}}
                <div id="phase1">
                    <h3 class="text-2xl font-bold text-g-dark mb-4">Personal Information</h3>

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
                                required placeholder="Middle Name" />
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
                            <x-input-error :messages="$errors->get('birthdate')" class="mt-2" />
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
                            <x-input-error :messages="$errors->get('ethnicity')" class="mt-2" />
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

                    {{-- Contact Number --}}
                    <div class="mb-4">
                        <x-input-label for="contact_number_input" :value="__('Contact Number')" />
                        <div class="flex items-center space-x-2">
                            <div class="relative">
                                <select id="country_code" name="country_code" disabled
                                    class="block w-[80px] mt-1 rounded-l border border-g-dark bg-[#F2F2F2] pl-3 pr-3 py-2 text-sm text-g-dark focus:outline-none focus:ring-2 focus:ring-g-dark/50">
                                    <option value="+63" selected>PH +63</option>
                                </select>
                            </div>
                            <x-text-input id="contact_number_input" class="block mt-1 flex-1" 
                                type="tel" :value="old('contact_number_input')" 
                                required placeholder="9123456789" 
                                pattern="[0-9]{9,10}" 
                                onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" 
                                oninput="updateContactNumber()" />
                            <input type="hidden" id="contact_number" name="contact_number" :value="old('contact_number')" />
                        </div>
                        <x-input-error :messages="$errors->get('contact_number')" class="mt-2" />
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

                    {{-- Email --}}
                    <div class="mb-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" 
                            type="email" name="email" :value="old('email')" 
                            required placeholder="Enter valid email address..." />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="flex justify-end mt-6">
                        <x-primary-button type="button" onclick="nextPhase(1)">
                            Next
                        </x-primary-button>
                    </div>
                </div>

                {{-- Phase 2: Medical Information --}}
                <div id="phase2" class="hidden">
                    <h3 class="text-2xl font-bold text-g-dark mb-4">Medical Information</h3>

                    {{-- Diseases Container --}}
                    <div id="diseases-container">
                        <div class="disease-entry mb-4">
                            <div class="mb-2">
                                <x-input-label for="disease_id_0" :value="__('Disease')" />
                                <x-dropdown-select id="disease_id_0" name="disease_id[]" required>
                                    <option value="" disabled selected>Select disease...</option>
                                    @foreach($diseases as $disease)
                                        <option value="{{ $disease->id }}">{{ $disease->specification }}</option>
                                    @endforeach
                                </x-dropdown-select>
                                <x-input-error :messages="$errors->get('disease_id.0')" class="mt-2" />
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

                    <a href="#" onclick="addAnotherDisease()" class="text-blue-600 hover:underline mb-4 block">Add another disease</a>

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

                    <div class="flex justify-between mt-6">
                        <button type="button" onclick="prevPhase(2)"
                            class="w-[168px] h-[40px] bg-[#F2F2F2] text-g-dark text-[14px] font-semibold rounded hover:bg-gray-200 transition">
                            Back
                        </button>
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

                    <div class="flex justify-between mt-6">
                        <button type="button" onclick="prevPhase(3)"
                            class="w-[168px] h-[40px] bg-[#F2F2F2] text-g-dark text-[14px] font-semibold rounded hover:bg-gray-200 transition">
                            Back
                        </button>
                        <x-primary-button type="submit">
                            + Add Patient
                        </x-primary-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // JavaScript for addPatientModal

    let diseaseCounter = 1; // Start from 1 since initial is 0

    function addAnotherDisease() {
        const container = document.getElementById('diseases-container');
        const entry = document.createElement('div');
        entry.className = 'disease-entry mb-4';

        const initialSelect = document.getElementById('disease_id_0');
        const optionsHTML = initialSelect.innerHTML;

        const diseaseHtml = `
            <div class="mb-2">
                <label for="disease_id_${diseaseCounter}" class="block text-sm font-medium text-gray-900">Disease</label>
                <select id="disease_id_${diseaseCounter}" name="disease_id[]" required
                    class="block w-full mt-1 rounded border border-g-dark bg-[#F2F2F2] px-3 py-2 text-sm text-g-dark focus:outline-none focus:ring-2 focus:ring-g-dark/50">
                    ${optionsHTML}
                </select>
            </div>
            <div class="mb-2">
                <label for="reported_remarks_${diseaseCounter}" class="block text-sm font-medium text-gray-900">Remarks</label>
                <textarea id="reported_remarks_${diseaseCounter}" name="reported_remarks[]" 
                    class="w-full h-[100px] border border-g-dark rounded px-3 py-2 text-sm text-g-dark bg-[#F2F2F2] resize-none focus:outline-none focus:ring-2 focus:ring-g-dark/50" 
                    placeholder="Enter remarks..." required></textarea>
            </div>
        `;

        entry.innerHTML = diseaseHtml;
        container.appendChild(entry);
        diseaseCounter++;
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

        // Additional validation for contact number
        if (phase === 1) {
            const contactNumberInput = document.getElementById('contact_number_input');
            const contactNumberPattern = /^[0-9]{9,10}$/;
            if (!contactNumberPattern.test(contactNumberInput.value)) {
                isValid = false;
                contactNumberInput.classList.add('border-red-500');
                alert('Contact number must be 9-10 digits.');
            } else {
                contactNumberInput.classList.remove('border-red-500');
            }
        }

        return isValid;
    }

    function nextPhase(current) {
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

        // Personal Info
        const personal = document.createElement('div');
        personal.innerHTML = `
            <h4 class="font-bold text-lg mb-2">Personal Information</h4>
            <p><strong>Full Name:</strong> ${document.getElementById('first_name').value} ${document.getElementById('middle_name').value} ${document.getElementById('last_name').value}</p>
            <p><strong>Date of Birth:</strong> ${document.getElementById('birthdate').value}</p>
            <p><strong>Sex:</strong> ${document.getElementById('sex').value}</p>
            <p><strong>Ethnicity:</strong> ${document.getElementById('ethnicity').value}</p>
            <p><strong>Street Address:</strong> ${document.getElementById('street_address').value}</p>
            <p><strong>Contact Number:</strong> ${document.getElementById('contact_number').value}</p>
            <p><strong>Barangay:</strong> ${document.getElementById('barangay_id').options[document.getElementById('barangay_id').selectedIndex].text}</p>
            <p><strong>Email:</strong> ${document.getElementById('email').value}</p>`;
        summary.appendChild(personal);

        // Medical Info
        const medical = document.createElement('div');
        medical.innerHTML = '<h4 class="font-bold text-lg mb-2">Medical Information</h4>';

        const diseaseEntries = document.querySelectorAll('.disease-entry');
        diseaseEntries.forEach((entry, index) => {
            const diseaseSelect = entry.querySelector(`select[name="disease_id[]"]`);
            const remarks = entry.querySelector(`textarea[name="reported_remarks[]"]`);
            const diseaseP = document.createElement('p');
            diseaseP.innerHTML = `<strong>Disease ${index + 1}:</strong> ${diseaseSelect.options[diseaseSelect.selectedIndex]?.text || 'Not selected'}<br><strong>Remarks:</strong> ${remarks.value || 'N/A'}`;
            medical.appendChild(diseaseP);
        });

        medical.innerHTML += `<p><strong>Hospital:</strong> ${document.getElementById('hospital_id').options[document.getElementById('hospital_id').selectedIndex]?.text || 'Not selected'}</p>`;
        summary.appendChild(medical);
    }

    function resetAddPatientForm() {
        const form = document.getElementById('addPatientForm');
        form.reset();
        document.getElementById('phase1').classList.remove('hidden');
        document.getElementById('phase2').classList.add('hidden');
        document.getElementById('phase3').classList.add('hidden');
        const container = document.getElementById('diseases-container');
        container.innerHTML = `
            <div class="disease-entry mb-4">
                <div class="mb-2">
                    <label for="disease_id_0" class="block text-sm font-medium text-gray-900">Disease</label>
                    <select id="disease_id_0" name="disease_id[]" required
                        class="block w-full mt-1 rounded border border-g-dark bg-[#F2F2F2] px-3 py-2 text-sm text-g-dark focus:outline-none focus:ring-2 focus:ring-g-dark/50">
                        <option value="" disabled selected>Select disease...</option>
                        @foreach($diseases as $disease)
                            <option value="{{ $disease->id }}">{{ $disease->specification }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-2">
                    <label for="reported_remarks_0" class="block text-sm font-medium text-gray-900">Remarks</label>
                    <textarea id="reported_remarks_0" name="reported_remarks[]" 
                        class="w-full h-[100px] border border-g-dark rounded px-3 py-2 text-sm text-g-dark bg-[#F2F2F2] resize-none focus:outline-none focus:ring-2 focus:ring-g-dark/50" 
                        placeholder="Enter remarks..." required></textarea>
                </div>
            </div>
        `;
        diseaseCounter = 1;
        document.getElementById('contact_number').value = '';
    }

    // Initialize contact number on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateContactNumber();
    });
</script>