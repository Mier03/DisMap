<x-app-layout>
    <div class="bg-g-bg flex min-h-screen w-full">
        {{-- Sidebar --}}
        @include('layouts.sidebar')

        {{-- Main Content --}}
        <div class="ml-64 flex-1 py-12 px-6">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden">
                    <div class="p-6 bg-inherit text-gray-900">
                        
                        {{-- Header --}}
                        <div class="mb-6">
                            <h2 class="text-5xl font-bold text-g-dark">Profile Information</h2>
                            <p class="text-g-dark mt-1">Manage your account information and security</p>
                        </div>

                        <div class="bg-white border border-g-dark rounded-lg p-6 flex flex-col md:flex-row md:items-start relative min-h-[550px]">

                            {{-- Profile Image --}}
                            <div class="flex-shrink-0 mr-6 mb-6 md:mb-0">
                                <img src="/images/defaultprofile.jpg" alt="Profile"
                                     class="w-[300px] h-[300px] rounded-full object-cover border-4 border-white shadow-lg">
                            </div>

                            {{-- Profile Form --}}
                            <form method="POST" action="{{ route('profile.update') }}" class="w-[346px] flex flex-col">
                                @csrf
                                @method('PATCH')

                                <div class="mb-4">
                                    <label for="name" class="block text-sm font-medium text-g-dark">Full Name</label>
                                    <input type="text" id="name" name="name"
                                           value="{{ old('name', Auth::user()->name) }}"
                                           class="mt-1 block w-full border border-g-dark rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#296E5B]"
                                           required>
                                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="username" class="block text-sm font-medium text-g-dark">Username</label>
                                    <input type="text" id="username" name="username"
                                           value="{{ old('username', Auth::user()->username) }}"
                                           class="mt-1 block w-full border border-g-dark rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#296E5B]"
                                           required>
                                    @error('username') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="email" class="block text-sm font-medium text-g-dark">Email</label>
                                    <input type="email" id="email" name="email"
                                           value="{{ old('email', Auth::user()->email) }}"
                                           class="mt-1 block w-full border border-g-dark rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#296E5B]"
                                           required>
                                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div class="flex items-center space-x-4 mt-6">
                                    <button type="submit"
                                            class="bg-g-dark text-white px-6 py-2 rounded hover:bg-[#296E5B]/90 transition">
                                        Update Profile
                                    </button>

                                    <button type="button"
                                            onclick="document.getElementById('passwordModal').classList.remove('hidden')"
                                            class="bg-g-dark text-white px-6 py-2 rounded hover:bg-[#296E5B]/90 transition">
                                        Change Password
                                    </button>
                                </div>
                            </form>

                            {{-- Assigned Hospitals --}}
                            <div class="flex-1 ml-12">
                                <h3 class="text-xl font-semibold text-g-dark mb-2">{{ Auth::user()->name }}</h3>
                                <p class="text-gray-600 mb-4">{{ Auth::user()->email }}</p>

                                <div class="flex justify-between items-center mb-2">
                                    <h4 class="text-2xl font-bold text-g-dark">Assigned Hospitals</h4>
                                    <button class="bg-g-dark text-white px-3 py-1 rounded hover:bg-[#296E5B]/90 transition">
                                        + Add Hospital
                                    </button>
                                </div>

                                <ul class="space-y-1 text-g-dark text-base">
                                    <li class="border-b border-gray-300 pb-1">Cebu Doctors Hospital</li>
                                    <li class="border-b border-gray-300 pb-1">VSMMC</li>
                                    <li>Velez</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Change Password Modal (hidden by default) --}}
    <div id="passwordModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-[400px]">
            <h2 class="text-xl font-bold mb-4">Change Password</h2>
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                @method('PATCH')

                <div class="mb-4">
                    <label for="current_password" class="block text-sm font-medium text-g-dark">Current Password</label>
                    <input type="password" id="current_password" name="current_password" required
                           class="mt-1 block w-full border border-g-dark rounded px-3 py-2 text-sm">
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-g-dark">New Password</label>
                    <input type="password" id="password" name="password" required
                           class="mt-1 block w-full border border-g-dark rounded px-3 py-2 text-sm">
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-g-dark">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                           class="mt-1 block w-full border border-g-dark rounded px-3 py-2 text-sm">
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button"
                            onclick="document.getElementById('passwordModal').classList.add('hidden')"
                            class="px-4 py-2 border rounded">Cancel</button>
                    <button type="submit"
                            class="bg-g-dark text-white px-4 py-2 rounded hover:bg-[#296E5B]/90">Update</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
