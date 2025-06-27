<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="bg-[#f9f8f3] dark:bg-[#1b1b18] p-6 rounded-lg shadow-md">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-[#1b1b18] dark:text-[#EDEDEC]" />
            <x-text-input id="name" class="block mt-1 w-full bg-white dark:bg-[#2e2e2a] text-[#1b1b18] dark:text-[#EDEDEC] border-[#cccccc] dark:border-[#3E3E3A]" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" class="text-[#1b1b18] dark:text-[#EDEDEC]" />
            <x-text-input id="email" class="block mt-1 w-full bg-white dark:bg-[#2e2e2a] text-[#1b1b18] dark:text-[#EDEDEC] border-[#cccccc] dark:border-[#3E3E3A]" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Username -->
        <div class="mt-4">
            <label for="username" class="text-[#1b1b18] dark:text-[#EDEDEC]">Username</label>
            <input id="username" class="block mt-1 w-full bg-white dark:bg-[#2e2e2a] text-[#1b1b18] dark:text-[#EDEDEC] border border-[#cccccc] dark:border-[#3E3E3A]" type="text" name="username" required />
        </div>

        <!-- Zipcode -->
        <div class="mt-4">
            <label for="zipcode" class="text-[#1b1b18] dark:text-[#EDEDEC]">Zipcode</label>
            <input id="zipcode" class="block mt-1 w-full bg-white dark:bg-[#2e2e2a] text-[#1b1b18] dark:text-[#EDEDEC] border border-[#cccccc] dark:border-[#3E3E3A]" type="text" name="zipcode" required />
        </div>

        <!-- Profile -->
        <div class="mt-4">
            <label for="profile" class="text-[#1b1b18] dark:text-[#EDEDEC]">Profile</label>
            <textarea id="profile" class="block mt-1 w-full bg-white dark:bg-[#2e2e2a] text-[#1b1b18] dark:text-[#EDEDEC] border border-[#cccccc] dark:border-[#3E3E3A]" name="profile" rows="3"></textarea>
        </div>

        <!-- Handicap -->
        <div class="mt-4">
            <label for="handicap" class="text-[#1b1b18] dark:text-[#EDEDEC]">Handicap</label>
            <input id="handicap" class="block mt-1 w-full bg-white dark:bg-[#2e2e2a] text-[#1b1b18] dark:text-[#EDEDEC] border border-[#cccccc] dark:border-[#3E3E3A]" type="number" name="handicap" min="0" step="0.1" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-[#1b1b18] dark:text-[#EDEDEC]" />
            <x-text-input id="password" class="block mt-1 w-full bg-white dark:bg-[#2e2e2a] text-[#1b1b18] dark:text-[#EDEDEC] border-[#cccccc] dark:border-[#3E3E3A]" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-[#1b1b18] dark:text-[#EDEDEC]" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full bg-white dark:bg-[#2e2e2a] text-[#1b1b18] dark:text-[#EDEDEC] border-[#cccccc] dark:border-[#3E3E3A]" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Footer Actions -->
        <div class="flex items-center justify-between mt-6">
            <a class="underline text-sm text-[#1b1b18] dark:text-[#EDEDEC] hover:text-[#007a33] dark:hover:text-[#fddc5c] transition" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="bg-[#007a33] hover:bg-[#005a24] text-white dark:bg-[#fddc5c] dark:text-[#1b1b18] dark:hover:bg-[#f1c40f] transition">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
