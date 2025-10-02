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
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h2 class="text-5xl font-bold text-g-dark">Disease Records</h2>
                                <p class="text-g-dark mt-1">Records of Diseases</p>
                            </div>
                            <div>
                            {{-- Export Button --}}
                            <button
                                onclick="openModal('exportModal')"
                                class="border border-g-dark text-g-dark bg-white px-4 py-2 rounded-lg hover:bg-[#F2F2F2]/90 transition shrink-0">
                                Export
                            </button>
                            </div>
                        </div>

                        
                         {{-- Search Form --}}
                        <form action="{{ route('diseaserecords') }}" method="GET" class="mb-6" id="search-form">
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <x-gmdi-search class="w-5 h-5 text-gray-400" />
                                </div>
                                <input type="text" 
                                    name="search" 
                                    id="search-input" 
                                    placeholder="Search diseases..."
                                    value="{{ request('search') }}"
                                    autocomplete="off"  {{-- Add this line --}}
                                    class="w-full pl-10 pr-4 py-2 border border-g-dark rounded-lg focus:outline-none focus:ring-1 focus:ring-[#296E5B]">
                            </div>
                        </form>

                        {{-- Stat Cards --}}
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                            {{-- Use overall stats (unfiltered) so search doesn't change stat cards --}}
                            <x-stat-card :value="$statsTotalTypes" label="Total Disease Types" />
                            <x-stat-card :value="$statsActive" label="Active Cases" />
                            <x-stat-card :value="$statsRecovered" label="Recovered" />
                            <x-stat-card value="2" label="Barangay Coverage" /> 
                        </div>


                        {{-- Table --}}
                        <x-tables 
                            tableType="diseaseRecords"
                            :data="$diseaseRecords"
                            title="Disease Overview"
                            icon="gmdi-medical-information-o"
                        />

                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Modals are centralized --}}
    <x-modals.form-modals id="exportModal" />
</x-app-layout>

