<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-[168px] h-[40px] bg-g-dark text-white text-[14px] font-semibold rounded hover:bg-[#296E5B]/90 transition']) }}>
    {{ $slot }}
</button>