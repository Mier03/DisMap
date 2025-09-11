<x-guest-layout>
    <div class="max-w-md w-full bg-white rounded-lg p-8 mx-auto">
        <!-- Header Section -->
        <div class="text-left mb-3">
            <h2 class="text-2xl font-bold text-teal-700 mb-3">Welcome Back!</h2>
            <p class="text-sm text-teal-600/60">Sign in to access DisMap</p>
        </div>
        
        <!-- Session Status -->
        <x-auth-session-status class="mb-4 bg-green-100 text-green-700 px-4 py-3 rounded-lg" :status="session('status')" />
        
        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <!-- Email Address -->
            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" 
                    type="email" name="email" :value="old('email')" 
                    required autofocus autocomplete="email"
                    placeholder="Enter your email..." />
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            <!-- Password -->
            <div class="mb-4">
                <x-input-label for="password" :value="__('Password')" />
                <div class="relative">
                    <x-text-input id="password" class="block mt-1 w-full pr-10"
                        type="password" name="password" 
                        required autocomplete="current-password"
                        placeholder="Enter your password..." />
                    <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700" onclick="togglePassword()">
                        <!-- Eye with slash icon SVG -->
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" id="eye-icon">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center mb-5">
                <input id="remember_me" type="checkbox" name="remember" 
                    class="h-4 w-4 text-teal-600 focus:ring-teal-500 border-gray-300 rounded">
                <label for="remember_me" class="ml-2 block text-sm text-gray-700">Remember me</label>
            </div>

            <!-- Login Button -->
            <button type="submit" 
                class="w-full py-2 px-4 bg-teal-700 hover:bg-teal-800 text-white font-medium rounded-md transition duration-200">
                Sign In
            </button>

            <!-- Forgot Password & Sign Up Links -->
            <div class="mt-4 text-center space-y-2">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-teal-700 hover:text-teal-800 block hover:underline">
                        Forgot Password?
                    </a>
                @endif

                <div class="relative flex items-center">
                    <div class="flex-grow border-t border-gray-300"></div>
                </div>
                
                @if (Route::has('register'))
                    <div class="text-sm text-gray-600">
                        Don't have an account? 
                        <a href="{{ route('register') }}" class="font-medium text-teal-700 hover:text-teal-800 hover:underline">
                            Sign Up
                        </a>
                    </div>
                @endif
            </div>
        </form>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                // Change to eye icon (visible password)
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
            } else {
                passwordInput.type = 'password';
                // Change back to eye-slash icon (hidden password)
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />';
            }
        }
    </script>
</x-guest-layout>
