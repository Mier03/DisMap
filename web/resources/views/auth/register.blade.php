<x-guest-layout>
    <div class>
        <!-- Title -->
        <h2 class="text-2xl font-bold text-left text-teal-700">Join DisMap</h2>
        <p class="text-sm text-teal-600/60 text-left mb-4">
            Register as a Hospital Admin to manage health data
        </p>

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf

            <!-- Full Name -->
            <div class="mb-3">
                <x-input-label for="name" :value="__('Full Name')" />
                <x-text-input id="name" class="block mt-1 w-full" 
                    type="text" name="name" :value="old('name')" 
                    required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Birthdate -->
            <div class="mb-3">
                <x-input-label for="birthdate" :value="__('Birthdate')" />
                <x-text-input id="birthdate" class="block mt-1 w-full" 
                    type="date" name="birthdate" :value="old('birthdate')" 
                    required autocomplete="birthdate" />
                <x-input-error :messages="$errors->get('birthdate')" class="mt-2" />
            </div>

            <!-- Hospital Name -->
            <div class="mb-3">
                <x-input-label for="hospital_id" :value="__('Hospital Name')" />
                    <x-dropdown-select id="hospital_id" name="hospital_id" required>
                        <option value="">-- Select Hospital --</option>
                        @foreach($hospitals as $hospital)
                            <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
                        @endforeach
                    </x-dropdown-select>
                <x-input-error :messages="$errors->get('hospital_name')" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="mb-3">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" 
                    type="email" name="email" :value="old('email')" 
                    required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Username -->
            <div class="mb-3">
                <x-input-label for="username" :value="__('Username')" />
                    <x-text-input id="username" class="block mt-1 w-full" 
                        type="text" name="username" :value="old('username')"  
                        required />
                <x-input-error :messages="$errors->get('username')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mb-3">
                <x-input-label for="password" :value="__('Password')" />
                <div class="relative">
                    <x-text-input id="password" class="block mt-1 w-full"
                        type="password" name="password"
                        required autocomplete="new-password" />

                    <button type="button"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700"
                        onclick="togglePassword('password', 'eye-password')">

                        <span id="eye-password" class="h-5 w-5">
                            @svg('gmdi-eye-hide', 'h-5 w-5')
                        </span>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mb-3">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                   <div class="relative">
                        <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password" name="password_confirmation"
                            required autocomplete="new-password" />

                        <button type="button"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700"
                            onclick="togglePassword('password_confirmation', 'eye-confirm')">

                            <span id="eye-confirm" class="h-5 w-5">
                                @svg('gmdi-eye-hide', 'h-5 w-5')
                            </span>
                        </button>
                    </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Upload Certification -->
            <div class="mb-3">
                <x-input-label for="certification" :value="__('Upload Certification')" />
                <input id="certification" 
                       class="block mt-1 w-full border border-gray-300 rounded-md p-2" 
                       type="file" name="certification" accept=".jpg,.jpeg,.png," reqiured>
                <x-input-error :messages="$errors->get('certification')" class="mt-2" />
            </div>

            <!-- Submit -->
            <div class="mt-4">
                <x-primary-button class=" justify-center w-full bg-teal-800   hover:bg-teal-800/70">
                    {{ __('Sign Up') }}
                </x-primary-button>
            </div>

            <!-- Sign In Link -->
            <div class="mt-4 text-center">
                <p class="text-sm text-gray-600">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="font-medium text-teal-700 hover:text-teal-800 hover:underline">
                        Sign In
                    </a>
                </p>
            </div>

            <!-- Note -->
            <p class="text-xs text-red-600 mt-4 text-center">
                Note: Your registration will be reviewed by a system administrator. 
                You will receive approval notification via email.
            </p>
        </form>
    </div>
    <script>
        function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);

        if (input.type === 'password') {
            input.type = 'text';
            icon.innerHTML = `@svg('gmdi-eye-show', 'h-5 w-5')`;
        } else {
            input.type = 'password';
            icon.innerHTML = `@svg('gmdi-eye-hide', 'h-5 w-5')`;
        }
    }
</script>
</x-guest-layout>
