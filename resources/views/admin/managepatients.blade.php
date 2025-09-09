<x-app-layout>
    <div class="bg-g-bg flex">
        {{-- Sidebar --}}
        @include('layouts.sidebar')

        {{-- Main Content --}}
        <div class="ml-64 flex-1 py-12 px-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden">
                    <div class="p-6 bg-inherit text-gray-900">
                        
                        {{-- Header --}}
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <h2 class="text-5xl font-bold text-g-dark">Manage Patients</h2>
                                <p class="text-g-dark mt-1">Patient Records</p>
                            </div>
                            <div class="flex space-x-2">
                                <button class="border border-g-dark text-g-dark px-4 py-2 rounded-lg hover:bg-gray-100 transition">
                                    Export
                                </button>
                                <button class="bg-g-dark text-white px-4 py-2 rounded-lg hover:bg-[#296E5B]/90 transition">
                                    + Add Patient
                                </button>
                            </div>
                        </div>

                        {{-- Search --}}
                        <div class="mb-4 relative w-full">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <x-gmdi-search class="w-5 h-5 text-gray-400" />
                            </div>
                            <input type="text" placeholder="Search patients..."
                                class="w-full pl-10 pr-4 py-2 border border-g-dark rounded-lg focus:outline-none focus:ring-1 focus:ring-[#296E5B]">
                        </div>

                        {{-- Table --}}
                        <div class="p-4 bg-white border border-g-dark rounded-lg">
                            <p class="flex items-center space-x-2 text-m text-g-dark mb-4 underline">
                                <x-gmdi-people-alt-o class="w-7 h-7 text-g-dark" />
                                <span>All Patient Records</span>  
                            </p>

                            <table class="w-full text-left">
                                <thead>
                                    <tr class="text-g-dark border-b">
                                        <th class="p-2">Name</th>
                                        <th class="p-2">Age</th>
                                        <th class="p-2">Barangay</th>
                                        <th class="p-2">Diagnosis</th>
                                        <th class="p-2">Hospital</th>
                                        <th class="p-2">Date Reported</th>
                                        <th class="p-2">Status</th>
                                        <th class="p-2">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-b">
                                        <td class="p-2">Juan De La Cruz</td>
                                        <td class="p-2">52</td>
                                        <td class="p-2">Labangon</td>
                                        <td class="p-2">Dengue</td>
                                        <td class="p-2">Chong Hua</td>
                                        <td class="p-2">08/22/2025</td>
                                        <td class="p-2">
                                            <span class="bg-yellow-200 text-yellow-800 px-2 py-1 rounded text-sm">Active</span>
                                        </td>
                                        <td class="p-2 space-x-2">
                                            <button class="bg-g-dark text-white px-2 py-1 rounded hover:bg-[#296E5B]/90">✎</button>
                                            <button class="bg-g-dark text-white px-2 py-1 rounded hover:bg-[#9E3745]">✕</button>
                                        </td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="p-2">Maria Louis</td>
                                        <td class="p-2">40</td>
                                        <td class="p-2">Lahug</td>
                                        <td class="p-2">Malaria</td>
                                        <td class="p-2">VSMMC</td>
                                        <td class="p-2">08/22/2025</td>
                                        <td class="p-2">
                                            <span class="bg-green-200 text-green-800 px-2 py-1 rounded text-sm">Recovered</span>
                                        </td>
                                        <td class="p-2 space-x-2">
                                            <button class="bg-g-dark text-white px-2 py-1 rounded hover:bg-[#296E5B]/90">✎</button>
                                            <button class="bg-g-dark text-white px-2 py-1 rounded hover:bg-[#9E3745]">✕</button>
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
