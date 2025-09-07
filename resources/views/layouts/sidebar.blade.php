<div class="sidebar w-64 h-screen bg-[#296E5B] text-[#296E5B] flex flex-col fixed">
    <!-- Profile Section -->
    <div class="profile flex flex-col items-center py-6 border-b border-white/20">
        <img src="{{ asset('images/profile-placeholder.png') }}" 
             alt="Profile" 
             class="w-16 h-16 rounded-full mb-2">
        <h2 class="text-lg font-semibold">DisMap</h2>
        <p class="text-sm text-gray-200">Superadmin</p>
    </div>

    <!-- Menu Section -->
    <div class="menu flex flex-col mt-4 space-y-1">
        <!-- Active Button -->
        <button class="flex items-center px-4 py-3 text-left w-full 
                       bg-[#B3FAD8] text-black rounded-r-full font-medium transition">
            <img src="{{ asset('images/dashboard.png') }}" alt="Dashboard" class="w-5 h-5 mr-3">
            Dashboard
        </button>

        <!-- Default Buttons -->
        <button class="flex items-center px-4 py-3 text-left w-full 
                       hover:bg-[#B3FAD8] hover:text-black rounded-r-full transition">
            <img src="{{ asset('images/admins.png') }}" alt="Admins" class="w-5 h-5 mr-3">
            Manage Admins
        </button>

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

        <!-- Logout Button (pushed to bottom) -->
        <button class="flex items-center px-4 py-3 text-left w-full 
                       hover:bg-[#B3FAD8] hover:text-black rounded-r-full transition mt-auto">
            <img src="{{ asset('images/logout.png') }}" alt="Logout" class="w-5 h-5 mr-3">
            Logout
        </button>
    </div>
</div>
