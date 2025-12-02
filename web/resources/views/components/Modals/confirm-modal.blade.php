@props([
    'id',
    'title' => 'Confirm Action',
    'message' => 'Are you sure you want to proceed?',
    'confirmText' => 'Confirm',
    'cancelText' => 'Cancel',
    'confirmAction' => null,
])

<div id="{{ $id }}" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[9999]">
    <div class="bg-white rounded-lg shadow-lg w-[400px] p-6 text-center">
        <h2 class="text-g-dark font-bold text-2xl mb-4">{{ $title }}</h2>
        <p class="text-g-dark font-semibold text-xl mb-6">{{ $message }}</p>

        <div class="flex justify-center gap-4">
            <!-- Primary button: conditional onclick handled outside attribute -->
            @if($confirmAction)
                <button
                    type="button"
                    class="bg-[#296E5B] text-white font-semibold px-4 py-2 rounded-lg hover:bg-[#296E5B]/90 border border-g-dark"
                    onclick="{!! $confirmAction !!}; closeModal('{{ $id }}')"
                >
                    {{ $confirmText }}
                </button>
            @else
                <button
                    type="button"
                    class="bg-[#296E5B] text-white px-4 py-2 rounded-lg hover:bg-[#296E5B]/90 border border-g-dark"
                    onclick="closeModal('{{ $id }}')"
                >
                    {{ $confirmText }}
                </button>
            @endif

            <!-- Cancel button with border -->
            <button
                type="button"
                class="bg-white text-g-dark border border-gray-400 font-semibold px-4 py-2 rounded-lg hover:bg-gray-200"
                onclick="closeModal('{{ $id }}')"
            >
                {{ $cancelText }}
            </button>
        </div>
    </div>
</div>

<script>
function openModal(id) {
    document.getElementById(id)?.classList.remove('hidden');
}
function closeModal(id) {
    document.getElementById(id)?.classList.add('hidden');
}
</script>
