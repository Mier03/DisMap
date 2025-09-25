@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-[14px] font-semibold text-g-dark']) }}>
    {{ $value ?? $slot }}
</label>