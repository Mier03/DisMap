<x-app-layout>
    <div class="bg-g-bg flex min-h-screen w-full">
        @include('layouts.sidebar')

        <div class="ml-64 flex-1 py-12 px-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden">
                    <div class="p-6 bg-inherit text-gray-900">
                        
                        <x-page-header title="Disease Records" subtitle="Records of Diseases" buttonText="Export"/>
                        
                        <x-search-bar placeholder="Search diseases..." />

                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                            <x-stat-card number="2" label="Total Disease Types" />
                            <x-stat-card number="2" label="Active Cases" />
                            <x-stat-card number="1" label="Recovered" />
                            <x-stat-card number="2" label="Barangay Coverage" />
                        </div>

                        @php
                            $columns = ['Type', 'Total Case', 'Active', 'Recovered', 'Date Reported', 'Patients'];
                            $rows = [
                                ['Dengue', 1, 1, 0, '08/22/2025', '<button class="bg-g-dark text-white px-3 py-1 rounded">View</button>'],
                                ['Malaria', 28, 0, 1, '08/22/2025', '<button class="bg-g-dark text-white px-3 py-1 rounded">View</button>'],
                            ];
                        @endphp

                        <x-table :columns="$columns" :rows="$rows" table_title="Disease Overview" icon="gmdi-medical-information-o"/>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
