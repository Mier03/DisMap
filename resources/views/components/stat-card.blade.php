@props([
    'value' => 0,
    'label' => '',
])

{{-- Set a 1px border on all sides, then a thicker 4px border on the bottom --}}
<div class="bg-white border border-b-4 border-[#2D6A4F] rounded-lg shadow-md flex items-center gap-5 p-5 w-full md:w-auto min-w-[280px]">
    {{-- Icon Slot --}}
    <div class="text-[#2D6A4F]">
        {{ $icon }}
    </div>

    {{-- Value and Label --}}
    <div class="text-left">
        <p class="text-4xl font-bold text-g-dark">{{ $value }}</p>
        <p class="text-sm text-gray-600">{{ $label }}</p>
    </div>
</div>