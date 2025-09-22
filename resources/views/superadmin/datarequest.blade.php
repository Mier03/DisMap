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
                        <div class="flex items-center justify-between">
                            <x-page-header title="Data Requests" subtitle="User data requests" />
                                <button
                                    onclick="openModal('reasonRequestModal')"
                                    class="border border-g-dark text-g-dark bg-white px-4 py-2 rounded-lg hover:bg-[#F2F2F2]/90 transition shrink-0">
                                    Data Requests
                                </button>
                        </div>
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
        <x-modals.form-modals id="reasonRequestModal" />
</x-app-layout>