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
                            <x-search-bar placeholder="Search admins..." value="{{ request('q') }}" />
                        </form>

                        {{-- Pending Approvals Table --}}
                        @php
                            $pendingColumns = ['Name', 'Hospital', 'Email', 'Username', 'Certificates', 'Actions'];
                            $pendingRows = [];
                            
                            foreach($pendingAdmins as $admin) {
                                $certificateButton = $admin->certification 
                                      ? '<button onclick="viewCertificate(\'' . asset('storage/'.$admin->certification) . '\')" 
                                            class="bg-g-dark text-white px-3 py-1 rounded hover: bg-g-dark/79 transition">
                                            View
                                        </button>'
                                        : '<span class="text-gray-500">No certificate</span>';
                                    
                                $actionButtons = '
                                    <form method="POST" action="' . route('superadmin.approve_admin', $admin->id) . '" class="inline-block">
                                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                                        <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded mr-2 hover:bg-green-600 transition">✓</button>
                                    </form>
                                    <form method="POST" action="' . route('superadmin.reject_admin', $admin->id) . '" class="inline-block">
                                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">✘</button>
                                    </form>
                                ';
                                
                                $pendingRows[] = [
                                    '<a href="' . route('superadmin.view_admin', $admin->id) . '" class="text-blue-600 hover:underline">' . $admin->name . '</a>',
                                    $admin->hospital_name,
                                    $admin->email,
                                    $admin->username,
                                    $certificateButton,
                                    $actionButtons
                                ];
                            }
                        @endphp
                        
                        <x-table 
                            :columns="$pendingColumns" 
                            :rows="$pendingRows" 
                            table_title="Pending Approvals" 
                            icon="gmdi-person-search-o"
                        />

                        {{-- All Administrators Table --}}
                        @php
                            $allColumns = ['Name', 'Hospital', 'Email', 'Username', 'Certificates', 'Actions'];
                            $allRows = [];
                            
                            foreach($allAdmins as $admin) {
                                $certificateButton = $admin->certification 
                                    ? '<button onclick="viewCertificate(\'' . asset('storage/'.$admin->certification) . '\')" 
                                                class="bg-g-dark text-white px-3 py-1 rounded hover: bg-g-dark/79 transition">
                                            View
                                        </button>'
                                        : '<span class="text-gray-500">No certificate</span>';
                                    
                                $actionButton = '
                                    <form method="POST" action="' . route('superadmin.delete_admin', $admin->id) . '" class="inline-block">
                                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="bg-[#B64657] text-white px-3 py-1 rounded hover:bg-red-600 transition">Delete</button>
                                    </form>
                                ';
                                
                                $allRows[] = [
                                    '<a href="' . route('superadmin.view_admin', $admin->id) . '" class="text-blue-600 hover:underline">' . $admin->name . '</a>',
                                    $admin->hospital_name,
                                    $admin->email,
                                    $admin->username,
                                    $certificateButton,
                                    $actionButton
                                ];
                            }
                        @endphp
                        
                        <x-table 
                            :columns="$allColumns" 
                            :rows="$allRows" 
                            table_title="All Administrators" 
                            icon="gmdi-admin-panel-settings"
                        />
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>