<x-app-layout>


    <div class="bg-g-bg flex min-h-screen w-full">
        {{-- Sidebar --}}
        @include('layouts.sidebar')

        {{-- Main Content --}}
        <div class="ml-64 flex-1 py-12 px-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden">
                    <div class="p-6 bg-inherit text-gray-900">
                        
                        <x-page-header title="Manage Doctors" subtitle="Doctor data and pending approvals" />

                        <x-search-bar placeholder="Search doctors..." />

                        @php
                            $columns = ['Name', 'Hospital', 'Email', 'Certificates', 'Actions'];
                            $rows = [
                                ['Juan De La Cruz', 'Cebu Doctors Hospital', 'juandela.cruz@gmail.com', '<button class="bg-g-dark text-white px-3 py-1 rounded">View</button>', '<button class="bg-g-dark text-white px-3 py-1 rounded">✓</button> <button class="bg-[#B64657]  text-white px-3 py-1 rounded">X</button>'],
                                ['Maria Louis', 'VSMMC', 'maria.louis@email.com', '<button class="bg-g-dark text-white px-3 py-1 rounded">View</button>', '<button class="bg-g-dark text-white px-3 py-1 rounded">✓</button> <button class="bg-[#B64657]  text-white px-3 py-1 rounded">X</button>'],
                            ];
                        @endphp

                        <x-table :columns="$columns" :rows="$rows" table_title="All Pending Doctors" icon="gmdi-person-search-o"/>

                    </div>
                </div>
            </div>
        </div>
</x-app-layout>