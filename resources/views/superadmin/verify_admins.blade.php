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
                        <!-- @php
                        $pendingColumns = ['Name', 'Hospital', 'Email', 'Username', 'Certificates', 'Actions'];
                        $pendingRows = [];

                        foreach($pendingAdmins as $admin) {
                        $certificateButton = $admin->certification
                        ? '<button onclick="viewCertificate(\'' . asset('storage/'.$admin->certification) . '\')"
                            class="bg-g-dark text-white px-3 py-1 rounded hover:bg-g-dark/80 transition">
                            View
                        </button>'
                        : '<span class="text-gray-500">No certificate</span>';

                        $actionButtons = '
                        <button type="button"
                            onclick="openModal(\'approveModal-' . $admin->id . '\')"
                            class="bg-g-dark text-white px-3 py-1 rounded mr-2 hover:bg-g-dark/80 transition">✓</button>

                        <button type="button"
                            onclick="openModal(\'rejectModal-' . $admin->id . '\')"
                            class="bg-r-dark text-white px-3 py-1 rounded hover:bg-red-600 transition">✕</button>
                        ';

                        $pendingRows[] = [
                        '<a href="' . route('superadmin.view_admin', $admin->id) . '" class="text-blue-600 hover:underline">' . $admin->name . '</a>',
                        // CORRECTED LINE: Access the hospital name via the relationship
                        $admin->hospitals->first()->name ?? 'N/A',
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
                            icon="gmdi-person-search-o" /> -->
                            
                        <x-tables
                            tableType="pendingAdmins"
                            :data="$pendingAdmins"
                            title="Pending Approvals"
                            icon="gmdi-person-search-o" 
                        />

                        <div class="my-6"></div> 

                        <x-tables
                            tableType="allAdmins"
                            :data="$allAdmins"
                            title="All Administrators"
                            icon="gmdi-admin-panel-settings" 
                        />

                        {{-- Modals for Pending Approvals --}}
                        <!-- @foreach($pendingAdmins as $admin)
                        <x-modal-popup
                            id="approveModal-{{ $admin->id }}"
                            title="Approve User"
                            message="Do you want to approve {{ $admin->name }}?"
                            confirmText="Approve"
                            cancelText="Cancel"
                            :action="route('superadmin.approve_admin', $admin->id)"
                            method="POST" />

                        <x-modal-popup
                            id="rejectModal-{{ $admin->id }}"
                            title="Reject User"
                            message="Do you want to reject {{ $admin->name }}?"
                            confirmText="Reject"
                            cancelText="Cancel"
                            :action="route('superadmin.reject_admin', $admin->id)"
                            method="POST" />
                        @endforeach

                        <div class="mb-4"></div>

                        {{-- All Administrators Table --}}
                        @php
                        $allColumns = ['Name', 'Hospital', 'Email', 'Username', 'Certificates', 'Actions'];
                        $allRows = [];

                        foreach($allAdmins as $admin) {
                        $certificateButton = $admin->certification
                        ? '<button onclick="viewCertificate(\'' . asset('storage/'.$admin->certification) . '\')"
                            class="bg-g-dark text-white px-3 py-1 rounded hover:bg-g-dark/80 transition">
                            View
                        </button>'
                        : '<span class="text-gray-500">No certificate</span>';

                        $actionButton = '
                        <button type="button"
                            onclick="openModal(\'editModal-' . $admin->id . '\')"
                            class="inline-block bg-g-dark text-white px-3 py-1 rounded mr-2">✎</button>

                        <button type="button"
                            onclick="openModal(\'deleteModal-' . $admin->id . '\')"
                            class="bg-r-dark text-white px-3 py-1 rounded hover:bg-red-600 transition">✕</button>
                        ';

                        $allRows[] = [
                        '<a href="' . route('superadmin.view_admin', $admin->id) . '" class="text-blue-600 hover:underline">' . $admin->name . '</a>',
                        // CORRECTED LINE: Access the hospital name via the relationship
                        $admin->hospitals->first()->name ?? 'N/A',
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
                            icon="gmdi-admin-panel-settings" /> -->

                        {{-- Modals for All Admins --}}
                        @foreach($allAdmins as $admin)
                        <x-modal-popup
                            id="deleteModal-{{ $admin->id }}"
                            title="Confirm Deletion"
                            message="Are you sure you want to delete {{ $admin->name }}? This action cannot be undone."
                            confirmText="Delete"
                            cancelText="Cancel"
                            :action="route('superadmin.delete_admin', $admin->id)"
                            method="DELETE" />

                        <x-modal-popup
                            id="editModal-{{ $admin->id }}"
                            title="Edit Admin"
                            message="Do you want to edit {{ $admin->name }}'s details?"
                            confirmText="Edit"
                            cancelText="Cancel"
                            {{-- :action="route('superadmin.edit_admin', $admin->id)" --}}
                            method="GET" />
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>