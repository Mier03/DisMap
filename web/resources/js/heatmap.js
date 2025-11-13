document.addEventListener('DOMContentLoaded', function() {
    // 1. Global variables to hold the map, heat layer, and original data
    let map;
    let heatLayer;
    
    // IMPORTANT: To load initial heatmap data, you must pass the aggregated 
    // data from your controller's index method into $aggregatedHeatmapData
    // and use that here. Assuming you pass $aggregatedHeatmapData from controller:
    // let allBarangayData = @json($aggregatedHeatmapData ?? []);
    // For now, it will likely be empty if $activeBis just a list of barangays
    const allBarangayData = filterResults;

    // Convert your initial data into the required heatmap format: [lat, lng, intensity]
    function toHeatmapFormat(data) {
        // We explicitly parse coordinates as floats to ensure Leaflet.Heat works correctly
        return Object.entries(data).map(([index, b]) => {
            const lat = parseFloat(b.latitude);
            const lng = parseFloat(b.longitude);
            const count = parseInt(b.total_patient_count) || 1;

            
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

    
    // --- Initialize map centered on Cebu City ---
    map = L.map('heatmap').setView([10.3157, 123.8854], 12);

    // --- Add OpenStreetMap tiles ---
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
        maxZoom: 18,
    }).addTo(map);

    let heatData = toHeatmapFormat(allBarangayData);

    // --- Initialize heatmap layer with ALL initial data ---
    // heatLayer = L.heatLayer(heatData, {
    //     radius: 25,
    //     blur: 15,
    //     maxZoom: 17,
    //     gradient: { 0.0: '#4CAF50', 0.2: '#FFC107', 0.4: '#FF9800', 1.0: '#F44336' }
    // }).addTo(map);

     // --- Helper: determine circle color based on patient count ---
    // function getMarkerColor(count) {
    //     if (count <= 100) return '#4CAF50'; // Low
    //     if (count <= 250) return '#FFC107'; // Medium
    //     if (count <= 400) return '#FF9800'; // High
    //     return '#F44336'; // Critical (500+)
    // }
            
    // --- Add small red circle markers for visibility ---
    Object.entries(allBarangayData).forEach(([index, b]) => {
        const count = parseInt(b.total_patient_count) || 0;
        
        // Choose color based on absolute count
            let color = '#4CAF50'; // default green
            if (count > 400) color = '#F44336'; // red
            else if (count > 250) color = '#FF9800'; // orange
            else if (count > 100) color = '#FFC107'; // yellow

        const shadow = L.circle([b.latitude, b.longitude], {
            radius: 100,          // slightly bigger than main circle
            color: 'none',        // no border
            fillColor: color,     // same color
            fillOpacity: 0.50,    // very soft transparency
            interactive: false    // shadow won't block clicks
        }).addTo(map);

        const wewewe = L.circleMarker([b.latitude, b.longitude], {
            radius: 5,          // circle size
            color: color,       // border color
            fillColor: color,   // fill color
            fillOpacity: 1.0,   // slightly transparent
            weight: 1
        }).addTo(map);

        let $diseaseHtml = `<div style="font-size:14px; line-height:1.4;">
                <b>📍${b.name}</b><br>
                `;

        b.diseases.forEach(d => {
            $diseaseHtml += `<small class="text-green-700">- ${d.name}(👥${d.patient_count})</small><br/>`;
        });

        $diseaseHtml += `</div>`;
            
        wewewe.bindPopup($diseaseHtml);
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