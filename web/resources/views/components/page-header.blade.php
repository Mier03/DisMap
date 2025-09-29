@props(['title', 'subtitle', 'buttonText' => null])

<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-5xl font-bold text-g-dark">{{ $title }}</h2>
        <p class="text-g-dark mt-1">{{ $subtitle }}</p>
    </div>
    <div>
    
    @if($buttonText)
        <div>
            <button class="bg-gray-100 border border-g-dark text-g-dark font-bold px-4 py-2 rounded-lg">
                {{ $buttonText }}
            </button>
        </div>
    @endif
    </div>
</div>