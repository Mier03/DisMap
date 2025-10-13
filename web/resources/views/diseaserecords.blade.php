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
                        <x-page-header title="Disease Records" subtitle="Records of Diseases" 
                        buttonText="Export" buttonClick="openModal('exportModal')" />
                        
                         {{-- Search Form --}}
                        <form action="{{ route('diseaserecords') }}" method="GET" class="mb-6" id="search-form">
                            <x-search-bar 
                                name="search"
                                id="search-input"
                                placeholder="Search diseases..."
                                value="{{ request('search') }}"
                            />
                        </form>

                        {{-- Stat Cards --}}
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                            <x-cards.stat-card :value="$statsTotalTypes" label="Total Disease Types" />
                            <x-cards.stat-card :value="$statsTotalCases" label="Total Cases" /> 
                            <x-cards.stat-card :value="$statsActive" label="Active Cases" />
                            <x-cards.stat-card :value="$statsRecovered" label="Recovered" />
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

