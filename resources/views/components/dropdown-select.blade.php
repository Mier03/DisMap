@props(['disabled' => false])

<select 
    {{ $disabled ? 'disabled' : '' }} 
    {{ $attributes->merge([
        'class' => 'w-full h-[44px] border border-g-dark rounded px-3 text-sm text-g-dark bg-[#F2F2F2] focus:outline-none focus:ring-2 focus:ring-g-dark/50'
    ]) }}
>
    {{ $slot }}
</select>