@props(['title', 'icon', 'items'])

<div class="bg-white border border-g-dark rounded-lg p-4 shadow-md transition duration-300 hover:shadow-xl">
    <div class="flex items-center mb-4 pb-2 border-b border-g-light/50">
        <span class="material-icons text-g-dark mr-2 text-xl">{{ $icon }}</span>
        <h3 class="text-lg font-semibold text-g-dark">{{ $title }}</h3>
    </div>

    <!-- Items -->
    <div class="space-y-1">
        @foreach ($items as $item)
            <div class="flex justify-between items-start py-2 @if(!$loop->last) border-b border-g-light/50 @endif">
                <span class="text-sm font-medium text-gray-600 mr-4">{{ $item['label'] }}</span>
                @isset($item['badge'])
                    <span class="px-3 py-1 rounded-full text-xs font-medium {{ $item['badge']['class'] ?? '' }}">
                        {{ $item['badge']['text'] ?? 'N/A' }}
                    </span>
                @else
                    <span class="text-sm text-gray-800 text-right break-words">{{ $item['value'] ?? 'N/A' }}</span>
                @endisset
            </div>
        @endforeach
    </div>

</div>