@props([
    'id' => 'modalId',
    'title' => 'Confirmation',
    'message' => 'Are you sure?',
    'confirmText' => 'Confirm',
    'cancelText' => 'Cancel',
    'action' => null,
    'method' => 'POST',
])

<div id="{{ $id }}" 
     class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md text-center">
        <h2 class="text-xl font-bold text-g-dark mb-2">{{ $title }}</h2>
        <p class="text-g-dark mb-6">{{ $message }}</p>

        <div class="flex justify-center space-x-3">
            @if ($action)
                <form method="POST" action="{{ $action }}">
                    @csrf
                    @if (strtoupper($method) !== 'POST')
                        @method($method)
                    @endif
                    {{-- Optional form fields slot --}}
                    {{ $formFields ?? '' }}
                    <button type="submit"
                        class="bg-g-dark text-white px-4 py-2 rounded-md font-semibold hover:bg-g-dark/90">
                        {{ $confirmText }}
                    </button>
                </form>
            @else
                <button type="button"
                        class="bg-g-dark text-white px-4 py-2 rounded-md font-semibold hover:bg-g-dark/90">
                    {{ $confirmText }}
                </button>
            @endif

            <button type="button" onclick="closeModal('{{ $id }}')"
                    class="border border-g-dark text-g-dark px-4 py-2 rounded-md font-semibold hover:bg-gray-100">
                {{ $cancelText }}
            </button>
        </div>
    </div>
</div>

<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }
    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }
</script>

