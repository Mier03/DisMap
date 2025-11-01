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
                                    <input type="text" placeholder="Search diseases, locations..."
                                        class="w-full rounded-lg px-4 py-2 focus:outline-none focus:ring-1 focus:ring-[#19664E]" style="border: 1px solid #E9FBF0;">
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
                                <small>Total Results: {{ $filterResults->sum('patient_count') }}</small>
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
    <x-modals.filterModal :barangays="$activeBarangays" :diseases="$activeDiseases"/>
    
    {{-- Include Leaflet JS and Heatmap Plugin --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet.heat/dist/leaflet-heat.js"></script>

<script>
    // 1. Global variables to hold the map, heat layer, and original data
    let map;
    let heatLayer;
    
    // IMPORTANT: To load initial heatmap data, you must pass the aggregated 
    // data from your controller's index method into $aggregatedHeatmapData
    // and use that here. Assuming you pass $aggregatedHeatmapData from controller:
    // let allBarangayData = @json($aggregatedHeatmapData ?? []);
    // For now, it will likely be empty if $activeBis just a list of barangays
    const allBarangayData = @json($filterResults);

    // Convert your initial data into the required heatmap format: [lat, lng, intensity]
    function toHeatmapFormat(data) {
        // We explicitly parse coordinates as floats to ensure Leaflet.Heat works correctly
        return data.map(b => {
            const lat = parseFloat(b.latitude);
            const lng = parseFloat(b.longitude);
            const count = parseInt(b.patient_count) || 1;

            // Skip records where coordinates are invalid (NaN) or missing
            if (isNaN(lat) || isNaN(lng)) {
                console.warn('Skipping record due to invalid coordinates:', b);
                return null; 
            }

            return [
                lat,
                lng,
                count
            ];
        }).filter(point => point !== null); // Filter out any invalid points
    }

    document.addEventListener("DOMContentLoaded", () => {
        // --- Initialize map centered on Cebu City ---
        map = L.map('heatmap').setView([10.3157, 123.8854], 12);

        // --- Add OpenStreetMap tiles ---
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
            maxZoom: 18,
        }).addTo(map);

        let heatData = toHeatmapFormat(allBarangayData);

        // --- Initialize heatmap layer with ALL initial data ---
        heatLayer = L.heatLayer(heatData, {
            radius: 25,
            blur: 15,
            maxZoom: 17,
            gradient: { 0.0: '#4CAF50', 0.2: '#FFC107', 0.4: '#FF9800', 1.0: '#F44336' }
        }).addTo(map);
                
        // --- Add small red circle markers for visibility ---
        allBarangayData.forEach(b => {
            const wewewe = L.circleMarker([b.latitude, b.longitude], {
                radius: 5,          // circle size
                color: 'red',       // border color
                fillColor: 'red',   // fill color
                fillOpacity: 0.6,   // slightly transparent
                weight: 1
            }).addTo(map);

            wewewe.bindPopup(` 
                <div style="font-size:14px; line-height:1.4;">
                    <b>📍 ${b.name}</b><br>
                    👥<b>${b.patient_count}</b>
                </div>
            `);
        });

        // --- Auto zoom to fit all points ---
        map.fitBounds(L.latLngBounds(heatData));

        // --- 🔹 Listener for the data update event (from filter modal) ---
        window.addEventListener('heatmapDataUpdated', function(event) {
            const newData = event.detail;
            console.log("Heatmap updated with data:", newData);

            if (!heatLayer) return;
            
            const heatData = toHeatmapFormat(newData);

            // Clear and update heatmap layer
            heatLayer.setLatLngs(heatData);

            // Optional: recenter the map around data if needed
            if (heatData.length > 0) {
                // Get the first point's coordinates (which are guaranteed to be numbers here)
                const firstPoint = heatData[0];
                const lat = firstPoint[0];
                const lng = firstPoint[1];
                
                // Set the view
                map.setView([lat, lng], 14); // Increased zoom level to 14 for better visibility
            } else {
                // If data is empty, recenter to the default view
                map.setView([10.3157, 123.8854], 12);
            }
        });
    });
</script>
</x-app-layout>