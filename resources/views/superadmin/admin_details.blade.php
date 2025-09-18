<x-app-layout>
    <div class="bg-g-bg flex min-h-screen w-full">
        @include('layouts.sidebar')

        <div class="ml-64 flex-1 py-8 px-6">
            <div class="max-w-4xl mx-auto">
                <!-- Header with back button on the right -->
                <div class="flex justify-between items-center mb-6">
                    <x-page-header title="Admin Details" subtitle="Administrator information and certification" />

                    <a href="{{ route('superadmin.verify_admins') }}"
                        class="flex items-center text-g-dark hover:text-g-dark/80 transition">

                        <span class="material-icons ml-2">arrow_back</span>
                        <span>Back to list</span>
                    </a>
                </div>

                <div class="bg-white border border-g-dark/20 rounded-lg p-6 shadow-sm">
                    <!-- Admin Information Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Personal Information Card -->
                        <div class="bg-g-bg border border-g-light rounded-lg p-4">
                            <div class="flex items-center mb-3">
                                <span class="material-icons text-g-dark mr-2">person</span>
                                <h3 class="text-lg font-semibold text-g-dark">Personal Information</h3>
                            </div>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center py-2 border-b border-g-light/50">
                                    <span class="text-sm font-medium text-gray-600">Name:</span>
                                    <span class="text-gray-800">{{ $admin->name }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-g-light/50">
                                    <span class="text-sm font-medium text-gray-600">Email:</span>
                                    <span class="text-gray-800">{{ $admin->email }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-g-light/50">
                                    <span class="text-sm font-medium text-gray-600">Username:</span>
                                    <span class="text-gray-800">{{ $admin->username }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-sm font-medium text-gray-600">Hospital:</span>
                                    <span class="text-gray-800">{{ $admin->hospitals->first()->name ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Status Information Card -->
                        <div class="bg-g-bg border border-g-light rounded-lg p-4">
                            <div class="flex items-center mb-3">
                                <span class="material-icons text-g-dark mr-2">verified_user</span>
                                <h3 class="text-lg font-semibold text-g-dark">Status & Certification</h3>
                            </div>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center py-2 border-b border-g-light/50">
                                    <span class="text-sm font-medium text-gray-600">Status:</span>
                                    <span class="px-3 py-1 rounded-full text-xs font-medium {{ $admin->is_approved ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $admin->is_approved ? 'Approved' : 'Pending Approval' }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-g-light/50">
                                    <span class="text-sm font-medium text-gray-600">User Type:</span>
                                    <span class="text-gray-800 capitalize">{{ $admin->user_type }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-sm font-medium text-gray-600">Certification:</span>
                                    <span class="text-gray-800">{{ $admin->certification ? 'Provided' : 'Not provided' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Certification Document Section -->
                    @if($admin->certification)
                    <div class="bg-g-bg border border-g-light rounded-lg p-4 mb-6">
                        <div class="flex items-center mb-4">
                            <span class="material-icons text-g-dark mr-2">description</span>
                            <h3 class="text-lg font-semibold text-g-dark">Certification Document</h3>
                        </div>

                        <div class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-sm text-gray-600">Certificate File:</span>
                                <button 
                                    onclick="viewCertificate('{{ asset('storage/'.$admin->certification) }}')"
                                    class="flex items-center bg-g-dark text-white px-3 py-2 rounded hover:bg-g-dark/80 transition">
                                    <span class="material-icons mr-1 text-sm">visibility</span>
                                    View Certificate
                                </button>
                            </div>
                            <div class="bg-gray-50 p-3 rounded border">
                                <p class="text-sm text-gray-700 break-words font-mono">
                                    {{ $admin->certification }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="flex space-x-4 pt-4 border-t border-g-light">
                        @if(!$admin->is_approved)
                        <form method="POST" action="{{ route('superadmin.approve_admin', $admin->id) }}" class="flex-1">
                            @csrf
                            <x-primary-button 
                                class="w-full justify-center bg-g-dark hover:bg-g-dark/90">
                                <span class="material-icons mr-2">check</span>
                                Approve Admin
                            </x-primary-button>
                        </form>
                        @endif

                        <form method="POST"
                            action="{{ route($admin->is_approved ? 'superadmin.delete_admin' : 'superadmin.reject_admin', $admin->id) }}"
                            class="flex-1"
                            onsubmit="return confirm('Are you sure you want to {{ $admin->is_approved ? 'delete' : 'reject' }} this admin?')">
                            @csrf
                            @if($admin->is_approved)
                            @method('DELETE')
                            @endif
                            <x-danger-button 
                                class="w-full justify-center">
                                <span class="material-icons mr-2">close</span>
                                {{ $admin->is_approved ? 'Delete Admin' : 'Reject Admin' }}
                            </x-danger-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <x-certificate-modal />
</x-app-layout>