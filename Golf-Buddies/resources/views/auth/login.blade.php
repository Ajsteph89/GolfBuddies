<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4 text-flag font-semibold" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="bg-white p-6 rounded shadow-md max-w-md mx-auto mt-8 border border-masters">
        @csrf

        <h2 class="text-2xl font-bold text-masters mb-6 text-center">Welcome Back</h2>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-masters" />
            <x-text-input id="email" class="block mt-1 w-full border-muted focus:ring-flag focus:border-flag" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-masters" />
            <x-text-input id="password" class="block mt-1 w-full border-muted focus:ring-flag focus:border-flag"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-muted text-masters shadow-sm focus:ring-flag" name="remember">
                <span class="ml-2 text-sm text-gray-700">{{ __('Remember me') }}</span>
            </label>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between mt-6">
            @if (Route::has('password.request'))
                <a class="text-sm text-flag hover:underline focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-flag" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <button type="submit" class="bg-flag text-masters px-4 py-2 rounded hover:bg-yellow-400 transition font-semibold">
                {{ __('Log in') }}
            </button>
        </div>
    </form>
</x-guest-layout>
