@props(['id'])

{{-- Wrapper that holds ALL modals --}}
<div>
    {{-- =========================
        Add Patient Modal
    ========================== --}}
    <div id="addPatientModal" class="hidden fixed inset-0 items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-[500px] text-left relative">
            <h2 class="text-3xl font-bold text-g-dark mt-8 ml-8">Add Patient</h2>
            <p class="text-g-dark text-base mt-2 ml-8">Record a new patient case</p>

            <div class="px-8 py-4">
                <form action="{{ route('admin.patients.store') }}" method="POST">
                    @csrf

                    {{-- Full Name --}}
                    <div class="mb-4">
                        <label for="fullName" class="block text-sm font-medium text-g-dark">Full Name</label>
                        <input type="text" name="fullName" id="fullName" placeholder="Enter patient full name..." required
                               class="mt-1 block w-full rounded-md border-g-dark shadow-sm">
                        @error('fullName')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Birthdate --}}
                    <div class="mb-4">
                        <label for="birthdate" class="block text-sm font-medium text-g-dark">Birthdate</label>
                        <input type="date" name="birthdate" id="birthdate" required
                               class="mt-1 block w-full rounded-md border-g-dark shadow-sm">
                        @error('birthdate')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Barangay --}}
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

                    {{-- Diseases --}}
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

                    {{-- Remarks --}}
                    <div class="mb-4">
                        <label for="remarks" class="block text-sm font-medium text-g-dark">Remarks</label>
                        <input type="text" name="remarks" id="remarks" placeholder="Enter any relevant remarks..."
                               class="mt-1 block w-full rounded-md border-g-dark shadow-sm">
                        @error('remarks')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Hospital --}}
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

                    {{-- Email --}}
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
                        <button type="button" onclick="closeModal('addPatientModal')"
                                class="w-1/2 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- =========================
        Example of Another Modal
        Just copy structure & change the id
    ========================== --}}
    <div id="editPatientModal" class="hidden fixed inset-0 items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-[500px]">
            <h2 class="text-2xl font-bold text-g-dark">Edit Patient</h2>
            <p class="text-g-dark text-base">Edit patient details here...</p>
            {{-- Your edit form --}}
            <button onclick="closeModal('editPatientModal')" class="mt-4 bg-gray-300 px-3 py-1 rounded">Close</button>
        </div>
    </div>
    {{-- =========================
        Export Modal
    ========================== --}}
    <div id="exportModal" class="hidden fixed inset-0 items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white rounded-lg shadow-lg w-[500px] p-8 text-left relative">

            {{-- Header --}}
            <div class="flex items-center mb-2">
                {{-- Logo --}}
                <svg class="w-[32px] h-[32px] text-g-dark fill-current"
                    xmlns="resources/svg/filter.svg" viewBox="0 0 24 24">
                    <path d="M3 4h18l-7 9v7l-4-2v-5z"/>
                </svg>
                <h2 class="ml-3 text-[28px] font-bold text-g-dark">Export</h2>
            </div>
            <p class="text-g-dark text-[16px] mb-6 ml-1">Filter and export data</p>

            {{-- Date Range --}}
            <div class="px-[10px]">
                <div class="flex justify-between items-center mb-2">
                    <label class="text-[14px] font-semibold text-g-dark">Date Range</label>
                    <button type="button" onclick="resetDateRange()" class="text-g-dark font-semibold text-sm">
                        Reset
                    </button>
                </div>
                <div class="flex gap-3 mb-3">
                    <input type="date" id="fromDate" name="fromDate"
                        class="border border-g-dark rounded w-full h-[40px] text-sm px-3 text-g-dark">
                    <input type="date" id="toDate" name="toDate"
                        class="border border-g-dark rounded w-full h-[40px] text-sm px-3 text-g-dark">
                </div>

                {{-- Date Quick Filters --}}
                <div class="flex gap-3">
                    <button type="button"
                            onclick="setDateFilter('today')"
                            class="w-full h-[36px] border border-g-dark rounded text-sm font-semibold text-g-dark hover:bg-g-dark hover:text-white transition">
                        Today
                    </button>
                    <button type="button"
                            onclick="setDateFilter('week')"
                            class="w-full h-[36px] border border-g-dark rounded text-sm font-semibold text-g-dark hover:bg-g-dark hover:text-white transition">
                        This Week
                    </button>
                    <button type="button"
                            onclick="setDateFilter('month')"
                            class="w-full h-[36px] border border-g-dark rounded text-sm font-semibold text-g-dark hover:bg-g-dark hover:text-white transition">
                        This Month
                    </button>
                </div>
            </div>

            {{-- Hospital --}}
            <div class="mt-6 px-[10px]">
                <div class="flex justify-between items-center mb-2">
                    <label class="text-[14px] font-semibold text-g-dark">Hospital</label>
                    <button type="button" onclick="resetHospital()" class="text-g-dark font-semibold text-sm">Reset</button>
                </div>
            <select id="export_hospital_id" name="hospital_id"
                    class="w-full h-[40px] border border-g-dark rounded px-3 text-sm text-g-dark">
                <option value="" selected>Select hospital...</option>
                @foreach($hospitals as $hospital)
                    <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
                @endforeach
            </select>
            </div>

            {{-- Disease --}}
            <div class="mt-6 px-[10px]">
                <div class="flex justify-between items-center mb-2">
                    <label class="text-[14px] font-semibold text-g-dark">Disease Type</label>
                    <button type="button" onclick="resetDisease()" class="text-g-dark font-semibold text-sm">Reset</button>
                </div>
                <select id="export_disease_id" name="disease_id"
                        class="w-full h-[40px] border border-g-dark rounded px-3 text-sm text-g-dark">
                    <option value="" selected>Select disease...</option>
                    @foreach($diseases as $disease)
                        <option value="{{ $disease->id }}">{{ $disease->specification }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Buttons --}}
            <div class="flex justify-center gap-4 mt-10">
                <button type="button"
                        class="w-[168px] h-[40px] bg-g-dark text-white text-[14px] font-semibold rounded hover:opacity-90 transition">
                    Export PDF
                </button>
                <button type="button" onclick="closeModal('exportModal')"
                        class="w-[168px] h-[40px] bg-[#F2F2F2] text-g-dark text-[14px] font-semibold rounded hover:bg-gray-200 transition">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ========== SCRIPTS ========== --}}
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
        let selectedDiseases = [];

        function updateHiddenInput() {
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

        if (diseaseSelect) {
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
                diseaseTagsContainer.innerHTML = '';
                selectedDiseases = [];
                updateHiddenInput();
            }
        }

        document.querySelectorAll('button[onclick^="closeModal"]').forEach(button => {
            button.addEventListener('click', () => resetForm('addPatientModal'));
        });

        updateHiddenInput();
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

</script>
