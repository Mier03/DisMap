<div class="sidebar w-64 h-screen bg-[#296E5B] text-[#fcfcfc] flex flex-col fixed">
    <div class="profile flex flex-col items-center py-6 border-b border-white/20">
        <img src="{{ asset('images/profile-placeholder.png') }}"
             alt="Profile"
             class="w-16 h-16 rounded-full mb-2">
        <h2 class="text-lg font-semibold">DisMap</h2>
        <p class="text-sm text-gray-200">Superadmin</p>
    </div>

    <div class="menu flex flex-col mt-4 space-y-1">
        <a href="{{ route('dashboard') }}"
           class="flex items-center px-4 py-3 text-left w-full rounded-r-full transition 
                @if(Request::routeIs('dashboard')) bg-[#B3FAD8] text-black font-medium @else hover:bg-[#B3FAD8] hover:text-black @endif">
            <img src="{{ asset('images/dashboard.png') }}" alt="Dashboard" class="w-5 h-5 mr-3">
            Dashboard
        </a>

        <a href="{{ route('verify_admins') }}"
           class="flex items-center px-4 py-3 text-left w-full rounded-r-full transition
                @if(Request::routeIs('verify_admins')) bg-[#B3FAD8] text-black font-medium @else hover:bg-[#B3FAD8] hover:text-black @endif">
            <img src="{{ asset('images/admins.png') }}" alt="Admins" class="w-5 h-5 mr-3">
            Manage Admins
        </a>

        <button class="flex items-center px-4 py-3 text-left w-full
                       hover:bg-[#B3FAD8] hover:text-black rounded-r-full transition">
            <img src="{{ asset('images/data.png') }}" alt="Data Requests" class="w-5 h-5 mr-3">
            Data Requests
        </button>

        <button class="flex items-center px-4 py-3 text-left w-full
                       hover:bg-[#B3FAD8] hover:text-black rounded-r-full transition">
            <img src="{{ asset('images/records.png') }}" alt="Disease Records" class="w-5 h-5 mr-3">
            Disease Records
        </button>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                    class="flex items-center px-4 py-3 text-left w-full
                           hover:bg-[#B3FAD8] hover:text-black rounded-r-full transition mt-auto">
                <img src="{{ asset('images/logout.png') }}" alt="Logout" class="w-5 h-5 mr-3">
                Logout
            </button>
        </form>
    </div>
</div>