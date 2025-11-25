<x-guest-layout>
    <div class="max-w-md w-full bg-white rounded-lg p-8 mx-auto animate-fadeInUp" style="animation-delay: 0.1s">
        <!-- Header Section -->
        <div class="text-left mb-3 animate-fadeInUp" style="animation-delay: 0.2s">
            <h2 class="text-2xl font-bold text-teal-700 mb-3">Welcome Back!</h2>
            <p class="text-sm text-teal-600/60">Sign in to access DisMap</p>
        </div>
        
        <!-- Session Status -->
        <x-auth-session-status class="mb-4 bg-green-100 text-green-700 px-4 py-3 rounded-lg animate-fadeInUp" :status="session('status')" style="animation-delay: 0.3s" />
        
        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf
            
            <!-- Email Address -->
            <div class="animate-fadeInUp" style="animation-delay: 0.4s">
                <x-input-label for="login" :value="__('Email or Username')" />
                <x-text-input id="email" class="block mt-1 w-full transition-all duration-300 ease-in-out hover:shadow-md focus:shadow-lg" 
                    type="text" name="login" :value="old('login')" 
                    required autofocus autocomplete="email"
                    placeholder="Enter your email or username..." />
                <x-input-error :messages="$errors->get('login')" class="mt-1" />
            </div>

            <!-- Password -->
            <div class="animate-fadeInUp" style="animation-delay: 0.5s">
                <x-input-label for="password" :value="__('Password')" />
                <div class="relative">
                    <x-text-input id="password" class="block mt-1 w-full pr-10 transition-all duration-300 ease-in-out hover:shadow-md focus:shadow-lg"
                        type="password" name="password" 
                        required autocomplete="current-password"
                        placeholder="Enter your password..." />
                    <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-teal-600 transition-colors duration-200" onclick="togglePassword()">
                        <span id="eye-icon" class="h-5 w-5 transition-transform duration-200 hover:scale-110">
                            @svg('gmdi-eye-hide', 'h-5 w-5')
                        </span>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center animate-fadeInUp" style="animation-delay: 0.6s">
                <input id="remember_me" type="checkbox" name="remember" 
                    class="h-4 w-4 text-teal-600 focus:ring-teal-500 border-gray-300 rounded transition-all duration-200 ease-in-out hover:scale-110">
                <label for="remember_me" class="ml-2 block text-sm text-gray-700 transition-colors duration-200 hover:text-gray-900">Remember me</label>
            </div>

            <!-- Login Button -->
            <div class="animate-fadeInUp" style="animation-delay: 0.7s">
                <x-primary-button type="submit" class="justify-center w-full bg-teal-800 hover:bg-teal-800/70 transition-all duration-300 ease-in-out transform hover:-translate-y-0.5 hover:shadow-lg active:translate-y-0">
                    Sign In
                </x-primary-button>
            </div>

            <!-- Forgot Password & Sign Up Links -->
            <div class="mt-4 text-center space-y-2 animate-fadeInUp" style="animation-delay: 0.8s">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-teal-700 hover:text-teal-800 block hover:underline transition-all duration-200 ease-in-out transform hover:translate-x-1">
                        Forgot Password?
                    </a>
                @endif

                <div class="relative flex items-center">
                    <div class="flex-grow border-t border-gray-300"></div>
                </div>
                
                @if (Route::has('register'))
                    <div class="text-sm text-gray-600 transition-all duration-300 ease-in-out hover:text-gray-800">
                        Don't have an account? 
                        <a href="{{ route('register') }}" class="font-medium text-teal-700 hover:text-teal-800 hover:underline transition-all duration-200 ease-in-out transform hover:translate-x-1">
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
            
            // Add click animation
            eyeIcon.classList.add('scale-90');
            setTimeout(() => eyeIcon.classList.remove('scale-90'), 150);
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `@svg('gmdi-eye-show', 'h-5 w-5')`;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `@svg('gmdi-eye-hide', 'h-5 w-5')`;
            }
        }
    </script>
</x-guest-layout>