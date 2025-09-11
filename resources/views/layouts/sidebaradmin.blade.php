<div class="sidebar w-64 h-screen bg-[#296E5B] text-white flex flex-col justify-between fixed px-4 py-6">
    <!-- Profile Section -->
    <div class="flex items-center mb-6">
        <div class="w-16 h-16 bg-white rounded-[8px]"></div>
        <div class="ml-3">
            <h2 class="text-lg font-semibold">Dr. Dismap</h2>
            <p class="text-sm text-white/80">Oncologist</p>
        </div>
    </div>

    <!-- Menu Panels -->
    <div class="flex flex-col space-y-3">
        <!-- Dashboard -->
        <a href="{{ route('admin.home') }}"
           class="flex items-center w-full h-12 rounded-md px-3 transition
           @if(Request::routeIs('dashboard')) bg-[#B3FAD8] text-[#296E5B] @else bg-white text-[#296E5B] hover:bg-[#B3FAD8] @endif">
            <x-gmdi-dashboard-o class="w-5 h-5 mr-2"/>
            <span class="text-sm font-medium">Dashboard</span>
        </a>

        <!-- Manage Patients -->
        <a href="{{ route('admin.managepatients') }}"
           class="flex items-center w-full h-12 rounded-md px-3 transition
           @if(Request::routeIs('patients')) bg-[#B3FAD8] text-[#296E5B] @else bg-white text-[#296E5B] hover:bg-[#B3FAD8] @endif">
            <x-gmdi-people-alt-o class="w-5 h-5 mr-2"/>
            <span class="text-sm font-medium">Manage Patients</span>
        </a>

        <!-- Disease Records -->
        <a href="{{ route('admin.diseaserecords') }}"
           class="flex items-center w-full h-12 rounded-md px-3 transition
           @if(Request::routeIs('diseaserecords')) bg-[#B3FAD8] text-[#296E5B] @else bg-white text-[#296E5B] hover:bg-[#B3FAD8] @endif">
            <x-gmdi-description-o class="w-5 h-5 mr-2"/>
            <span class="text-sm font-medium">Disease Records</span>
        </a>

        <!-- Account Settings -->
        <a href="{{ route('admin.accountsettings') }}"
           class="flex items-center w-full h-12 rounded-md px-3 transition
           @if(Request::routeIs('settings')) bg-[#B3FAD8] text-[#296E5B] @else bg-white text-[#296E5B] hover:bg-[#B3FAD8] @endif">
            <x-gmdi-settings-o class="w-5 h-5 mr-2"/>
            <span class="text-sm font-medium">Account Settings</span>
        </a>

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
        <x-gmdi-monitor-heart class="w-6 h-6 mr-2"/>
        <div>
            <h3 class="text-sm font-semibold">DisMap</h3>
            <p class="text-xs">Disease Surveillance Map</p>
        </div>
    </div>
</div>
