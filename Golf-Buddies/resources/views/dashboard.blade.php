<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight bg-[#006341] p-4 rounded">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-muted min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border border-masters overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6 text-gray-800 font-semibold text-lg">
                    <span class="text-flag">🏌️</span> {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
