<x-app-layout>
    @if (session('success'))
        <x-toast type="success" :message="session('success')" />
    @endif

    @if (session('error'))
        <x-toast type="error" :message="session('error')" />
    @endif

    <div class="bg-g-bg flex min-h-screen w-full">
        {{-- Sidebar --}}
        @include('layouts.sidebar')

        {{-- Main Content --}}
        <div class="ml-64 flex-1 py-12 px-6">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden">
                    <div class="p-6 bg-inherit text-gray-900">
                        
                        {{-- Header --}}
                        <x-page-header title="Profile Information" subtitle="Manage your account information and security" />



                            
                        <div class="bg-white border border-g-dark rounded-lg p-6 flex flex-col md:flex-row md:items-start ">
                        <!-- Profile Form -->
                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="w-full flex flex-col md:flex-row md:items-start">
                            @csrf
                            @method('PATCH')

                            @php
                                $profileImagePath = Auth::user()->profile_image;
                                $defaultImagePath = 'images/profiles/defaultprofile.jpg'; // Match the DB value exactly
                            @endphp

                            {{-- Profile Image --}}
                            <div class="flex-shrink-0 mr-6 mb-6 md:mb-0 ">
                                <img id="profileImage"
                                   src="{{ 
                                        $profileImagePath === $defaultImagePath
                                        ? asset($defaultImagePath)
                                        : asset('storage/' . $profileImagePath) 
                                    }}"
                                    alt="Profile"
                                    class="w-[300px] h-[300px] rounded-full object-cover border-4 border-white shadow-lg cursor-pointer hover:opacity-80 transition"
                                    onclick="document.getElementById('profileInput').click()">

                                <input type="file"
                                    id="profileInput"
                                    name="profile_image"
                                    accept="image/*"
                                    class="hidden"
                                    onchange="previewProfilePhoto(event)">
                            </div>

                            {{-- Profile Info Fields --}}
                            <div class="w-[346px] flex flex-col">
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
                                            onclick="openModal('passwordUpdateModal')"
                                            class="bg-g-dark text-white px-6 py-2 rounded hover:bg-[#296E5B]/90 transition">
                                        Change Password
                                    </button>
                                </div>
                            </div>
                        </form>
                        </div>

                        <!-- Assigned Hospitals - Horizontal Layout at Bottom -->
                        <div class="mt-8 bg-white border border-g-dark rounded-lg p-6">
                            <div class="flex justify-between items-center mb-6">
                                <div>
                                    <h4 class="text-2xl font-bold text-g-dark">Assigned Hospitals</h4>
                                    <p class="text-gray-600">Manage your hospital assignments</p>
                                </div>
                                <button onclick="openModal('addHospitalModal')" id="addHospitalBtn" class="bg-gradient-to-r from-[#296E5B] to-[#1e5a48] text-white px-4 py-2 rounded-lg flex items-center gap-2 shadow-md hover:from-[#1e5a48] hover:to-[#296E5B] hover:translate-y-[-2px] hover:shadow-lg transition-all">
                                    <i class="fas fa-plus"></i> Add Hospital
                                </button>
                            </div>

                            <!-- Horizontal Hospital List -->
                            <div class="overflow-hidden">
                                <div class="flex gap-4 overflow-x-auto pb-4 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                                    <div class="flex gap-4 overflow-x-auto pb-4 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                                        @foreach(Auth::user()->approvedHospitals as $hospital)
                                            {{-- PASS A VARIABLE TO ENABLE THE REMOVE BUTTON --}}
                                            <x-cards :hospital="$hospital" can-remove="true" />

                                            @if (true) {{-- $canRemove is always true here --}}
                                                <x-modal-popup
                                                    id="removeModal-{{ $hospital->id }}"
                                                    title="Remove Hospital"
                                                    message="Are you sure you want to remove {{ $hospital->name }} from your assignments?"
                                                    confirmText="Remove"
                                                    cancelText="Cancel"
                                                    :action="route('admin.hospitals.unassign', $hospital->id)"
                                                    method="DELETE">
                                                </x-modal-popup>
                                            @endif
                                        @endforeach
                                    
                                    <!-- Empty card for adding new hospitals -->
                                    <div class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-lg p-4 flex-shrink-0 w-64 flex items-center justify-center cursor-pointer hover:bg-gray-100 transition"
                                         onclick="openModal('addHospitalModal')">
                                        <div class="text-center text-gray-500">
                                            <i class="fas fa-plus-circle text-2xl mb-2"></i>
                                            <p>Add New Hospital</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-modals.form-modals id="addHospitalModal" :hospitals="$hospitals" />

    <script>
        // Hospital Modal Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const addHospitalBtn = document.getElementById('addHospitalBtn');
            const addHospitalModal = document.getElementById('addHospitalModal');
            const closeHospitalModal = document.getElementById('closeHospitalModal');
            const cancelHospital = document.getElementById('cancelHospital');
            const hospitalForm = document.getElementById('hospitalForm');
            
            // Show modal
            addHospitalBtn.addEventListener('click', function() {
                addHospitalModal.classList.remove('hidden');
            });
            
            // Hide modal
            function hideHospitalModal() {
                addHospitalModal.classList.add('hidden');
            }
            
            closeHospitalModal.addEventListener('click', hideHospitalModal);
            cancelHospital.addEventListener('click', hideHospitalModal);
            
            // Form submission
            hospitalForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const hospitalName = document.getElementById('hospitalName').value;
                const hospitalAddress = document.getElementById('hospitalAddress').value;
                const hospitalCity = document.getElementById('hospitalCity').value;
                
                // In a real application, you would send this data to the server
                console.log('Adding hospital:', { hospitalName, hospitalAddress, hospitalCity });
                
                // For demo purposes, just close the modal
                hideHospitalModal();
                
                // Reset form
                hospitalForm.reset();
            });
            
            // Close modal when clicking outside
            addHospitalModal.addEventListener('click', function(e) {
                if (e.target === addHospitalModal) {
                    hideHospitalModal();
                }
            });
        });

        function previewProfilePhoto(event) {
            const reader = new FileReader();
            reader.onload = function(){
                const output = document.getElementById('profileImage');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</x-app-layout>