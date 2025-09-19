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

                        <x-page-header title="Data Requests" subtitle="User data requests" />

                        {{-- Search Form --}}
                        <form method="GET" action="{{ route('superadmin.verify_admins') }}">
                            <x-search-bar placeholder="Search users..." value="{{ request('q') }}" />
                        </form>


                        <x-tables
                            tableType="default"
                            :data=[]
                            title="All Pending User Request"
                            icon="gmdi-person-search-o" 
                        />

                        <div class="my-6"></div> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>