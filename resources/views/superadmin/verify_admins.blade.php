<x-app-layout>

    <div class="bg-g-bg flex min-h-screen w-full">
        {{-- Sidebar --}}
        @include('layouts.sidebar')

        {{-- Main Content --}}
        <div class="ml-64 flex-1 py-12 px-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden">
                    <div class="p-6 bg-inherit text-gray-900">
                        
                        {{-- Flash Messages --}}
                        @if(session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                                {{ session('success') }}
                            </div>
                        @endif
                        
                        @if(session('error'))
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                                {{ session('error') }}
                            </div>
                        @endif
                        
                        <x-page-header title="Manage Admins" subtitle="Administrator data and pending approvals" />

                        {{-- Search Form --}}
                        <form method="GET" action="{{ route('superadmin.verify_admins') }}">
                            <div class="mb-4 relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <x-gmdi-search class="w-5 h-5 text-gray-400" />
                                </div>
                                <input type="text" name="q" placeholder="Search admins..." 
                                    value="{{ request('q') }}"
                                    class="w-full pl-10 pr-4 py-2 border border-g-dark rounded-lg focus:outline-none focus:ring-1 focus:ring-[#296E5B]">
                            </div>
                        </form>

                        {{-- Pending Approvals Table --}}
                        <div class="p-4 bg-white border border-g-dark rounded-lg mb-6">
                            <p class="flex items-center space-x-2 text-m text-g-dark mb-4 underline">
                                <x-gmdi-person-search-o class="w-7 h-7 text-g-dark" />
                                <span>Pending Approvals</span>
                            </p>
                            <table class="w-full text-left">
                                <thead>
                                    <tr class="text-g-dark border-b">
                                        <th class="p-2">Name</th>
                                        <th class="p-2">Hospital</th>
                                        <th class="p-2">Email</th>
                                        <th class="p-2">Username</th>
                                        <th class="p-2">Certificates</th>
                                        <th class="p-2">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pendingAdmins as $admin)
                                    <tr class="border-b">
                                        <td class="p-2">
                                            <a href="{{ route('superadmin.view_admin', $admin->id) }}" class="text-blue-600 hover:underline">
                                                {{ $admin->name }}
                                            </a>
                                        </td>
                                        <td class="p-2">{{ $admin->hospital_name }}</td>
                                        <td class="p-2">{{ $admin->email }}</td>
                                        <td class="p-2">{{ $admin->username }}</td>
                                        <td class="p-2">
                                            @if($admin->certification)
                                                <button onclick="viewCertificate('{{ addslashes($admin->certification) }}')" class="bg-g-dark text-white px-3 py-1 rounded">
                                                    View
                                                </button>
                                            @else
                                                <span class="text-gray-500">No certificate</span>
                                            @endif
                                        </td>
                                        <td class="p-2">
                                            <form method="POST" action="{{ route('superadmin.approve_admin', $admin->id) }}" class="inline-block">
                                                @csrf
                                                <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded mr-2 hover:bg-green-600 transition">✓</button>
                                            </form>
                                            <form method="POST" action="{{ route('superadmin.reject_admin', $admin->id) }}" class="inline-block">
                                                @csrf
                                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition" onclick="return confirm('Are you sure you want to reject this admin?')">✘</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        {{-- All Administrators Table --}}
                        <div class="p-4 bg-white border border-g-dark rounded-lg">
                            <p class="flex items-center space-x-2 text-m text-g-dark mb-4 underline">
                                <x-gmdi-admin-panel-settings class="w-7 h-7 text-g-dark" />
                                <span>All Administrators</span>
                            </p>
                            <table class="w-full text-left">
                                <thead>
                                    <tr class="text-g-dark border-b">
                                        <th class="p-2">Name</th>
                                        <th class="p-2">Hospital</th>
                                        <th class="p-2">Email</th>
                                        <th class="p-2">Username</th>
                                        <th class="p-2">Certificates</th>
                                        <th class="p-2">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($allAdmins as $admin)
                                    <tr class="border-b">
                                        <td class="p-2">
                                            <a href="{{ route('superadmin.view_admin', $admin->id) }}" class="text-blue-600 hover:underline">
                                                {{ $admin->name }}
                                            </a>
                                        </td>
                                        <td class="p-2">{{ $admin->hospital_name }}</td>
                                        <td class="p-2">{{ $admin->email }}</td>
                                        <td class="p-2">{{ $admin->username }}</td>
                                        <td class="p-2">
                                            @if($admin->certification)
                                                <button onclick="viewCertificate('{{ addslashes($admin->certification) }}')" class="bg-g-dark text-white px-3 py-1 rounded">
                                                    View
                                                </button>
                                            @else
                                                <span class="text-gray-500">No certificate</span>
                                            @endif
                                        </td>
                                        <td class="p-2">
                                            <form method="POST" action="{{ route('superadmin.delete_admin', $admin->id) }}" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-[#B64657]  text-white px-3 py-1 rounded hover:bg-red-600 transition" onclick="return confirm('Are you sure you want to delete this admin?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Certificate Modal Component --}}
                        <x-certificate-modal />
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>