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

                        {{-- Profile Card --}}
                        <div class="bg-white border border-g-dark rounded-lg p-6 flex flex-col md:flex-row md:items-start relative">
                            
                            {{-- Profile Image --}}
                            <div class="flex-shrink-0 mb-6 md:mb-0 md:mr-6">
                                <img src="{{ asset('images/profile-placeholder.png') }}" alt="Profile"
                                    class="w-40 h-40 rounded-full object-cover">
                            </div>

                            {{-- Info Section --}}
                            <div class="flex-1">
                                {{-- Name & Email --}}
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h3 class="text-2xl font-semibold text-g-dark">Jessica Kim</h3>
                                        <p class="text-gray-600">jessica.kim@gmail.com</p>
                                    </div>
                                    <button class="bg-g-dark text-white px-4 py-2 rounded-lg hover:bg-[#296E5B]/90 transition">
                                        Change Password
                                    </button>
                                </div>

                                {{-- Form Fields --}}
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                    <div>
                                        <label class="block text-sm font-medium text-g-dark">Full Name</label>
                                        <input type="text" value="Jessica Kim"
                                            class="w-full border border-g-dark rounded px-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#296E5B]">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-g-dark">Email</label>
                                        <input type="email" value="jessica.kim@gmail.com"
                                            class="w-full border border-g-dark rounded px-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#296E5B]">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-g-dark">Username</label>
                                        <input type="text" value="jessica.kim"
                                            class="w-full border border-g-dark rounded px-3 py-2 focus:outline-none focus:ring-1 focus:ring-[#296E5B]">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-g-dark">Role</label>
                                        <div class="flex items-center mt-2">
                                            <input type="checkbox" checked class="mr-2">
                                            <span>Doctor</span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Assigned Hospitals --}}
                                <div class="mb-4">
                                    <div class="flex justify-between items-center mb-2">
                                        <h4 class="text-lg font-semibold text-g-dark">Assigned Hospitals</h4>
                                        <button class="bg-g-dark text-white px-3 py-1 rounded hover:bg-[#296E5B]/90 transition">
                                            + Add Hospital
                                        </button>
                                    </div>
                                    <ul class="space-y-1 text-g-dark">
                                        <li class="border-b border-gray-300 pb-1">Cebu Doctors Hospital</li>
                                        <li class="border-b border-gray-300 pb-1">VSMMC</li>
                                        <li>Velez</li>
                                    </ul>
                                </div>

                                {{-- Update Button --}}
                                <div>
                                    <button class="bg-g-dark text-white px-6 py-2 rounded hover:bg-[#296E5B]/90 transition">
                                        Update Profile
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
