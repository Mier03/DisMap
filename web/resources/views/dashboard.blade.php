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
                            <div class="flex items-center space-x-4">
                                <button
                                    id="openFilterModal"
                                    class="flex items-center space-x-2 bg-white border border-[#D0EEDF] text-[#19664E] px-3 py-2 rounded-lg shadow-sm hover:bg-[#19664E] hover:text-white transition">
                                    <x-gmdi-filter-alt-o class="w-4 h-4" />
                                    <span class="text-sm">Filters</span>
                                </button>

                                <div class="relative flex-1 max-w-[1050px]">
                                    <form method="GET" action="{{ route('dashboard') }}">
                                        <input type="text" name="term" placeholder="Search diseases, locations..."
                                            value="{{ request('term') }}"
                                            class="w-full rounded-lg px-4 py-2 focus:outline-none focus:ring-1 focus:ring-[#19664E]" style="border: 1px solid #E9FBF0;">
                                    </form>
                                </div>
                            </div>

                          <div id="activeFiltersContainer" class="mt-3 flex flex-wrap items-center gap-2">
                                <span class="text-[#19664E] font-medium">Active Filters:</span>

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