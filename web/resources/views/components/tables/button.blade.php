@props([
    'label' => 'Button',
    'onclick' => null,
])

<button 
    @if($onclick) onclick="{{ $onclick }}" @endif
    class="bg-g-dark text-white font-medium px-3 py-1 rounded shadow-sm hover:bg-g-dark/80 transition"
>
    {{ $label }}
</button>
