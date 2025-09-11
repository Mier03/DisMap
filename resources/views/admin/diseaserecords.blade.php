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
                                <button class="border border-g-dark text-g-dark px-4 py-2 rounded-lg hover:bg-gray-100 transition">
                                    Export
                                </button>
                            </div>
                        </div>

                        {{-- Search --}}
                        <div class="mb-6 relative w-full">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <x-gmdi-search class="w-5 h-5 text-gray-400" />
                            </div>
                            <input type="text" placeholder="Search diseases..."
                                class="w-full pl-10 pr-4 py-2 border border-g-dark rounded-lg focus:outline-none focus:ring-1 focus:ring-[#296E5B]">
                        </div>

                        {{-- Stat Cards --}}
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                            <div class="p-4 bg-white border border-g-dark rounded-lg text-center">
                                <p class="text-3xl font-bold text-g-dark">2</p>
                                <p class="text-sm text-gray-600">Total Disease Types</p>
                            </div>
                            <div class="p-4 bg-white border border-g-dark rounded-lg text-center">
                                <p class="text-3xl font-bold text-g-dark">2</p>
                                <p class="text-sm text-gray-600">Active Cases</p>
                            </div>
                            <div class="p-4 bg-white border border-g-dark rounded-lg text-center">
                                <p class="text-3xl font-bold text-g-dark">1</p>
                                <p class="text-sm text-gray-600">Recovered</p>
                            </div>
                            <div class="p-4 bg-white border border-g-dark rounded-lg text-center">
                                <p class="text-3xl font-bold text-g-dark">2</p>
                                <p class="text-sm text-gray-600">Barangay Coverage</p>
                            </div>
                        </div>

                        {{-- Table --}}
                        <div class="p-4 bg-white border border-g-dark rounded-lg">
                            <p class="flex items-center space-x-2 text-m text-g-dark mb-4 underline">
                                <x-gmdi-medical-information-o class="w-7 h-7 text-g-dark" />
                                <span>Disease Overview</span>  
                            </p>

                            <table class="w-full text-left">
                                <thead>
                                    <tr class="text-g-dark border-b">
                                        <th class="p-2">Type</th>
                                        <th class="p-2">Total Case</th>
                                        <th class="p-2">Active</th>
                                        <th class="p-2">Recovered</th>
                                        <th class="p-2">Date Reported</th>
                                        <th class="p-2">Patients</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-b">
                                        <td class="p-2">Dengue</td>
                                        <td class="p-2">1</td>
                                        <td class="p-2">1</td>
                                        <td class="p-2">0</td>
                                        <td class="p-2">08/22/2025</td>
                                        <td class="p-2">
                                            <button class="bg-g-dark text-white px-3 py-1 rounded hover:bg-[#296E5B]/90">View</button>
                                        </td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="p-2">Malaria</td>
                                        <td class="p-2">28</td>
                                        <td class="p-2">0</td>
                                        <td class="p-2">1</td>
                                        <td class="p-2">08/22/2025</td>
                                        <td class="p-2">
                                            <button class="bg-g-dark text-white px-3 py-1 rounded hover:bg-[#296E5B]/90">View</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
