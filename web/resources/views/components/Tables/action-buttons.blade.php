@props(['id'])

<div class="flex space-x-2">
    <!-- Approve Button -->
    <button type="button"
        onclick="openModal('approveModal-{{ $id }}')"
        class="px-3 py-1 text-sm bg-g-dark text-white rounded hover:bg-g-dark/80 transition">
        ✓
    </button>

    <!-- Reject Button -->
    <button type="button"
        onclick="openModal('rejectModal-{{ $id }}')"
        class="px-3 py-1 text-sm bg-r-dark text-white rounded hover:bg-red-600 transition">
        ✕
    </button>
</div>
