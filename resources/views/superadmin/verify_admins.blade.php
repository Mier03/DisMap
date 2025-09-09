<x-app-layout>


    <div class="bg-g-bg flex">
        {{-- Sidebar --}}
        @include('layouts.sidebar')

        {{-- Main Content --}}
        <div class="ml-64 flex-1 py-12 px-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden">
                    <div class="p-6 bg-inherit text-gray-900">
                        <h2 class="text-5xl font-bold text-g-dark mb-4">Manage Doctors</h2>
                        <p class="text-g-dark mb-4">Doctor data and pending approvals</p>
                        <div class="mb-4 relative w-full">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <x-gmdi-search class="w-5 h-5 text-gray-400" />
                            </div>
                            <input type="text" placeholder="Search doctors..."
                                class="w-full pl-10 pr-4 py-2 border border-g-dark rounded-lg focus:outline-none focus:ring-1 focus:ring-[#296E5B]">
                        </div>
                        <div class="p-4 bg-[white] border border-g-dark rounded-lg">
                            <table class="w-full text-left">
                                <p class="flex items-center space-x-2 text-m text-g-dark mb-4 underline">
                                    <x-gmdi-person-search-o class="w-7 h-7 text-g-dark"/>
                                    <span>All Pending Doctors</span>
                                </p>
                                <thead>
                                    <tr class="text-g-dark border-b">
                                        <th class="p-2">Name</th>
                                        <th class="p-2">Hospital</th>
                                        <th class="p-2">Email</th>
                                        <th class="p-2">Certificates/ID</th>
                                        <th class="p-2">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-b">
                                        <td class="p-2">Juan De La Cruz</td>
                                        <td class="p-2">Cebu Doctors Hospital</td>
                                        <td class="p-2">juandela.cruz@gmail.com</td>
                                        <td class="p-2">
                                            <button class="bg-g-dark text-white px-3 py-1 rounded">View</button>
                                        </td>
                                        <td class="p-2">
                                            <button class="bg-g-dark text-white px-3 py-1 rounded">✓</button>
                                            <button class="bg-[#B64657]  text-white px-3 py-1 rounded">X</button>
                                        </td>
                                    </tr>
                                    <tr class="border-b">
                                        <td class="p-2">Maria Louis</td>
                                        <td class="p-2">VSMMC</td>
                                        <td class="p-2">maria.louis@email.com</td>
                                        <td class="p-2">
                                            <button class="bg-g-dark text-white px-3 py-1 rounded">View</button>
                                        </td>
                                        <td class="p-2">
                                            <button class="bg-g-dark text-white px-3 py-1 rounded">✓</button>
                                            <button class="bg-[#B64657]  text-white px-3 py-1 rounded">X</button>
                                        </td>
                                    </tr>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>