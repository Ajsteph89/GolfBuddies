<section>
    <header>
        <h2 class="text-lg font-medium text-green-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-green-700">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6 bg-green-50 p-6 rounded-lg shadow">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" class="text-green-900" />
            <x-text-input 
                id="update_password_current_password" 
                name="current_password" 
                type="password" 
                class="mt-1 block w-full border-green-400 focus:border-yellow-400 focus:ring-yellow-400" 
                autocomplete="current-password" 
            />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-yellow-600" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" class="text-green-900" />
            <x-text-input 
                id="update_password_password" 
                name="password" 
                type="password" 
                class="mt-1 block w-full border-green-400 focus:border-yellow-400 focus:ring-yellow-400" 
                autocomplete="new-password" 
            />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-yellow-600" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" class="text-green-900" />
            <x-text-input 
                id="update_password_password_confirmation" 
                name="password_confirmation" 
                type="password" 
                class="mt-1 block w-full border-green-400 focus:border-yellow-400 focus:ring-yellow-400" 
                autocomplete="new-password" 
            />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-yellow-600" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="bg-yellow-500 text-green-900 hover:bg-yellow-600 focus:ring-yellow-400">
                {{ __('Save') }}
            </x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-700"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
