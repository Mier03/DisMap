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

            <!-- Hospital Name -->
            <div class="mb-3">
                <x-input-label for="hospital_name" :value="__('Hospital Name')" />
                    <x-dropdown-select id="hospital_name" name="hospital_name"  
                         required>
                        <option value="">-- Select Hospital --</option>
                        <option value="St. Luke’s Medical Center">St. Luke’s Medical Center</option>
                        <option value="Chong Hua Hospital">Chong Hua Hospital</option>
                        <option value="Cebu Doctors University Hospital">Cebu Doctors University Hospital</option>
                        <option value="Perpetual Succour Hospital">Perpetual Succour Hospital</option>
                        <option value="Vicente Sotto Memorial Medical Center">Vicente Sotto Memorial Medical Center</option>
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
                <x-text-input id="password" class="block mt-1 w-full"
                    type="password" name="password"
                    required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mb-3">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                    type="password" name="password_confirmation" 
                    required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Upload Certification -->
            <div class="mb-3">
                <x-input-label for="certification" :value="__('Upload Certification')" />
                <input id="certification" 
                       class="block mt-1 w-full border border-gray-300 rounded-md p-2" 
                       type="file" name="certification" accept=".jpg,.jpeg,.png,.pdf" reqiured>
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
</x-guest-layout>
