@props([
    'message' => 'Operation completed.',
    'type' => 'success', 
])

@php
    $iconPath = match($type) {
        'success' => asset('images/icons/check.svg'),
        'error' => asset('images/icons/wrong.svg'),
        'warning' => asset('images/icons/warning.svg'),
        'info' => asset('images/icons/info.svg'),
        default => asset('images/icons/check.svg'),
    };

    $bgColor = match($type) {
        'success' => 'bg-green-50 border-green-500 text-green-700',
        'error' => 'bg-red-50 border-red-500 text-red-700',
        'warning' => 'bg-yellow-50 border-yellow-500 text-yellow-700',
        'info' => 'bg-blue-50 border-blue-500 text-blue-700',
        default => 'bg-gray-50 border-gray-400 text-gray-800',
    };
@endphp

<div 
    x-data="{ show: true }" 
    x-init="setTimeout(() => show = false, 3000)" 
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-x-10"
    x-transition:enter-end="opacity-100 translate-x-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-x-0"
    x-transition:leave-end="opacity-0 translate-x-10"
    class="fixed top-6 left-1/2 -translate-x-1/2 z-[9999]"
>
    <div class="flex items-center gap-3 p-4 rounded-xl shadow-lg border-l-4 {{ $bgColor }} w-fit max-w-sm">
        {{-- Image/Icon --}}
        <img src="{{ $iconPath }}" alt="{{ $type }} icon" class="w-6 h-6 flex-shrink-0">

        {{-- Message and Type --}}
        <div class="flex flex-col leading-tight">
            <span class="font-semibold">{{ ucfirst($type) }}</span>
            <span class="text-sm">{{ $message }}</span>
        </div>

        {{-- Close Button --}}
        <button @click="show = false" class="ml-3 text-gray-500 hover:text-gray-700 text-lg leading-none">×</button>
    </div>
</div>
