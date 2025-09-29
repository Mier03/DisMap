@props(['hospital'])

<div class="bg-white rounded-lg shadow border p-4 flex-shrink-0 w-64 border-l-4 border-[#296E5B] hover:translate-y-[-2px] hover:shadow-lg transition-all">
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
        <button class="text-blue-500 hover:text-blue-700 p-2 hover:scale-105 transition">
            <i class="fas fa-edit"></i>
        </button>
        <button class="text-red-500 hover:text-red-700 p-2 hover:scale-105 transition">
            <i class="fas fa-trash"></i>
        </button>
    </div>
</div>
