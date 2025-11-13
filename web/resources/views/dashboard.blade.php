<x-app-layout>
    <div class="bg-[#E8FCEB] flex min-h-screen w-full">
        {{-- Sidebar --}}
        @include('layouts.sidebar')

        {{-- Main Content --}}
        <div class="ml-64 flex-1 py-8 px-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden">
                    <div class="p-6 bg-inherit text-gray-900">

                        {{-- Header --}}
                        <x-page-header title="Dashboard" />

                        {{-- Filters + Search --}}
                        <div class="mb-4">
                            <div class="flex items-start space-x-4">
                                {{-- Filter Button --}}
                                <div class="flex-shrink-0">
                                    <button
                                        id="openFilterModal"
                                        class="group flex items-center h-[42px] rounded-lg px-4 transition-all duration-300 ease-out bg-white text-g-dark border border-g-dark hover:shadow-md hover:scale-[1.02] active:scale-[0.98]">
                                        <div class="flex items-center">
                                           <div class="transition-transform duration-300 group-hover:scale-110 group-hover:rotate-12 mr-2 [&_svg]:text-g-dark [&_svg]:fill-g-dark">
                                            <x-gmdi-filter-alt-o class="w-4 h-4" />
                                        </div>
                                            <span class="text-sm font-medium transition-all duration-300 group-hover:font-semibold">Filters</span>
                                        </div>
                                    </button>
                                </div>

                               
                                {{-- Search Bar --}}
                                <div class="flex-1 max-w-[1050px]">
                                    <form method="GET" action="{{ route('dashboard') }}">
                                        <x-search-bar 
                                            placeholder="Search diseases, locations..."
                                            value="{{ request('term') }}"
                                            id="search-input"
                                            name="term"
                                        />
                                    </form>
                                </div>
                            </div>

                            <div id="activeFiltersContainer" class="mt-3 flex flex-wrap items-center gap-2">
                                <span class="text-[#19664E] font-medium js-active-filter-span">Active Filters:</span>

                                <div class="server-filters flex flex-wrap items-center gap-2">
                                    {!! $activeFilters !!}
                                </div>
                                {{-- JS-added filters will appear here --}}
                            </div>

                            <div class="mt-3 flex items-center space-x-3">
                                <small>Total Results: {{ $filterResults->sum('total_patient_count') }}</small>
                            </div>
                        </div>

                        {{-- Map Section --}}
                        <div class="mt-2">
                            <div class="rounded-lg overflow-hidden bg-white shadow-sm">
                                <div id="heatmap" class="h-[420px] w-full"></div>
                            </div>

                            {{-- Legend centered --}}
                            <div class="flex justify-center text-sm text-gray-700 mt-4 gap-8">
                                <span class="text-[#4CAF50]">Low (0 - 100)</span>
                                <span class="text-[#FFC107]">Medium (101 - 250)</span>
                                <span class="text-[#FF9800]">High (251 - 400)</span>
                                <span class="text-[#F44336]">Critical (500+)</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter Modal Component (Assumed to contain the filter logic) --}}
    <x-modals.filterModal :barangays="$activeBarangays" :diseases="$activeDiseases" :action="route('dashboard')"/>
    
    {{-- Include Leaflet JS and Heatmap Plugin --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet.heat/dist/leaflet-heat.js"></script>

    <script>
        // Pass PHP data to JavaScript
        const filterResults = @json($filterResults);
    </script>

    @push('scripts')
        @vite('resources/js/heatmap.js')
    @endpush
</x-app-layout>