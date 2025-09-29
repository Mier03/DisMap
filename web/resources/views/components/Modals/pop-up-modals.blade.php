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

<div id="{{ $id }}"
      class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md text-center">
        <h2 class="text-xl font-bold text-g-dark mb-2">{{ $title }}</h2>

        @if ($isConfirmation)
            {{-- Confirmation Modal Layout --}}
            <p class="text-g-dark mb-6">{{ $message }}</p>

            <div class="flex justify-center space-x-3">
                @if ($action)
                    <form method="POST" action="{{ $action }}">
                        @csrf
                        @if (strtoupper($method) !== 'POST')
                            @method($method)
                        @endif
                        <button type="submit"
                                class="bg-g-dark text-white px-4 py-2 rounded-md font-semibold hover:bg-g-dark/90">
                            {{ $confirmText }}
                        </button>
                    </form>
                @else
                    <button type="button"
                                class="bg-g-dark text-white px-4 py-2 rounded-md font-semibold hover:bg-g-dark/90">
                            {{ $confirmText }}
                    </button>
                @endif
                <button type="button" onclick="closeModal('{{ $id }}')"
                        class="border border-g-dark text-g-dark px-4 py-2 rounded-md font-semibold hover:bg-gray-100">
                    {{ $cancelText }}
                </button>
            </div>
        @else
            {{-- View Content Modal Layout --}}
            <div class="text-g-dark mb-6 overflow-y-auto max-h-96 text-left">
                <p id="modalMessageContent">{{ $message }}</p>
            </div>
            <div class="flex justify-end">
                <button type="button" onclick="closeModal('{{ $id }}')"
                        class="border border-g-dark text-g-dark px-4 py-2 rounded-md font-semibold hover:bg-gray-100">
                    {{ $cancelText }}
                </button>
            </div>
        @endif
    </div>
</div>

<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }
    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }

    /**
     * @param {string} remarksText - The text content to display in the modal.
     * @param {string} [modalId='modalId'] - The ID of the modal to open.
     */
</script>

{{-- Filter Modal merged in from resources/views/components/filter-modal.blade.php --}}
<div id="filterModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div id="modalContent" class="bg-white rounded-lg p-6 w-[332px] max-h-[582px] overflow-y-auto"></div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('filterModal');
        const modalContent = document.getElementById('modalContent');
        const openModalButton = document.getElementById('openFilterModal');
        const activeFiltersContainer = document.getElementById('activeFiltersContainer');

        // Dynamically get data from Blade props
        // This data is passed from the controller to the view via component props
        const filterData = {
            'Disease Type': { name: 'disease_type', options: @json(collect($diseases)->map(function($d) { return ['value' => $d['id'] ?? $d->id, 'text' => $d['specification'] ?? $d->specification]; })), type: 'checkbox' },
            // Limit initial barangays display to 10 and provide full list for 'see more'
            'Barangays': { name: 'barangays', options: @json(collect($barangays)->map(function($b) { return ['value' => $b['id'] ?? $b->id, 'text' => $b['name'] ?? $b->name]; })), type: 'checkbox', limit: 10 },
            'Severity': { name: 'severity', options: [{value: 'low', text: 'Low'}, {value: 'medium', text: 'Medium'}, {value: 'high', text: 'High'}, {value: 'critical', text: 'Critical'}], type: 'radio' }
        };

        // Track active filters (store option.value strings)
        let activeFiltersSet = new Set();

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
                const containerId = `options-${data.name}`;
                // Handle limited display (see more)
                const limit = data.limit || Infinity;
                // store the limit on the container so the toggle knows how many to show
                html += `<div><h4 class="text-sm font-medium mb-2" style="color: #296E5B">${category}</h4><div id="${containerId}" data-limit="${limit}" class="space-y-1">`;
                const inputType = data.type;
                const inputName = inputType === 'radio' ? data.name : `${data.name}[]`;
                data.options.forEach((option, idx) => {
                    const shouldHide = idx >= limit;
                    // Checked logic should use option.value (id) not text
                    const isChecked = activeFiltersSet.has(String(option.value)) ? 'checked' : '';
                    const displayText = option.text;
                    // Use Tailwind classes to ensure consistent alignment and keep wrapped text aligned under the label
                    const extraClass = shouldHide ? 'extra-option hidden' : 'extra-option';
                    html += `<label class="flex items-start w-full gap-2 py-1 ${extraClass}"><input type="${inputType}" name="${inputName}" value="${option.value}" class="filter-input h-4 w-4 flex-shrink-0 mt-1" ${isChecked}><span class="ml-2 text-gray-900 whitespace-normal" style="color: #296E5B">${displayText}</span></label>`;
                });
                // If there are more options than the limit, add a toggle button
                if (data.options.length > limit && isFinite(limit)) {
                    html += `<button type="button" class="mt-2 text-sm text-left text-gray-600 see-more-toggle" data-target="#${containerId}">See more</button>`;
                }
                html += `</div></div>`;
            }
            html += `</div>`; // Close the space-y-4 div
            modalContent.innerHTML = html;
        }

        // Format for display using value -> text lookup
        function formatFilter(value) {
            for (const category of Object.values(filterData)) {
                const option = category.options.find(opt => String(opt.value) === String(value));
                if (option) return option.text;
            }
            return value;
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
            } else if (e.target.closest('#filterModal .reset-filters')) {
                activeFiltersSet.clear();
                document.querySelectorAll('#filterModal .filter-input').forEach(input => input.checked = false);
                updateActiveFilters();
            } else if (e.target.closest('.remove-filter')) {
                const value = e.target.closest('.remove-filter').dataset.value;
                activeFiltersSet.delete(value);
                const modalInput = document.querySelector(`#filterModal .filter-input[value="${value}"]`);
                if (modalInput) {
                    modalInput.checked = false;
                }
                updateActiveFilters();
            } else if (e.target.closest('.see-more-toggle')) {
                const btn = e.target.closest('.see-more-toggle');
                const targetSelector = btn.dataset.target;
                const container = modalContent.querySelector(targetSelector);
                if (!container) return;
                const limit = parseInt(container.dataset.limit, 10) || Infinity;
                const labels = Array.from(container.querySelectorAll('label'));
                if (labels.length <= limit) return;

                const extraLabels = labels.slice(limit);
                // If any extra is hidden, reveal all extras; otherwise hide them
                const anyHidden = extraLabels.some(l => l.classList.contains('hidden'));
                if (anyHidden) {
                    extraLabels.forEach(l => l.classList.remove('hidden'));
                    btn.textContent = 'See less';
                } else {
                    extraLabels.forEach(l => l.classList.add('hidden'));
                    btn.textContent = 'See more';
                }
            }
        });

        // NEW: Listen for changes on filter inputs to update immediately
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('filter-input')) {
                const input = e.target;
                if (input.checked) {
                    activeFiltersSet.add(input.value);
                } else {
                    activeFiltersSet.delete(input.value);
                }
                if (input.type === 'radio') {
                    const radioName = input.name;
                    const allRadioInputs = document.querySelectorAll(`input[name="${radioName}"]`);
                    allRadioInputs.forEach(radio => {
                        if (radio.value !== input.value) {
                            activeFiltersSet.delete(radio.value);
                        }
                    });
                    activeFiltersSet.add(input.value);
                }
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