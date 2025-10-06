@props(['hospital', 'canRemove' => false])

<div class="bg-white rounded-lg shadow border p-4 flex-shrink-0 w-64 border-l-4 border-[#296E5B] hover:translate-y-[-2px] hover:shadow-lg transition-all relative">
    
    <div class="flex items-center gap-3 mb-3">
        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
            <i class="fas fa-hospital text-green-600"></i>
        </div>
        <div>
            <h5 class="font-semibold text-g-dark">{{ $hospital->name }}</h5>
        </div>
    </div>
    <p class="text-sm text-gray-500 mb-4">{{ $hospital->address ?? 'No address provided' }}</p>

    <div class="flex gap-2 justify-end">
     
        
      @if ($canRemove)
        <button type="button"
                onclick="openModal('removeModal-{{ $hospital->id }}')" 
                title="Remove Hospital"
                class="absolute top-3 right-3 text-gray-400 hover:text-red-600 transition">
            ✕
        </button>
        
        @endif
        
        {{-- Placeholder for no-action button --}}
        @if (!$canRemove)
            <button class="text-red-500 hover:text-red-700 p-2 " title="Trash (No action)">
                <i class="fas fa-trash text-red-500 hover:text-red-700"></i>
            </button>
        @endif
    </div>
</div>