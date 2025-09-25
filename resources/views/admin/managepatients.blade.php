<x-app-layout>
    <x-certificate-modal />

    <div class="bg-g-bg flex min-h-screen w-full">
        {{-- Sidebar --}}
        @include('layouts.sidebar')

        {{-- Main Content --}}
        <div class="ml-64 flex-1 py-12 px-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden">
                    <div class="p-6 bg-inherit text-gray-900">
                        
                        {{-- Header --}}
                        <div class="flex items-center justify-between">
                            {{-- Header --}}
                            <x-page-header title="Manage Patients" subtitle="Patient Records" />

                            {{-- Export Button --}}
                            <button
                                onclick="openModal('exportModal')"
                                class="border border-g-dark text-g-dark bg-white px-4 py-2 rounded-lg hover:bg-[#F2F2F2]/90 transition shrink-0">
                                Export
                            </button>
                        </div>

                        {{-- Search --}}
                        <div class="flex items-start justify-between">
                            <div class="w-full mr-4">
                                <form method="GET" action="{{ route('admin.managepatients') }}">
                                    <x-search-bar placeholder="Search patients..." value="{{ request('q') }}" />
                                </form>
                            </div>
                            <button
                                onclick="openModal('addPatientModal')"
                                class="bg-g-dark text-white px-4 py-2 rounded-lg hover:bg-[#296E5B]/90 transition shrink-0">
                                + Add Patient
                            </button>
                        </div>
                        
                        {{-- All Patient Records Table --}}
                        <x-Tables.tables
                            tableType="allPatients"
                            :data="$patients"
                            title="All Patient Records"
                            icon="gmdi-people-alt-o"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modals are centralized --}}
    <x-modals.form-modals id="addPatientModal" />
    <x-modals.form-modals id="exportModal" />
</x-app-layout>