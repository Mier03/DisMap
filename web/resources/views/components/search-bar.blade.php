@props(['placeholder' => 'Search...', 'value' => '', 'id' => 'search-input', 'name' => 'q'])

<div class="flex items-center mb-4">
    <span class="material-icons -mr-8 z-0 pl-3">search</span>
    <input type="text"
           id="{{ $id }}"
           name="{{ $name }}"
           value="{{ $value }}"
           placeholder="{{ $placeholder }}"
           class="w-full py-2 pl-10 pr-4 border border-g-dark rounded-lg focus:outline-none focus:ring-1 focus:ring-[#296E5B]">
</div>
