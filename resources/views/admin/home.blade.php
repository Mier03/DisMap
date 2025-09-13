<x-app-layout>
    <div class="bg-g-bg flex min-h-screen w-full">
        {{-- Sidebar --}}
        @include('layouts.sidebar')

        {{-- Main Content --}}
        <div class="ml-64 flex-1 py-12 px-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden">
                    <div class="p-6 bg-inherit text-gray-900">

                        {{-- Header --}}
                        <div class="mb-6">
                            <h2 class="text-5xl font-bold text-g-dark">Dashboard</h2>
                        </div>

                        {{-- Filters + Search --}}
                        <div class="flex flex-col space-y-3 mb-4">
                            <div class="flex items-center space-x-2">
                                <button
                                    id="openFilterModal"
                                    class="flex items-center space-x-2 bg-white border border-g-dark text-g-dark px-3 py-2 rounded-lg shadow hover:bg-g-dark hover:text-white transition">
                                    <x-gmdi-filter-alt-o class="w-5 h-5" />
                                    <span class="font-medium">Filters</span>
                                </button>
                            </div>

                            {{-- Search Bar --}}
                            <div>
                                <input type="text" placeholder="Search diseases, locations..."
                                    class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-1 focus:ring-[#296E5B]">
                            </div>

                            {{-- Dynamic Active Filters (only this one now) --}}
                            <div id="activeFiltersContainer" class="flex items-center space-x-2">
                                <span class="text-g-dark font-medium">Active Filters:</span>
                                <span class="inline-flex items-center bg-green-50 text-green-700 border border-green-200 px-3 py-1 rounded-full text-sm mr-2">
                                    Lahug
                                    <button class="ml-1 text-green-500 hover:text-green-700 focus:outline-none">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </span>
                            </div>
                        </div>

                        {{-- Map Section --}}
                        <div class="mt-4">
                            <div class="border border-gray-300 rounded-lg overflow-hidden">
                                {{-- Replace with actual Map Embed --}}
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3931.0165935698957!2d123.88543621535366!3d10.315699992630037!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a9995be0b9b20f%3A0x6f59709d20b9e7b3!2sCebu%20City!5e0!3m2!1sen!2sph!4v1631181589709!5m2!1sen!2sph"
                                    width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                            </div>

                            {{-- Legend --}}
                            <div class="flex justify-between text-sm text-gray-700 mt-2">
                                <span class="text-[#4CAF50]">Low (0 - 100)</span>
                                <span class="text-[#FFC107]">Medium (101 - 250)</span>
                                <span class="text-[#FF9800]">High (251 - 400)</span>
                                <span class="text-[#F44336]">Critical (500+)</span>
                            </div>
                        </div>

                        @include('components.filter-modal')

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>