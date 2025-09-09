@props(['disabled' => false])

<input 
    @disabled($disabled) 
    {{ $attributes->merge([
        'class' => ' text:bold text-xs w-96 h-8 bg-zinc-100 rounded-[5px] border-1 border-teal-700/60 focus:border-teal-800 focus:ring-teal-800'
    ]) }}
>