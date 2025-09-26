<!-- <button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-[168px] h-[40px] bg-g-dark text-white text-[14px] font-semibold rounded hover:bg-[#296E5B]/90 transition']) }}>
    {{ $slot }}
</button> -->

<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-g-dark border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#296E5B]/90 active:bg-[#296E5B] focus:outline-none focus:ring-2 focus:ring-[#296E5B] focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>

