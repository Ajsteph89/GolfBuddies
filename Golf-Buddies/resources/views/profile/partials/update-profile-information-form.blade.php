<section>
    <header>
        <h2 class="text-lg font-medium text-green-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-green-700">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6 bg-green-50 p-6 rounded-lg shadow">
        @csrf
        @method('patch')
        <div>
            <x-input-label for="username" :value="__('Username')" class="text-green-900" />
            <x-text-input 
                id="username" 
                name="username" 
                type="text" 
                class="mt-1 block w-full border-green-400 focus:border-yellow-400 focus:ring-yellow-400" 
                :value="old('username', $user->username)" 
                required 
                autocomplete="username" 
            />
            <x-input-error class="mt-2 text-yellow-600" :messages="$errors->get('username')" />
        </div>

        <div>
            <x-input-label for="name" :value="__('Name')" class="text-green-900" />
            <x-text-input 
                id="name" 
                name="name" 
                type="text" 
                class="mt-1 block w-full border-green-400 focus:border-yellow-400 focus:ring-yellow-400" 
                :value="old('name', $user->name)" 
                required 
                autofocus 
                autocomplete="name" 
            />
            <x-input-error class="mt-2 text-yellow-600" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" class="text-green-900" />
            <x-text-input 
                id="email" 
                name="email" 
                type="email" 
                class="mt-1 block w-full border-green-400 focus:border-yellow-400 focus:ring-yellow-400" 
                :value="old('email', $user->email)" 
                required 
                autocomplete="username" 
            />
            <x-input-error class="mt-2 text-yellow-600" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-green-900">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-yellow-600 hover:text-yellow-800 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-400">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-700">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="bg-yellow-500 text-green-900 hover:bg-yellow-600 focus:ring-yellow-400">
                {{ __('Save') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
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
