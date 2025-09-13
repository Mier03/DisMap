@props([
    'id' => 'modalId',
    'title' => 'Add Patient',
    'message' => 'Record a new patient case',
    'fullNameLabel' => 'Full Name',
    'fullNamePlaceholder' => 'Enter patient full name...',
    'ageLabel' => 'Age',
    'agePlaceholder' => 'Enter patient age...',
    'barangayLabel' => 'Barangay',
    'barangayPlaceholder' => 'Select patient\'s barangay',
    'diseaseLabel' => 'Disease',
    'diseasePlaceholder' => 'Select patient\'s disease...',
    'usernameLabel' => 'Username',
    'usernamePlaceholder' => 'Automatic based on name, if username exists, Dr. will have the right to change it',
    'emailLabel' => 'Email',
    'emailPlaceholder' => 'Enter valid email address...',
    'confirmButtonText' => '+ Add Patient',
    'cancelButtonText' => 'Cancel',
    'buttonId' => 'submitButton',
    'action' => null,
    'method' => 'POST',
])

<div id="{{ $id }}" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50" x-data="{ open: false }">
    <div class="bg-white rounded-lg shadow-lg p-6 w-[500px] h-[661px] text-left relative">
        <h2 class="text-5xl font-semibold text-g-dark absolute top-[60px] left-[42px]">{{ $title }}</h2>
        <p class="text-g-dark text-base absolute top-[120px] left-[42px]">{{ $message }}</p>

        <div class="absolute top-[160px] left-[42px]">
            <label class="text-g-dark font-medium text-base block">{{ $fullNameLabel }}</label>
            <input type="text" placeholder="{{ $fullNamePlaceholder }}" class="w-[415px] h-[31px] border border-g-dark rounded-lg p-2"
            style="font-size: 10pt;">
        </div>
        <div class="absolute top-[225px] left-[42px]">
            <label class="text-g-dark font-medium text-base block">{{ $ageLabel }}</label>
            <input type="number" placeholder="{{ $agePlaceholder }}" class="w-[415px] h-[31px] border border-g-dark rounded-lg p-2"
            style="font-size: 10pt;">
        </div>
        <div class="absolute top-[290px] left-[42px]">
            <label class="text-g-dark font-medium text-base block">{{ $barangayLabel }}</label>
            <select class="w-[415px] h-[31px] border border-g-dark rounded-lg p-2"
            style="font-size: 10pt;">>
                <option value="" disabled selected>{{ $barangayPlaceholder }}</option>
                <option value="Labangon">Labangon</option>
                <option value="Lahug">Lahug</option>
            </select>
        </div>
        <div class="absolute top-[355px] left-[42px]">
            <label class="text-g-dark font-medium text-base block">{{ $diseaseLabel }}</label>
            <select class="w-[415px] h-[31px] border border-g-dark rounded-lg p-2"
            style="font-size: 10pt;">>
                <option value="" disabled selected>{{ $diseasePlaceholder }}</option>
                <option value="Dengue">Dengue</option>
                <option value="Malaria">Malaria</option>
            </select>
        </div>
        <div class="absolute top-[420px] left-[42px]">
            <label class="text-g-dark font-medium text-base block">{{ $usernameLabel }}</label>
            <input type="text" placeholder="{{ $usernamePlaceholder }}" class="w-[415px] h-[31px] border border-g-dark rounded-lg p-2" readonly
            style="font-size: 10pt;">
        </div>
        <div class="absolute top-[485px] left-[42px]">
            <label class="text-g-dark font-medium text-base block">{{ $emailLabel }}</label>
            <input type="email" placeholder="{{ $emailPlaceholder }}" class="w-[415px] h-[31px] border border-g-dark rounded-lg p-2"
            style="font-size: 10pt;">
        </div>
        <button 
            type="button" 
            id="{{ $buttonId }}"
            onclick="closeModal('{{ $id }}')"
            class="bg-g-dark text-white font-semibold text-base w-[415px] h-[31px] rounded-lg absolute top-[550px] left-[42px]">
            {{ $confirmButtonText }}
        </button>
        <button 
            type="button" 
            onclick="closeModal('{{ $id }}')"
            class="border border-g-dark text-g-dark font-semibold text-base w-[415px] h-[31px] rounded-lg absolute top-[590px] left-[42px]">
            {{ $cancelButtonText }}
        </button>
    </div>
</div>

<script>
    function openModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.classList.remove('hidden');
        }
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.classList.add('hidden');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const modals = document.querySelectorAll('.fixed.bg-black.bg-opacity-50');
        modals.forEach(modal => {
            const modalContent = modal.querySelector('.bg-white');
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeModal(modal.id);
                }
            });
        });
    });
</script>