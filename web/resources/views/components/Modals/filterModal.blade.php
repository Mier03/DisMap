@props([
    'id' => 'modalId',
    'title' => 'Modal',
    'message' => '',
    'confirmText' => 'Confirm',
    'cancelText' => 'Cancel',
    'action' => null,
    'method' => 'POST',
    'isConfirmation' => true,
    // Added for filter modal integration
    'barangays' => [],
    'diseases' => [],
])


{{-- Filter Modal merged in from resources/views/components/filter-modal.blade.php --}}
<div id="filterModal" 
class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden" 
     style="z-index: 9999">
    <form method="get" action="{{ $action ?? url()->current() }}">
        @csrf
         <div id="modalContent" class="bg-white rounded-lg p-6 w-[332px] max-h-[582px] overflow-y-auto z-index-100"></div>
    </form>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('filterModal');
    const modalContent = document.getElementById('modalContent');
    const openModalButton = document.getElementById('openFilterModal');
    const activeFiltersContainer = document.getElementById('activeFiltersContainer');

    const filterData = {
        'Disease Type': { 
            name: 'disease_type', 
            options: @json(collect($diseases)->map(fn($d) => ['value' => $d->id, 'text' => $d->specification])), 
            type: 'checkbox' ,
            limit : 5
        },
        'Barangays': { 
            name: 'barangays', 
            options: @json(collect($barangays)->map(fn($b) => ['value' => $b->id, 'text' => $b->name])), 
            type: 'checkbox', 
            limit: 5
        },  
    };

    let activeFiltersSet = new Set();
    // async function loadFilterData() {
    //     try {
    //         const response = await fetch('/heatmap');
    //         const { barangays, diseases } = await response.json();

    //         filterData['Disease Type'].options = diseases.map(d => ({
    //             value: d.id,
    //             text: d.specification
    //         }));

    //         filterData['Barangays'].options = barangays.map(b => ({
    //             value: b.id,
    //             text: b.name
    //         }));

    //         renderFilters();
    //     } catch (error) {
    //         console.error('Error loading filter data:', error);
    //     }
    // }

    function renderFilters() {
        let html = `
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold" style="color: #296E5B">Filters</h3>
                <div class="flex items-center space-x-4">
                    <button class="reset-filters text-gray-500 hover:text-gray-700" style="color: #296E5B">Reset</button>
                    <button class="close-modal text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="space-y-4">
        `;

        for (const [category, data] of Object.entries(filterData)) {
            const containerId = `options-${data.name}`;
            const limit = data.limit || Infinity;
            const inputType = data.type;
            const inputName = inputType === 'radio' ? data.name : `${data.name}[]`;

            html += `<div>
                <h4 class="text-sm font-medium mb-2" style="color: #296E5B">${category}</h4>
                <div id="${containerId}" data-limit="${limit}" class="space-y-1">
            `;

            data.options.forEach((option, idx) => {
                const shouldHide = idx >= limit;
                const isChecked = activeFiltersSet.has(String(option.value)) ? 'checked' : '';
                const extraClass = shouldHide ? 'extra-option hidden' : 'extra-option';
                html += `
                    <label class="flex items-start w-full gap-2 py-1 ${extraClass}">
                        <input type="${inputType}" name="${inputName}" value="${option.value}" 
                               class="filter-input h-4 w-4 flex-shrink-0 mt-1" ${isChecked}>
                        <span class="ml-2 text-gray-900" style="color: #296E5B">${option.text}</span>
                    </label>
                `;
            });

            if (data.options.length > limit && isFinite(limit)) {
                    html += `<button type="button" class="mt-2 text-sm text-left see-more-toggle text-g-dark hover:text-green-800" data-target="#${containerId}">See more</button>`;
            }

            html += `</div></div>`;
        }

        // ✅ Add Submit Button here
        html += `
            <div class="mt-6 flex justify-end">
                <button type="submit" id="applyFiltersButton" 
                    class="bg-g-dark text-white px-4 py-2 rounded-md hover:bg-g-dark/90">
                    Apply Filters
                </button>
            </div>
        `;

        html += `</div>`;
        modalContent.innerHTML = html;
    }

   function updateActiveFilters() {
    if (!activeFiltersContainer) return;

    // ✅ Grab reference to the existing server filters (from backend)
    const serverFiltersContainer = activeFiltersContainer.querySelector('.server-filters');

    // ✅ Keep the header label
    const label = activeFiltersContainer.querySelector('span.js-active-filter-span, span.text-g-dark');

    // ✅ Clear only the *dynamic* filters (not the backend ones)
    activeFiltersContainer.innerHTML = '';

    // Re-add header and backend filters
    if (label) activeFiltersContainer.appendChild(label);
    if (serverFiltersContainer) activeFiltersContainer.appendChild(serverFiltersContainer);

    // ✅ Continue with JS-added filters
    const sortedFilters = Array.from(activeFiltersSet).sort();
    sortedFilters.forEach(value => {
        let displayText = value;

        for (const categoryData of Object.values(filterData)) {
            const found = categoryData.options.find(opt => String(opt.value) === String(value));
            if (found) {
                displayText = found.text;
                break;
            }
        }

        const chip = document.createElement('span');
        chip.className =
            'inline-flex items-center bg-green-50 text-green-700 border border-green-200 px-3 py-1 rounded-full text-sm mr-2 hover:bg-green-100 transition';

        const labelSpan = document.createElement('span');
        labelSpan.textContent = displayText;
        chip.appendChild(labelSpan);

        const removeBtn = document.createElement('button');
        removeBtn.className =
            'ml-2 w-4 h-4 flex items-center justify-center text-green-500 hover:text-green-700 focus:outline-none rounded-full hover:bg-green-200 transition remove-filter';
        removeBtn.innerHTML =
            '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
        removeBtn.dataset.value = value;
        chip.appendChild(removeBtn);

        activeFiltersContainer.appendChild(chip);
    });

    // ✅ If nothing is left, just show label
    if (sortedFilters.length === 0 && !serverFiltersContainer) {
        activeFiltersContainer.innerHTML = '<span class="text-g-dark font-medium">Active Filters:</span>';
    }
}



    document.addEventListener('click', async function(e) {
        if (e.target.id === 'applyFiltersButton') {
            // ✅ Collect filters
            const selectedDiseases = Array.from(document.querySelectorAll('input[name="disease_type[]"]:checked')).map(el => el.value);
            const selectedBarangays = Array.from(document.querySelectorAll('input[name="barangays[]"]:checked')).map(el => el.value);
           // const selectedSeverity = document.querySelector('input[name="severity"]:checked')?.value || '';

            const params = new URLSearchParams();
            if (selectedDiseases.length) params.append('disease_id', selectedDiseases.join(','));
            if (selectedBarangays.length) params.append('barangay_id', selectedBarangays.join(','));
           //if (selectedSeverity) params.append('severity', selectedSeverity);

            try {
                // ✅ Fetch filtered heatmap data
                const response = await fetch(`/heatmap?${params.toString()}`);
                const data = await response.json();

                // ✅ Trigger event for map update
                window.dispatchEvent(new CustomEvent('heatmapDataUpdated', { detail: data }));

                modal.classList.add('hidden');
            } catch (error) {
                console.error('Error fetching heatmap data:', error);
            }
        }

        // Close / Reset / Toggle
        if (e.target.closest('#filterModal .close-modal')) modal.classList.add('hidden');
        else if (e.target.closest('#filterModal .reset-filters')) {
            activeFiltersSet.clear();
            document.querySelectorAll('#filterModal .filter-input').forEach(input => input.checked = false);
            updateActiveFilters();
        } else if (e.target.closest('.remove-filter')) {
            const value = String(e.target.closest('.remove-filter').dataset.value);
            activeFiltersSet.delete(value);
            const modalInput = document.querySelector(`#filterModal .filter-input[value="${value}"]`);
            if (modalInput) modalInput.checked = false;
            renderFilters();
            activeFiltersSet.forEach(v => {
                const input = document.querySelector(`#filterModal .filter-input[value="${v}"]`);
                if (input) input.checked = true;
            });
            updateActiveFilters();
        } else if (e.target.closest('.see-more-toggle')) {
            const btn = e.target.closest('.see-more-toggle');
            const targetSelector = btn.dataset.target;
            const container = modalContent.querySelector(targetSelector);
            if (!container) return;
            const limit = parseInt(container.dataset.limit, 10) || Infinity;
            const labels = Array.from(container.querySelectorAll('label'));
            const extraLabels = labels.slice(limit);
            const anyHidden = extraLabels.some(l => l.classList.contains('hidden'));
            extraLabels.forEach(l => l.classList.toggle('hidden', !anyHidden));
            btn.textContent = anyHidden ? 'See less' : 'See more';
        }
    });

    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('filter-input')) {
            const input = e.target;
            if (input.checked) activeFiltersSet.add(input.value);
            else activeFiltersSet.delete(input.value);
            updateActiveFilters();
        }
    });

    // Open modal
   if (openModalButton && modal) {
        openModalButton.addEventListener('click', async function() {
            // try {
            //     await loadFilterData(); // Try loading dynamic data
            // } catch (e) {
            //     console.warn('Falling back to default local filter data:', e);
                renderFilters(); // fallback if fetch fails
            // }
            modal.classList.remove('hidden');
        });
    }

    modal.addEventListener('click', function(e) {
        if (e.target === modal) modal.classList.add('hidden');
    });

    updateActiveFilters();
});
</script>
