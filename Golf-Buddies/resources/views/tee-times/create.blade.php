<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight bg-[#006341] p-4 rounded">
            {{ __('Create Tee Time') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-white">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold mb-6 text-[#006341]">New Tee Time</h1>

            <form method="POST" action="{{ route('tee-times.store') }}">
                @csrf

                <div class="mb-4">
                    <label for="course_name" class="block font-medium text-gray-700">Course Name</label>
                    <input type="text" name="course_name" id="course_name"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        value="{{ old('course_name', $course ?? '') }}" required>
                    <input type="hidden" name="postal_code" value="{{ request('postal_code') }}">
                    <input type="hidden" name="latitude" value="{{ request('latitude') }}">
                    <input type="hidden" name="longitude" value="{{ request('longitude') }}">
                </div>

                <div class="mb-4">
                    <label for="scheduled_at" class="block font-medium text-gray-700">Date & Time</label>
                    <input type="datetime-local" name="scheduled_at" id="scheduled_at" required
                    class="w-full border rounded p-2 mt-1"
                    min="{{ now()->format('Y-m-d\TH:i') }}" />
                </div>

                <div class="mb-4">
                    <label for="max_players" class="block font-medium text-gray-700">Max Players (optional)</label>
                    <input type="number" name="max_players" id="max_players"
                        class="w-full border rounded p-2 mt-1" min="1" max="4" value="{{ old('player_count', 1) }}" />
                </div>

                <div class="mb-4">
                    <label for="notes" class="block font-medium text-gray-700">Notes</label>
                    <textarea name="notes" id="notes" rows="3"
                        class="w-full border rounded p-2 mt-1"></textarea>
                </div>

                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">
                    Create Tee Time
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
