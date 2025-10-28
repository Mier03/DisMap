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
                        <span class="material-icons mr-2">arrow_back</span>
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
                                    <span class="text-gray-800" id="admin-name">{{ $admin->name }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-g-light/50">
                                    <span class="text-sm font-medium text-gray-600">Email:</span>
                                    <span class="text-gray-800" id="admin-email">{{ $admin->email }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-g-light/50">
                                    <span class="text-sm font-medium text-gray-600">Username:</span>
                                    <span class="text-gray-800" id="admin-username">{{ $admin->username }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-sm font-medium text-gray-600">Hospital:</span>
                                    <span class="text-gray-800" id="admin-hospital">{{ $admin->hospitals->first()->name ?? 'N/A' }}</span>
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
                                <!-- Approval Status (for pending/approved) -->
                                <div class="flex justify-between items-center py-2 border-b border-g-light/50">
                                    <span class="text-sm font-medium text-gray-600">Approval Status:</span>
                                    <span class="px-3 py-1 rounded-full text-xs font-medium {{ $admin->is_approved ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $admin->is_approved ? 'Approved' : 'Pending Approval' }}
                                    </span>
                                </div>

                                <!-- Active/Inactive Status (only for approved admins) -->
                                @if($admin->is_approved)
                                <div class="flex justify-between items-center py-2 border-b border-g-light/50">
                                    <span class="text-sm font-medium text-gray-600">Account Status:</span>
                                    <span class="px-3 py-1 rounded-full text-xs font-medium {{ $admin->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($admin->status ?? 'Inactive') }}
                                    </span>
                                </div>
                                @endif
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
                                <a href="{{ asset('storage/'.$admin->certification) }}" target="_blank"
                                    class="flex items-center bg-g-dark text-white px-3 py-2 rounded hover:bg-g-dark/80 transition">
                                    <span class="material-icons mr-1 text-sm">visibility</span>
                                    View Certificate
                                </a>
                            </div>
                            <div class="bg-gray-50 p-3 rounded border">
                                <p class="text-sm text-gray-700 break-words font-mono">
                                    {{ $admin->certification }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Check if we're in edit mode based on request parameter -->
                    @php
                    $isEditMode = request()->has('edit') && request()->get('edit') === 'true';
                    @endphp

                    <!-- Action Buttons -->
                    <div class="flex space-x-4 pt-4 border-t border-g-light">
                        @if(!$admin->is_approved)
                        <!-- For Pending Admins: Approve and Reject -->
                        <form method="POST" action="{{ route('superadmin.approve_admin', $admin->id) }}" class="flex-1">
                            @csrf
                            <x-primary-button class="w-full justify-center bg-g-dark hover:bg-g-dark/90">
                                <span class="material-icons mr-2">check</span>
                                Approve Admin
                            </x-primary-button>
                        </form>

                        <form method="POST"
                            action="{{ route('superadmin.reject_admin', $admin->id) }}"
                            class="flex-1"
                            onsubmit="return confirm('Are you sure you want to reject this admin?')">
                            @csrf
                            <x-danger-button class="w-full justify-center">
                                <span class="material-icons mr-2">close</span>
                                Reject Admin
                            </x-danger-button>
                        </form>
                        @else
                        <!-- For Approved Admins: Edit and Delete -->
                        @if(!$isEditMode)
                        <a href="{{ route('superadmin.view_admin', ['id' => $admin->id, 'edit' => 'true']) }}"
                            class="flex-1 no-underline">
                            <x-primary-button class="w-full justify-center bg-g-dark hover:bg-g-dark/90">
                                <span class="material-icons mr-2">edit</span>
                                Edit Admin
                            </x-primary-button>
                        </a>

                        <form method="POST"
                            action="{{ route('superadmin.delete_admin', $admin->id) }}"
                            class="flex-1"
                            onsubmit="return confirm('Are you sure you want to delete this admin?')">
                            @csrf
                            @method('DELETE')
                            <x-danger-button class="w-full justify-center">
                                <span class="material-icons mr-2">delete</span>
                                Delete Admin
                            </x-danger-button>
                        </form>
                        @else
                        <!-- Cancel Edit Button -->
                        <a href="{{ route('superadmin.view_admin', ['id' => $admin->id]) }}"
                            class="flex-1 no-underline">
                            <x-secondary-button class="w-full justify-center">
                                <span class="material-icons mr-2">close</span>
                                Cancel Edit
                            </x-secondary-button>
                        </a>
                        @endif
                        @endif
                    </div>


                    <!-- Edit Form-->
                    @if($isEditMode)
                    <div id="edit-form" class="mt-6 pt-4 border-t border-g-light">
                        <h3 class="text-lg font-semibold text-g-dark mb-4">Edit Admin Information</h3>

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

                        <form method="POST" action="{{ route('superadmin.update_admin', $admin->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <!-- Name Field -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                                    <input type="text" name="name" value="{{ old('name', $admin->name) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-g-dark/50">
                                    @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Username Field -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Username *</label>
                                    <input type="text" name="username" value="{{ old('username', $admin->username) }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-g-dark/50">
                                    @error('username')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Status Field (only show for approved admins) -->
                            <!-- Status Field (only show for approved admins) -->
                            @if($admin->is_approved)
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Account Status *</label>
                                <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-g-dark/50">
                                    <option value="Active" {{ old('status', $admin->status) === 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Inactive" {{ old('status', $admin->status) === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            @else
                            <!-- Approval Status Field (for pending admins) -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Approval Status *</label>
                                <select name="is_approved" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-g-dark/50">
                                    <option value="1" {{ old('is_approved', $admin->is_approved) == 1 ? 'selected' : '' }}>Approve</option>
                                    <option value="0" {{ old('is_approved', $admin->is_approved) == 0 ? 'selected' : '' }}>Keep Pending</option>
                                </select>
                                @error('is_approved')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            @endif

                            <div class="flex space-x-4 mt-6">
                                <button type="submit" class="bg-g-dark text-white px-4 py-2 rounded hover:bg-g-dark/90 transition">
                                    Save Changes
                                </button>
                                <!-- <a href="{{ route('superadmin.view_admin', ['id' => $admin->id]) }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition text-center flex items-center">
                                    Cancel
                                </a> -->
                            </div>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <x-certificate-modal />
</x-app-layout>