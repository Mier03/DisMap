@props([
    'id' => 'modalId',
    'title' => 'Modal Title',
    'message' => 'This is a generic modal.',
    'fields' => [], // New prop to define form fields
    'confirmButtonText' => 'Confirm',
    'cancelButtonText' => 'Cancel',
    'buttonId' => 'submitButton',
    'action' => null,
    'method' => 'POST',
])

<div id="{{ $id }}" class="hidden fixed inset-0 items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-[500px] text-left relative">
        <h2 class="text-3xl font-bold text-g-dark mt-8 ml-8">{{ $title }}</h2>
        <p class="text-g-dark text-base mt-2 ml-8">{{ $message }}</p>

        <div class="px-8 py-4">
            <form action="{{ $action }}" method="POST">
                @csrf
                @if($method !== 'POST')
                    @method($method)
                @endif
                
                @foreach($fields as $field)
                    <div class="mb-4">
                        <label for="{{ $field['name'] }}" class="block text-sm font-medium text-g-dark">{{ $field['label'] }}</label>
                        @if($field['type'] === 'select')
                            <select 
                                name="{{ $field['name'] }}" 
                                id="{{ $field['name'] }}" 
                                class="mt-1 block w-full rounded-md border-g-dark shadow-sm"
                                @if(isset($field['required']) && $field['required']) required @endif
                            >
                                <option value="" disabled selected>{{ $field['placeholder'] }}</option>
                                @foreach($field['options'] as $option)
                                    <option value="{{ $option['value'] }}" {{ (isset($field['value']) && $field['value'] == $option['value']) ? 'selected' : '' }}>{{ $option['label'] }}</option>
                                @endforeach
                            </select>
                        @else
                            <input 
                                type="{{ $field['type'] }}" 
                                name="{{ $field['name'] }}" 
                                id="{{ $field['name'] }}" 
                                class="mt-1 block w-full rounded-md border-g-dark shadow-sm" 
                                placeholder="{{ $field['placeholder'] }}"
                                @if(isset($field['readonly']) && $field['readonly']) readonly @endif
                                @if(isset($field['value'])) value="{{ $field['value'] }}" @endif
                                @if(isset($field['required']) && $field['required']) required @endif
                            >
                        @endif
                        @error($field['name'])
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                @endforeach
                
                <div class="flex justify-between space-x-2 mt-6">
                    <button type="submit" id="{{ $buttonId }}" class="w-1/2 px-4 py-2 text-sm font-medium text-white bg-g-dark rounded-md hover:bg-[#296E5B]/90">
                        {{ $confirmButtonText }}
                    </button>
                    <button type="button" onclick="closeModal('{{ $id }}')" class="w-1/2 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">
                        {{ $cancelButtonText }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

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
    });
</script>