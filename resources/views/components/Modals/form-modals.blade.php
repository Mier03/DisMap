@props([
    'id',
    'formType',
    'action',
    'barangays' => [],
    'diseases' => [],
    'hospitals' => [],
])

<div id="{{ $id }}" class="hidden fixed inset-0 items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-[500px] text-left relative">
        <h2 class="text-3xl font-bold text-g-dark mt-8 ml-8">
            {{ $formType === 'addPatient' ? 'Add Patient' : 'Unknown Form' }}
        </h2>
        <p class="text-g-dark text-base mt-2 ml-8">
            {{ $formType === 'addPatient' ? 'Record a new patient case' : '' }}
        </p>

        @if($formType === 'addPatient')
            <div class="px-8 py-4">
                <form action="{{ $action }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="fullName" class="block text-sm font-medium text-g-dark">Full Name</label>
                        <input type="text" name="fullName" id="fullName" placeholder="Enter patient full name..." required
                               class="mt-1 block w-full rounded-md border-g-dark shadow-sm">
                        @error('fullName')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="birthdate" class="block text-sm font-medium text-g-dark">Birthdate</label>
                        <input type="date" name="birthdate" id="birthdate" required
                               class="mt-1 block w-full rounded-md border-g-dark shadow-sm">
                        @error('birthdate')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="barangay_id" class="block text-sm font-medium text-g-dark">Barangay</label>
                        <select name="barangay_id" id="barangay_id" required
                                class="mt-1 block w-full rounded-md border-g-dark shadow-sm">
                            <option value="" disabled selected>Select barangay...</option>
                            @foreach($barangays as $barangay)
                                <option value="{{ $barangay->id }}">{{ $barangay->name }}</option>
                            @endforeach
                        </select>
                        @error('barangay_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="disease_id" class="block text-sm font-medium text-g-dark">Disease</label>
                        <select name="disease_select" id="disease_id"
                                class="mt-1 block w-full rounded-md border-g-dark shadow-sm">
                            <option value="" disabled selected>Select patient’s disease...</option>
                            @foreach($diseases as $disease)
                                <option value="{{ $disease->id }}">{{ $disease->specification }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="disease_id[]" id="disease_id_hidden" value="">
                        <div id="disease-tags" class="mt-2 flex flex-wrap gap-2"></div>
                        @error('disease_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                        @error('disease_id.*')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="remarks" class="block text-sm font-medium text-g-dark">Remarks</label>
                        <input type="text" name="remarks" id="remarks" placeholder="Enter any relevant remarks..."
                               class="mt-1 block w-full rounded-md border-g-dark shadow-sm">
                        @error('remarks')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="hospital_id" class="block text-sm font-medium text-g-dark">Hospital</label>
                        <select name="hospital_id" id="hospital_id" required
                                class="mt-1 block w-full rounded-md border-g-dark shadow-sm">
                            <option value="" disabled selected>Select hospital...</option>
                            @foreach($hospitals as $hospital)
                                <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
                            @endforeach
                        </select>
                        @error('hospital_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-g-dark">Email</label>
                        <input type="email" name="email" id="email" placeholder="Enter valid email address..." required
                               class="mt-1 block w-full rounded-md border-g-dark shadow-sm">
                        @error('email')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-between space-x-2 mt-6">
                        <button type="submit" id="addPatientButton"
                                class="w-1/2 px-4 py-2 text-sm font-medium text-white bg-g-dark rounded-md hover:bg-[#296E5B]/90">
                            + Add Patient
                        </button>
                        <button type="button" onclick="closeModal('{{ $id }}')"
                                class="w-1/2 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        @endif

<script>
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
        let selectedDiseases = []; // Array to track selected disease IDs

        function updateHiddenInput() {
            // Update the hidden input with the array of disease IDs
            diseaseHiddenInput.value = selectedDiseases.join(',');
            // Create a new hidden input for each disease ID to submit as an array
            const existingInputs = document.querySelectorAll('input[name="disease_id[]"]');
            existingInputs.forEach(input => input.remove()); // Remove old hidden inputs
            selectedDiseases.forEach(diseaseId => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'disease_id[]';
                input.value = diseaseId;
                diseaseTagsContainer.appendChild(input);
            });
            // Toggle the required attribute on the select based on selected diseases
            diseaseSelect.required = selectedDiseases.length === 0;
        }

        diseaseSelect.addEventListener('change', function() {
            const selectedValue = diseaseSelect.value;
            const selectedText = diseaseSelect.options[diseaseSelect.selectedIndex].text;

            if (selectedValue && selectedText !== 'Select patient’s disease...' && !selectedDiseases.includes(selectedValue)) {
                // Add disease to the array
                selectedDiseases.push(selectedValue);

                // Create a tag
                const tag = document.createElement('span');
                tag.className = 'bg-gray-200 text-gray-700 text-sm px-2 py-1 rounded flex items-center';
                tag.textContent = selectedText;

                const removeBtn = document.createElement('button');
                removeBtn.textContent = 'x';
                removeBtn.className = 'ml-2 text-gray-500 hover:text-gray-700';
                removeBtn.onclick = () => {
                    // Remove disease from the array
                    selectedDiseases = selectedDiseases.filter(id => id !== selectedValue);
                    tag.remove(); // Remove the tag
                    updateHiddenInput(); // Update the hidden input and required attribute
                };
                tag.appendChild(removeBtn);
                diseaseTagsContainer.appendChild(tag);

                // Reset the select
                diseaseSelect.value = '';

                // Update the hidden input and required attribute
                updateHiddenInput();
            }
        });

        // Optional: Reset tags and hidden input when modal is closed
        function resetForm(id) {
            const form = document.querySelector(`#${id} form`);
            form.reset();
            diseaseTagsContainer.innerHTML = '';
            selectedDiseases = [];
            updateHiddenInput(); // Reset hidden inputs and required attribute
        }

        // Call resetForm when modal is closed
        document.querySelectorAll('button[onclick^="closeModal"]').forEach(button => {
            button.addEventListener('click', () => resetForm('{{ $id }}'));
        });

        // Initialize the required attribute on page load
        updateHiddenInput();
    });
</script>
    </div>
</div>