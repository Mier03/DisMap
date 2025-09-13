{{-- components/filter-modal.blade.php --}}
<div id="filterModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div id="modalContent" class="bg-white rounded-lg p-6 w-[332px] max-h-[582px] overflow-y-auto"></div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('filterModal');
        const modalContent = document.getElementById('modalContent');
        const openModalButton = document.getElementById('openFilterModal');
        const activeFiltersContainer = document.getElementById('activeFiltersContainer');

        // Filter data
        const filterData = {
            'Disease Type': { name: 'disease_type', options: ['dengue', 'malaria', 'corona_virus', 'tuberculosis', 'typhoid', 'monkey_pox', 'measles', 'chicken_pox'], type: 'checkbox' },
            'Barangays': { name: 'barangays', options: ['apas', 'banawa', 'guadalupe', 'labangon', 'lahug', 'pardo', 'minglanilla', 'mambaling'], type: 'checkbox' },
            'Severity': { name: 'severity', options: ['low', 'medium', 'high', 'critical'], type: 'radio' }
        };

        // Track active filters
        let activeFiltersSet = new Set(['lahug']);

        // Render filters dynamically
        function renderFilters() {
            let html = `
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold" style="color: #296E5B">Filters</h3>
                    <div class="flex items-center space-x-4">
                        <button class="reset-filters text-gray-500 hover:text-gray-700" style="color: #296E5B">Reset</button>
                        <button class="close-modal text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="space-y-4">`;
            for (const [category, data] of Object.entries(filterData)) {
                html += `<div><h4 class="text-sm font-medium mb-2" style="color: #296E5B">${category}</h4><div class="space-y-1">`;
                const inputType = data.type;
                const inputName = inputType === 'radio' ? data.name : `${data.name}[]`;
                data.options.forEach(option => {
                    const isChecked = activeFiltersSet.has(option) ? 'checked' : '';
                    const displayText = option.charAt(0).toUpperCase() + option.slice(1).replace(/_/g, ' ');
                    html += `<label class="flex items-center"><input type="${inputType}" name="${inputName}" value="${option}" class="filter-input mr-2" ${isChecked}><span class="text-gray-900" style="color: #296E5B">${displayText}</span></label>`;
                });
                html += `</div></div>`;
            }
            html += `
                <div class="flex justify-end space-x-2 mt-4">
                    <button class="apply-filters bg-[#296E5B] text-white px-4 py-2 rounded-lg">Apply</button>
                </div>
            </div>`;
            modalContent.innerHTML = html;
        }

        // Format for display
        function formatFilter(value) {
            return value.charAt(0).toUpperCase() + value.slice(1).replace(/_/g, ' ');
        }

        // Update chips display
        function updateActiveFilters() {
            if (!activeFiltersContainer) return;

            const sortedFilters = Array.from(activeFiltersSet).sort();

            const label = activeFiltersContainer.querySelector('span:first-child');
            activeFiltersContainer.innerHTML = label ? label.outerHTML : '<span class="text-g-dark font-medium">Active Filters:</span>';

            sortedFilters.forEach(value => {
                const chip = document.createElement('span');
                chip.className = 'inline-flex items-center bg-green-50 text-green-700 border border-green-200 px-3 py-1 rounded-full text-sm mr-2 hover:bg-green-100 transition';

                const labelSpan = document.createElement('span');
                labelSpan.textContent = formatFilter(value);
                chip.appendChild(labelSpan);

                const removeBtn = document.createElement('button');
                removeBtn.className = 'ml-2 w-4 h-4 flex items-center justify-center text-green-500 hover:text-green-700 focus:outline-none rounded-full hover:bg-green-200 transition remove-filter';
                removeBtn.innerHTML = '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
                removeBtn.dataset.value = value;
                chip.appendChild(removeBtn);

                activeFiltersContainer.appendChild(chip);
            });

            if (sortedFilters.length === 0) {
                activeFiltersContainer.innerHTML = '<span class="text-g-dark font-medium">Active Filters:</span>';
            }
        }

        // Event delegation for modal and chips
        document.addEventListener('click', function(e) {
            if (e.target.closest('#filterModal .close-modal')) {
                modal.classList.add('hidden');
            } else if (e.target.closest('#filterModal .apply-filters')) {
                const newFilters = [];
                document.querySelectorAll('#filterModal .filter-input:checked').forEach(input => newFilters.push(input.value));
                activeFiltersSet = new Set(newFilters);
                updateActiveFilters();
                modal.classList.add('hidden');
            } else if (e.target.closest('#filterModal .reset-filters')) {
                activeFiltersSet.clear();
                document.querySelectorAll('#filterModal .filter-input').forEach(input => input.checked = false);
                updateActiveFilters();
            } else if (e.target.closest('.remove-filter')) {
                const value = e.target.closest('.remove-filter').dataset.value;
                activeFiltersSet.delete(value);
                updateActiveFilters();
            }
        });

        // Open modal
        if (openModalButton && modal) {
            openModalButton.addEventListener('click', function() {
                renderFilters();
                modal.classList.remove('hidden');
            });
        }

        // Close on overlay click
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.classList.add('hidden');
            }
        });

        // Initialize chips
        updateActiveFilters();
    });
</script>