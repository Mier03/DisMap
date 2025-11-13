@props([
    'value' => 0,
    'label' => '',
    'statCardType' => 'default', 
])

@php
    $typeClass = $statCardType === 'welcome' ? 'min-w-[280px]' : '';
@endphp


<div class="bg-white border border-b-4 border-[#2D6A4F] rounded-lg shadow-md p-5 w-full {{ $typeClass }}">
    <div class="flex items-center gap-4">
        {{-- Icon Slot --}}
        <div class="text-[#2D6A4F] shrink-0">
        {{ $icon ?? '' }}
        </div>

        {{-- Value and Label --}}
        <div class="text-left overflow-hidden">
            <p class="text-3xl lg:text-4xl font-bold text-g-dark truncate">{{ $value }}</p>
            <p class="text-xs lg:text-sm text-gray-600 truncate">{{ $label }}</p>
        </div>
    </div>
</div>