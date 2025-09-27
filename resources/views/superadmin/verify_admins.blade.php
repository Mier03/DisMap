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
                        <form id="admin-search-form" method="GET" action="{{ route('superadmin.verify_admins') }}">
                            <x-search-bar
                                id="admin-search-input"
                                name="q"
                                placeholder="Search by name, email, or hospital..."
                                value="{{ request('q') }}" />
                        </form>

                        {{-- Container for Pending Admins table for AJAX updates --}}
                        <div id="pending-admins-container">
                            <x-tables
                                tableType="pendingAdmins"
                                :data="$pendingAdmins"
                                title="Pending Approvals"
                                icon="gmdi-person-search-o"
                            />
                        </div>

                        <div class="my-6"></div> 

                        {{-- Container for All Admins table for AJAX updates --}}
                        <div id="all-admins-container">
                             <x-tables
                                tableType="allAdmins"
                                :data="$allAdmins"
                                title="All Administrators"
                                icon="gmdi-admin-panel-settings" 
                            />
                        </div>

                        {{-- Modals for Pending Approvals --}}
                        @foreach($pendingAdmins as $admin)
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

                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    {{-- You can include jQuery via a CDN like this if it's not in your project's asset bundle --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Debounce function to limit the rate at which a function gets called.
            // This prevents sending a request for every single keystroke.
            function debounce(func, delay) {
                let timeout;
                return function(...args) {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(this, args), delay);
                };
            }

            // The function that performs the AJAX search
            const performSearch = () => {
                const query = $('#admin-search-input').val();
                const url = $('#admin-search-form').attr('action');

                $.ajax({
                    url: url,
                    type: 'GET',
                    data: { q: query },
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest' // Important for Laravel's $request->ajax()
                    },
                    success: function(response) {
                        // Replace the HTML content of the table containers with the new rendered HTML
                        $('#pending-admins-container').html(response.pendingHtml);
                        $('#all-admins-container').html(response.allHtml);
                    },
                    error: function(xhr) {
                        console.error("An error occurred during search: " + xhr.status + " " + xhr.statusText);
                    }
                });
            };

            // Attach the debounced search function to the 'keyup' event of the search input
            $('#admin-search-input').on('keyup', debounce(performSearch, 300)); // 300ms delay

            // Prevent the form from doing a full page reload if the user hits Enter
            $('#admin-search-form').on('submit', function(e) {
                e.preventDefault();
                performSearch(); // Trigger the search manually on submit
            });
        });
    </script>
    @endpush
    <x-certificate-modal />
</x-app-layout>