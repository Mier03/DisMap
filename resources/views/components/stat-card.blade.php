@props([
    'value' => 0, 
    'label' => '', 
])

<div class="p-4 bg-white border border-g-dark rounded-lg text-center">
    <p class="text-3xl font-bold text-g-dark">{{ $value }}</p>
    <p class="text-sm text-gray-600">{{ $label }}</p>
</div>
