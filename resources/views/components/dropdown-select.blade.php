@props(['disabled' => false])

<select 
    {{ $disabled ? 'disabled' : '' }} 
    {{ $attributes->merge([
        'class' => 'text-bold w-96 h-8 bg-zinc-100 rounded-[5px] border border-teal-700/60 focus:border-teal-800 focus:ring-teal-800 text-xs'
    ]) }}
>
    {{ $slot }}
</select>