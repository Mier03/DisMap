<x-app-layout>
    <x-certificate-modal />
    <x-modals.pop-up-modals />
    

    <div class="bg-g-bg flex min-h-screen w-full">
        {{-- Sidebar --}}
        @include('layouts.sidebar')

        {{-- Main Content --}}
        <div class="ml-64 flex-1 py-12 px-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden">
                    <div class="p-6 bg-inherit text-gray-900">

                        {{-- Flash Messages --}}
                        {{-- @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                        @endif

                        @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            {{ session('error') }}
                        </div>
                        @endif --}}

                        <x-page-header title="Data Requests" subtitle="User data requests" 
                       />

                        {{-- Search Form --}}
                        <form method="GET" action="{{ route('superadmin.datarequest') }}">
                            <x-search-bar placeholder="Search users..." value="{{ request('q') }}" />
                        </form>

                        {{-- Tabs --}}
                        <div class="mb-6 border-b border-gray-200">
                            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="requests-tab" data-tabs-toggle="#requests-tab-content" role="tablist">
                                <li class="me-2" role="presentation">
                                    <button class="inline-block p-4 border-b-2 rounded-t-lg border-blue-600 text-blue-600" id="pending-tab" data-tabs-target="#pending" type="button" role="tab" aria-controls="pending" aria-selected="true">Pending</button>
                                </li>
                                <li class="me-2" role="presentation">
                                    <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300" id="all-requests-tab" data-tabs-target="#all-requests" type="button" role="tab" aria-controls="all-requests" aria-selected="false">All Requests</button>
                                </li>
                            </ul>
                        </div>

                        {{-- Tab Content --}}
                        <div id="requests-tab-content">
                            {{-- Pending Tab --}}
                            <div class="p-4 rounded-lg" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                                <x-tables
                                    tableType="pendingDataRequests"
                                    :data="$dataRequests"
                                    title="All Pending Data Requests"
                                    icon="gmdi-person-search-o" 
                                />
                                <div class="my-6"></div> 
                                
                                <x-tables
                                    tableType="pendingHospitals"
                                    :data="$pendingHospitals"
                                    title="All Pending Hospital Request"
                                    icon="gmdi-person-search-o" 
                                />
                            </div>

                            {{-- All Requests Tab --}}
                            <div class="hidden p-4 rounded-lg" id="all-requests" role="tabpanel" aria-labelledby="all-requests-tab">
                                <x-tables
                                    tableType="allDataRequests"
                                    :data="$allDataRequests"
                                    title="All Data Requests"
                                    icon="gmdi-person-search-o" 
                                />
                                <div class="my-6"></div> 
                                
                                <x-tables
                                    tableType="allHospitalRequests"
                                    :data="$allHospitalRequests"
                                    title="All Hospital Requests"
                                    icon="gmdi-person-search-o" 
                                />
                            </div>
                        </div>

                        <x-modals.pop-up-modals
                            id="confirmationModal"
                            title="Confirm Action"
                            message="Are you sure you want to proceed?"
                            confirmText="Confirm"
                            cancelText="Cancel"
                            :isConfirmation="true"
                        />

                        {{-- Data Request Modals --}}
                        @foreach($dataRequests as $request)
                        <x-modal-popup
                            id="approveModal-{{ $request->id }}"
                            title="Approve Data Request"
                            message="Do you want to approve the data request from {{ $request->name }}?"
                            confirmText="Approve"
                            cancelText="Cancel"
                            :action="route('superadmin.data-requests.update', $request->id)"
                            method="PATCH">
                            @slot('formFields')
                                <input type="hidden" name="status" value="approved">
                            @endslot
                        </x-modal-popup>

                        <x-modal-popup
                            id="rejectModal-{{ $request->id }}"
                            title="Reject Data Request"
                            message="Do you want to reject the data request from {{ $request->name }}?"
                            confirmText="Reject"
                            cancelText="Cancel"
                            :action="route('superadmin.data-requests.update', $request->id)"
                            method="PATCH">
                            @slot('formFields')
                                <input type="hidden" name="status" value="rejected">
                            @endslot
                        </x-modal-popup>
                        @endforeach

                        {{-- Hospital Request Modals --}}
                        @foreach($pendingHospitals as $hospital)
                        <x-modal-popup
                            id="approveModal-{{ $hospital->id }}"
                            title="Approve Hospital Request"
                            message="Do you want to approve the hospital request for {{ $hospital->doctor->name ?? 'N/A' }} at {{ $hospital->hospital->name ?? 'N/A' }}?"
                            confirmText="Approve"
                            cancelText="Cancel"
                            :action="route('superadmin.approve_hospital', $hospital->id)"
                            method="POST" />

                        <x-modal-popup
                            id="rejectModal-{{ $hospital->id }}"
                            title="Reject Hospital Request"
                            message="Do you want to reject the hospital request for {{ $hospital->doctor->name ?? 'N/A' }} at {{ $hospital->hospital->name ?? 'N/A' }}?"
                            confirmText="Reject"
                            cancelText="Cancel"
                            :action="route('superadmin.reject_hospital', $hospital->id)"
                            method="POST" />
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-modals.form-modals id="reasonRequestModal" /> 
</x-app-layout>