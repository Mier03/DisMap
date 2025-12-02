@if (session('success'))
    <x-toast type="success" :message="session('success')" />
@endif

@if (session('error'))
    <x-toast type="error" :message="session('error')" />
@endif

<div class="sidebar w-64 h-screen bg-g-dark text-white flex flex-col justify-between fixed px-4 py-6">
    <!-- Profile Section -->
    <div class="flex items-center mb-6">
        <div class="flex items-center mb-6">
            <div class="w-16 h-16 bg-white rounded-[8px] flex items-center justify-center overflow-hidden">
                @php
                    $user = Auth::user();
                    $dbImagePath = $user->profile_image;
                    $defaultImagePath = 'images/profiles/defaultprofile.jpg'; 
                    
                    if ($dbImagePath === $defaultImagePath) {
                        $profileImage = $defaultImagePath;
                    } else {
                        $profileImage = 'storage/' . $dbImagePath;
                    }

                    // if file not exists in storage, use default
                    if (file_exists(public_path($profileImage))) {
                        $profileImage = asset($profileImage);
                    } else {
                        $profileImage = asset($defaultImagePath);
                    }
                @endphp
                
                <img src="{{ $profileImage }}" alt="Profile-{{ $dbImagePath }}" class="w-full h-full object-cover">
            </div>
            <div class="ml-3">
                <h2 class="text-lg font-semibold">
                    {{ $user->name ?? 'DisMap' }}
                </h2>
                <p class="text-sm text-white/80 capitalize">
                    {{ $user->user_type }}
                </p>
            </div>
        </div>
    </div>

    <!-- Menu Panels -->
    <div class="flex flex-col space-y-3">
        <!-- Shared Dashboard -->
        <a href="{{ route('dashboard') }}"
           class="group flex items-center w-full h-12 rounded-md px-3 transition-all duration-500 ease-out overflow-hidden relative
           {{ Request::routeIs('dashboard') ? 'bg-[#B3FAD8] text-g-dark shadow-lg' : 'bg-white text-g-dark' }}">
            <div class="absolute inset-0 bg-gradient-to-r from-[#B3FAD8] to-[#9AE8C8] transform -translate-x-full group-hover:translate-x-0 transition-transform duration-500 ease-out rounded-md"></div>
            @if(Request::routeIs('dashboard'))
            <div class="absolute left-0 top-1/2 transform -translate-y-1/2 w-1 h-8 bg-g-dark rounded-r-md"></div>
            @endif
            <div class="relative z-10 flex items-center w-full">
                <div class="shrink-0 [&>svg]:fill-g-dark [&>svg]:text-g-dark transition-transform duration-300 group-hover:scale-110">
                    <x-gmdi-dashboard-o class="w-5 h-5 mr-2" />
                </div>
                <span class="text-sm font-medium transition-all duration-300 group-hover:font-semibold">{{ Request::routeIs('dashboard') ? '• ' : '' }}Dashboard</span>
            </div>
        </a>
        
        <!-- Shared Disease Records -->
        <a href="{{ route('diseaserecords') }}"
           class="group flex items-center w-full h-12 rounded-md px-3 transition-all duration-500 ease-out overflow-hidden relative
           {{ Request::routeIs('diseaserecords') ? 'bg-[#B3FAD8] text-g-dark shadow-lg' : 'bg-white text-g-dark' }}">
            <div class="absolute inset-0 bg-gradient-to-r from-[#B3FAD8] to-[#9AE8C8] transform -translate-x-full group-hover:translate-x-0 transition-transform duration-500 ease-out rounded-md"></div>
            @if(Request::routeIs('diseaserecords'))
            <div class="absolute left-0 top-1/2 transform -translate-y-1/2 w-1 h-8 bg-g-dark rounded-r-md"></div>
            @endif
            <div class="relative z-10 flex items-center w-full">
                <div class="shrink-0 [&>svg]:fill-g-dark [&>svg]:text-g-dark transition-transform duration-300 group-hover:scale-110">
                    <x-gmdi-description-o class="w-5 h-5 mr-2" />
                </div>
                <span class="text-sm font-medium transition-all duration-300 group-hover:font-semibold">{{ Request::routeIs('diseaserecords') ? '• ' : '' }}Disease Records</span>
            </div>
        </a>

        @if(Auth::user()->user_type === 'Admin')
            <!-- Superadmin Links -->
            <a href="{{ route('superadmin.datarequest') }}"
               class="group flex items-center w-full h-12 rounded-md px-3 transition-all duration-500 ease-out overflow-hidden relative
               {{ Request::routeIs('superadmin.datarequest') ? 'bg-[#B3FAD8] text-g-dark shadow-lg' : 'bg-white text-g-dark' }}">
                <div class="absolute inset-0 bg-gradient-to-r from-[#B3FAD8] to-[#9AE8C8] transform -translate-x-full group-hover:translate-x-0 transition-transform duration-500 ease-out rounded-md"></div>
                @if(Request::routeIs('superadmin.datarequest'))
                <div class="absolute left-0 top-1/2 transform -translate-y-1/2 w-1 h-8 bg-g-dark rounded-r-md"></div>
                @endif
                <div class="relative z-10 flex items-center w-full">
                    <div class="shrink-0 [&>svg]:fill-g-dark [&>svg]:text-g-dark transition-transform duration-300 group-hover:scale-110">
                        <x-gmdi-folder-o class="w-5 h-5 mr-2" />
                    </div>
                    <span class="text-sm font-medium transition-all duration-300 group-hover:font-semibold">{{ Request::routeIs('superadmin.datarequest') ? '• ' : '' }}Data Requests</span>
                </div>
            </a>
            
            <a href="{{ route('superadmin.verify_admins') }}"
               class="group flex items-center w-full h-12 rounded-md px-3 transition-all duration-500 ease-out overflow-hidden relative
               {{ Request::routeIs('superadmin.verify_admins') ? 'bg-[#B3FAD8] text-g-dark shadow-lg' : 'bg-white text-g-dark' }}">
                <div class="absolute inset-0 bg-gradient-to-r from-[#B3FAD8] to-[#9AE8C8] transform -translate-x-full group-hover:translate-x-0 transition-transform duration-500 ease-out rounded-md"></div>
                @if(Request::routeIs('superadmin.verify_admins'))
                <div class="absolute left-0 top-1/2 transform -translate-y-1/2 w-1 h-8 bg-g-dark rounded-r-md"></div>
                @endif
                <div class="relative z-10 flex items-center w-full">
                    <div class="shrink-0 [&>svg]:fill-g-dark [&>svg]:text-g-dark transition-transform duration-300 group-hover:scale-110">
                        <x-gmdi-admin-panel-settings-o class="w-5 h-5 mr-2" />
                    </div>
                    <span class="text-sm font-medium transition-all duration-300 group-hover:font-semibold">{{ Request::routeIs('superadmin.verify_admins') ? '• ' : '' }}Manage Admins</span>
                </div>
            </a>

        @else
            <!-- Admin (Doctor) Links -->
            <a href="{{ route('admin.managepatients') }}"
               class="group flex items-center w-full h-12 rounded-md px-3 transition-all duration-500 ease-out overflow-hidden relative
               {{ Request::routeIs('admin.managepatients') ? 'bg-[#B3FAD8] text-g-dark shadow-lg' : 'bg-white text-g-dark' }}">
                <div class="absolute inset-0 bg-gradient-to-r from-[#B3FAD8] to-[#9AE8C8] transform -translate-x-full group-hover:translate-x-0 transition-transform duration-500 ease-out rounded-md"></div>
                @if(Request::routeIs('admin.managepatients'))
                <div class="absolute left-0 top-1/2 transform -translate-y-1/2 w-1 h-8 bg-g-dark rounded-r-md"></div>
                @endif
                <div class="relative z-10 flex items-center w-full">
                    <div class="shrink-0 [&>svg]:fill-g-dark [&>svg]:text-g-dark transition-transform duration-300 group-hover:scale-110">
                        <x-gmdi-people-alt-o class="w-5 h-5 mr-2" />
                    </div>
                    <span class="text-sm font-medium transition-all duration-300 group-hover:font-semibold">{{ Request::routeIs('admin.managepatients') ? '• ' : '' }}Manage Patients</span>
                </div>
            </a>

            <a href="{{ route('admin.accountsettings') }}"
               class="group flex items-center w-full h-12 rounded-md px-3 transition-all duration-500 ease-out overflow-hidden relative
                {{ Request::routeIs('admin.accountsettings') ? 'bg-[#B3FAD8] text-g-dark shadow-lg' : 'bg-white text-g-dark' }}">
                <div class="absolute inset-0 bg-gradient-to-r from-[#B3FAD8] to-[#9AE8C8] transform -translate-x-full group-hover:translate-x-0 transition-transform duration-500 ease-out rounded-md"></div>
                @if(Request::routeIs('admin.accountsettings'))
                <div class="absolute left-0 top-1/2 transform -translate-y-1/2 w-1 h-8 bg-g-dark rounded-r-md"></div>
                @endif
                <div class="relative z-10 flex items-center w-full">
                    <div class="shrink-0 [&>svg]:fill-g-dark [&>svg]:text-g-dark transition-transform duration-300 group-hover:scale-110">
                        <x-gmdi-settings-o class="w-5 h-5 mr-2" />
                    </div>
                    <span class="text-sm font-medium transition-all duration-300 group-hover:font-semibold">{{ Request::routeIs('admin.accountsettings') ? '• ' : '' }}Account Settings</span>
                </div>
            </a>
        @endif

        <!-- Logout -->
        <button type="button" onclick="openModal('logoutConfirm')"
            class="group flex items-center w-full h-12 rounded-md px-3 transition-all duration-500 ease-out overflow-hidden relative bg-white text-g-dark">
            <!-- Animated background that slides from left -->
            <div class="absolute inset-0 bg-gradient-to-r from-[#B3FAD8] to-[#9AE8C8] transform -translate-x-full group-hover:translate-x-0 transition-transform duration-500 ease-out rounded-md"></div>
            <!-- Content -->
            <div class="relative z-10 flex items-center w-full">
                <div class="shrink-0 [&>svg]:fill-g-dark [&>svg]:text-g-dark transition-transform duration-300 group-hover:scale-110">
                    <x-gmdi-logout-o class="w-5 h-5 mr-2" />
                </div>
                <span class="text-sm font-medium transition-all duration-300 group-hover:font-semibold">Logout</span>
            </div>
        </button>
    </div>

    <!-- Branding Bottom -->
    <div class="flex items-center mt-8 ml-2 transition-all duration-300 ease-in-out hover:scale-[1.02] group/brand">
        <div class="shrink-0 [&>svg]:fill-white [&>svg]:text-white transition-transform duration-300 group-hover/brand:scale-110">
            <x-gmdi-public-o class="w-6 h-6 mr-2" />
        </div>
        <div>
            <h3 class="text-sm font-semibold transition-all duration-300 group-hover/brand:translate-x-1">DisMap</h3>
            <p class="text-xs transition-all duration-300 group-hover/brand:translate-x-1">Disease Surveillance Map</p>
        </div>
    </div>

</div>