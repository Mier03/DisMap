@props(['title', 'subtitle' => null, 'buttonText' => null, 'buttonClick' => null])

<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-5xl font-bold text-g-dark">{{ $title }}</h2>
        <p class="text-g-dark mt-1">{{ $subtitle }}</p>
    </div>
    <div>
    
    @if($buttonText)
        <div>
            <button 
                @if($buttonClick) onclick="{{ $buttonClick }}" @endif
                class="border border-g-dark text-g-dark bg-white px-4 py-2 rounded-lg hover:bg-[#F2F2F2]/90 transition shrink-0">
                {{ $buttonText }}
            </button>
        </div>
    @endif
    </div>
</div>