<x-app-layout>
    <div class="bg-gray-50 min-h-screen flex">
        {{-- Sidebar --}}
        @include('layouts.sidebar')

        {{-- Main Content --}}
        <div class="flex-1 ml-64 p-8">
            {{-- Header --}}
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-g-dark">Profile Information</h1>
                <p class="text-gray-600">Manage your account information and security</p>
            </div>

            <div class="flex gap-6">
                {{-- Left Column: Profile Info + Role + Buttons --}}
                <div class="w-1/2">
                    <div class="bg-white border border-gray-300 rounded-lg p-6">
                        {{-- Profile Header --}}
                        <div class="text-center mb-6">
                            <h2 class="font-semibold text-g-dark text-lg">{{ Auth::user()->name }}</h2>
                            <p class="text-gray-600">{{ Auth::user()->email }}</p>
                        </div>

                        {{-- Divider --}}
                        <div class="border-t border-gray-300 my-4"></div>

                        {{-- Form Fields --}}
                        <form method="POST" action="{{ route('profile.update') }}" id="profileForm">
                            @csrf
                            @method('PATCH')

                            <div class="space-y-6">
                                {{-- Full Name --}}
                                <div>
                                    <label for="name" class="block text-sm font-medium text-g-dark mb-2">Full Name</label>
                                    <input type="text" id="name" name="name"
                                           value="{{ old('name', Auth::user()->name) }}"
                                           class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-g-dark"
                                           required>
                                    @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>

                                {{-- Email --}}
                                <div>
                                    <label for="email" class="block text-sm font-medium text-g-dark mb-2">Email</label>
                                    <input type="email" id="email" name="email"
                                           value="{{ old('email', Auth::user()->email) }}"
                                           class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-g-dark"
                                           required>
                                    @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>

                                {{-- Role --}}
                                <div>
                                    <label class="block text-sm font-medium text-g-dark mb-2">Role</label>
                                    <div class="border border-gray-300 rounded px-3 py-2 text-sm bg-gray-50 text-g-dark">
                                        {{ Auth::user()->role ?? 'Oncologist' }}
                                    </div>
                                </div>

                                {{-- Specialization --}}
                                <div>
                                    <label class="block text-sm font-medium text-g-dark mb-2">Specialization</label>
                                    <div class="border border-gray-300 rounded px-3 py-2 text-sm bg-gray-50 text-g-dark">
                                        Oncology
                                    </div>
                                </div>

                                {{-- Divider --}}
                                <div class="border-t border-gray-300 my-4"></div>

                                {{-- Centered Buttons --}}
                                <div class="flex justify-center gap-3">
                                    <button type="submit" form="profileForm"
                                            class="bg-g-dark text-white px-6 py-2 rounded text-sm font-medium hover:bg-g-dark/90 transition">
                                        Update Profile
                                    </button>
                                    <button type="button"
                                            onclick="document.getElementById('passwordModal').classList.remove('hidden')"
                                            class="border border-gray-300 text-g-dark px-6 py-2 rounded text-sm font-medium hover:bg-gray-50 transition">
                                        Change Password
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Right Column: Assigned Hospitals --}}
                <div class="w-1/2">
                    <div class="bg-white border border-gray-300 rounded-lg p-6 h-full">
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-g-dark">Assigned Hospitals</h3>
                                <p class="text-gray-600 text-sm">Manage your hospital assignments</p>
                            </div>
                            <button id="addHospitalBtn" 
                                    class="bg-g-dark text-white px-4 py-2 rounded text-sm font-medium flex items-center gap-2 hover:bg-g-dark/90 transition">
                                <i class="fas fa-plus"></i> Add Hospital
                            </button>
                        </div>

                        {{-- Hospital Cards --}}
                        <div class="space-y-4 max-h-[500px] overflow-y-auto">
                            @forelse(Auth::user()->approvedHospitals as $hospital)
                                <x-cards :hospital="$hospital" />
                            @empty
                                <div class="text-center py-8 text-gray-500">
                                    <i class="fas fa-hospital text-3xl mb-3 opacity-50"></i>
                                    <p>No hospitals assigned yet</p>
                                </div>
                            @endforelse
                            
                            {{-- Add Hospital Card --}}
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 flex items-center justify-center cursor-pointer hover:bg-gray-50 transition"
                                 onclick="document.getElementById('addHospitalModal').classList.remove('hidden')">
                                <div class="text-center text-gray-500">
                                    <i class="fas fa-plus text-xl mb-2"></i>
                                    <p class="text-sm">Add Hospital</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Hospital Modal --}}
    <x-modals.form-modals id="addHospitalModal" :hospitals="$hospitals" />

    {{-- Change Password Modal --}}
    <div id="passwordModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md mx-4">
            <div class="p-6">
                <h2 class="text-lg font-semibold text-g-dark mb-4">Change Password</h2>
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    @method('PATCH')

                    <div class="space-y-4">
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-g-dark mb-1">Current Password</label>
                            <input type="password" id="current_password" name="current_password" required
                                   class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-g-dark">
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-g-dark mb-1">New Password</label>
                            <input type="password" id="password" name="password" required
                                   class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-g-dark">
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-g-dark mb-1">Confirm Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                   class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:border-g-dark">
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button"
                                onclick="document.getElementById('passwordModal').classList.add('hidden')"
                                class="px-4 py-2 border border-gray-300 rounded text-g-dark hover:bg-gray-50 transition">Cancel</button>
                        <button type="submit"
                                class="bg-g-dark text-white px-4 py-2 rounded hover:bg-g-dark/90 transition">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Hospital Modal Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const addHospitalBtn = document.getElementById('addHospitalBtn');
            const addHospitalModal = document.getElementById('addHospitalModal');
            const closeHospitalModal = document.getElementById('closeHospitalModal');
            const cancelHospital = document.getElementById('cancelHospital');
            const hospitalForm = document.getElementById('hospitalForm');
            
            // Show modal
            if (addHospitalBtn) {
                addHospitalBtn.addEventListener('click', function() {
                    addHospitalModal.classList.remove('hidden');
                });
            }
            
            // Hide modal
            function hideHospitalModal() {
                addHospitalModal.classList.add('hidden');
            }
            
            if (closeHospitalModal) {
                closeHospitalModal.addEventListener('click', hideHospitalModal);
            }
            
            if (cancelHospital) {
                cancelHospital.addEventListener('click', hideHospitalModal);
            }
            
            // Form submission
            if (hospitalForm) {
                hospitalForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const hospitalName = document.getElementById('hospitalName').value;
                    const hospitalAddress = document.getElementById('hospitalAddress').value;
                    const hospitalCity = document.getElementById('hospitalCity').value;
                    
                    console.log('Adding hospital:', { hospitalName, hospitalAddress, hospitalCity });
                    
                    hideHospitalModal();
                    
                    hospitalForm.reset();
                });
            }
            
            if (addHospitalModal) {
                addHospitalModal.addEventListener('click', function(e) {
                    if (e.target === addHospitalModal) {
                        hideHospitalModal();
                    }
                });
            }
        });
    </script>
</x-app-layout>