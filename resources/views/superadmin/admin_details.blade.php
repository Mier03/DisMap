<x-app-layout>
    <div class="bg-g-bg flex min-h-screen w-full">
        @include('layouts.sidebar')

        <div class="ml-64 flex-1 py-12 px-6">
            <div class="max-w-4xl mx-auto">
                <div class="bg-white shadow rounded-lg p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Admin Details</h2>
                        <a href="{{ route('superadmin.verify_admins') }}" class="text-blue-600 hover:underline">← Back to list</a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Personal Information</h3>
                            <div class="space-y-2">
                                <p><strong>Name:</strong> {{ $admin->name }}</p>
                                <p><strong>Email:</strong> {{ $admin->email }}</p>
                                <p><strong>Username:</strong> {{ $admin->username }}</p>
                                <p><strong>Hospital:</strong> {{ $admin->hospital_id }}</p>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold mb-2">Certification & Status</h3>
                            <div class="space-y-2">
                                <p><strong>Certification:</strong> {{ $admin->certification ?? 'Not provided' }}</p>
                                <p><strong>Status:</strong> 
                                    <span class="px-2 py-1 rounded text-sm {{ $admin->is_approved ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $admin->is_approved ? 'Approved' : 'Pending' }}
                                    </span>
                                </p>
                                <p><strong>User Type:</strong> {{ ucfirst($admin->user_type) }}</p>
                            </div>
                        </div>
                    </div>

                    @if($admin->certification)
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold mb-2">Certification Document</h3>
                        <div class="bg-gray-100 p-4 rounded">
                            <p class="break-words">{{ $admin->certification }}</p>
                        </div>
                    </div>
                    @endif

                    <div class="mt-6 flex space-x-4">
                        @if(!$admin->is_approved)
                        <form method="POST" action="{{ route('superadmin.approve_admin', $admin->id) }}">
                            @csrf
                            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Approve</button>
                        </form>
                        @endif
                        
                        <form method="POST" action="{{ route($admin->is_approved ? 'superadmin.delete_admin' : 'superadmin.reject_admin', $admin->id) }}">
                            @csrf
                            @if($admin->is_approved)
                                @method('DELETE')
                            @endif
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600" onclick="return confirm('Are you sure?')">
                                {{ $admin->is_approved ? 'Delete' : 'Reject' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>