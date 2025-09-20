<div class="sidebar w-64 h-screen bg-[#296E5B] text-white flex flex-col justify-between fixed px-4 py-6">
    <!-- Profile Section -->
    <div class="flex items-center mb-6">
        <div class="w-16 h-16 bg-white rounded-[8px] flex items-center justify-center overflow-hidden">
            <img src="{{ asset('images/profile-placeholder.png') }}" alt="Profile" class="w-full h-full object-cover">
        </div>
        <div class="ml-3">
            <h2 class="text-lg font-semibold">
                {{ Auth::user()->name ?? 'DisMap' }}
            </h2>
            <p class="text-sm text-white/80 capitalize">
                {{ Auth::user()->user_type }}
            </p>
        </div>
    </div>

    <!-- Menu Panels -->
    <div class="flex flex-col space-y-3">
    <!-- Dashboard -->
    <a href="{{ Auth::user()->user_type === 'Admin' ? route('superadmin.dashboard') : route('admin.dashboard') }}"
       class="flex items-center w-full h-12 rounded-md px-3 transition
       {{ Request::routeIs(Auth::user()->user_type === 'Admin' ? 'superadmin.dashboard' : 'admin.dashboard') 
      ? 'bg-[#B3FAD8] text-[#296E5B]' 
      : 'bg-white text-[#296E5B] hover:bg-[#B3FAD8]' }}">
            <x-gmdi-dashboard-o class="w-5 h-5 mr-2"/>
            <span class="text-sm font-medium">Dashboard</span>
        </a>

        @if(Auth::user()->user_type === 'Admin')
            <!-- Superadmin Links -->
            <a href="{{ route('superadmin.verify_admins') }}"
               class="flex items-center w-full h-12 rounded-md px-3 transition
               {{ Request::routeIs('superadmin.verify_admins') ? 'bg-[#B3FAD8] text-[#296E5B]' : 'bg-white text-[#296E5B] hover:bg-[#B3FAD8]' }}">
                <x-gmdi-admin-panel-settings-o class="w-5 h-5 mr-2"/>
                <span class="text-sm font-medium">Manage Admins</span>
            </a>

            <a href="{{ route('superadmin.datarequest') }}"
               class="flex items-center w-full h-12 rounded-md px-3 transition
               {{ Request::routeIs('superadmin.datarequest') ? 'bg-[#B3FAD8] text-[#296E5B]' : 'bg-white text-[#296E5B] hover:bg-[#B3FAD8]' }}">
                <x-gmdi-folder-o class="w-5 h-5 mr-2"/>
                <span class="text-sm font-medium">Data Requests</span>
            </a>

            <a href="{{ route('superadmin.diseaserecords') }}"
               class="flex items-center w-full h-12 rounded-md px-3 transition
               {{ Request::routeIs('superadmin.diseaserecords') ? 'bg-[#B3FAD8] text-[#296E5B]' : 'bg-white text-[#296E5B] hover:bg-[#B3FAD8]' }}">
                <x-gmdi-description-o class="w-5 h-5 mr-2"/>
                <span class="text-sm font-medium">Disease Records</span>
            </a>
        @else
            <!-- Admin (Doctor) Links -->
            <a href="{{ route('admin.managepatients') }}"
               class="flex items-center w-full h-12 rounded-md px-3 transition
               {{ Request::routeIs('admin.managepatients') ? 'bg-[#B3FAD8] text-[#296E5B]' : 'bg-white text-[#296E5B] hover:bg-[#B3FAD8]' }}">
                <x-gmdi-people-alt-o class="w-5 h-5 mr-2"/>
                <span class="text-sm font-medium">Manage Patients</span>
            </a>

            <a href="{{ route('admin.diseaserecords') }}"
               class="flex items-center w-full h-12 rounded-md px-3 transition
                {{ Request::routeIs('admin.diseaserecords') ? 'bg-[#B3FAD8] text-[#296E5B]' : 'bg-white text-[#296E5B] hover:bg-[#B3FAD8]' }}">
                <x-gmdi-description-o class="w-5 h-5 mr-2"/>
                <span class="text-sm font-medium">Disease Records</span>
            </a>

            <a href="{{ route('admin.accountsettings') }}"
               class="flex items-center w-full h-12 rounded-md px-3 transition
                {{ Request::routeIs('admin.accountsettings') ? 'bg-[#B3FAD8] text-[#296E5B]' : 'bg-white text-[#296E5B] hover:bg-[#B3FAD8]' }}">
                <x-gmdi-settings-o class="w-5 h-5 mr-2"/>
                <span class="text-sm font-medium">Account Settings</span>
            </a>
        @endif

        <!-- Logout -->
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                    class="flex items-center w-full h-12 rounded-md px-3 transition
                    bg-white text-[#296E5B] hover:bg-[#B3FAD8]">
                <x-gmdi-logout-o class="w-5 h-5 mr-2"/>
                <span class="text-sm font-medium">Logout</span>
            </button>
        </form>
    </div>

    <!-- Branding Bottom -->
    <div class="flex items-center mt-8 ml-2">
        <x-gmdi-public-o class="w-6 h-6 mr-2"/>
        <div>
            <h3 class="text-sm font-semibold">DisMap</h3>
            <p class="text-xs">Disease Surveillance Map</p>
        </div>
    </div>
</div>
