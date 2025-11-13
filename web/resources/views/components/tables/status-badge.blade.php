@props(['status'])

@php
    $colors = [
        'Active' => 'bg-yellow-100 text-yellow-800',
        'Pending' => 'bg-yellow-100 text-yellow-800',
        'Rejected' => 'bg-red-100 text-red-800',
        'Recovered' => 'bg-blue-100 text-blue-800',
        'default' => 'bg-gray-100 text-gray-800',
    ];
    $colorClass = $colors[$status] ?? $colors['default'];
@endphp

<span class="px-2 py-1 text-xs font-medium rounded-full {{ $colorClass }}">
    {{ $status }}
</span>
