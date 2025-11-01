@props(['modalId', 'icon' => null, 'title', 'description' => null, 'width' => 'w-[600px]', 'updateRoute' => null])

<div id="{{ $modalId }}" class="hidden fixed inset-0 flex bg-black bg-opacity-50 items-center justify-center z-50" data-update-route=" {{ $updateRoute ?? '' }} ">
    <div class="bg-white rounded-lg shadow-lg {{ $width }} p-8 text-left  overflow-y-auto max-h-[90vh]">
        <div class="px-4 py-4">
            <div class="flex items-center mb-2">
                <span class="material-icons text-g-dark fill-current">{{ $icon }}</span>
                <h2 class="text-3xl font-bold text-g-dark ml-3">{{ $title }}</h2>
            </div>
            <p class="text-g-dark text-base mb-6 ml-1">{{ $description }}</p>

            <div class="mt-6">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>  