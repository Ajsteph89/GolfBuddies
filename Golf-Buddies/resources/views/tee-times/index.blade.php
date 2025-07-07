<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight bg-[#006341] p-4 rounded">
            {{ __('Tee Times') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-[#006341]">Upcoming Tee Times</h1>
                <a href="{{ route('tee-times.create') }}" class="bg-green-600 text-white px-4 py-2 rounded">
                    + Create Tee Time
                </a>
            </div>

            @foreach ($teeTimes as $teeTime)
                <div class="border p-4 mb-4 rounded shadow bg-green-50">
                    <h2 class="text-xl font-semibold">{{ $teeTime->course_name }}</h2>
                    <p><strong>Scheduled:</strong> {{ \Carbon\Carbon::parse($teeTime->scheduled_at)->format('M d, Y h:i A') }}</p>
                    <p><strong>Organizer:</strong> {{ $teeTime->creator->name }}</p>
                    <p><strong>Notes:</strong> {{ $teeTime->notes ?? 'N/A' }}</p>
                    <p><strong>Players:</strong> {{ $teeTime->participants->count() }}{{ $teeTime->max_players ? ' / ' . $teeTime->max_players : '' }}</p>

                    @if (!$teeTime->participants->contains(auth()->id()))
                        <form method="POST" action="{{ route('tee-times.join', $teeTime) }}">
                            @csrf
                            <button class="mt-2 bg-blue-600 text-white px-3 py-1 rounded">Join Tee Time</button>
                        </form>
                    @else
                        <p class="text-green-700 mt-2 font-semibold">You’ve joined this tee time!</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
