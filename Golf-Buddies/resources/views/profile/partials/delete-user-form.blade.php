<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-green-900">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-green-700">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="bg-yellow-500 text-green-900 hover:bg-yellow-600 focus:ring-yellow-400"
    >
        {{ __('Delete Account') }}
    </x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 bg-green-50 rounded-lg">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-green-900">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-1 text-sm text-green-700">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only text-green-900" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4 border-green-400 focus:border-yellow-400 focus:ring-yellow-400"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-yellow-600" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button 
                    x-on:click="$dispatch('close')"
                    class="text-green-900 hover:text-yellow-600 focus:ring-yellow-400"
                >
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3 bg-yellow-500 text-green-900 hover:bg-yellow-600 focus:ring-yellow-400">
                    {{ __('Delete Account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
