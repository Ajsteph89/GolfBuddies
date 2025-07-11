<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight bg-[#006341] p-4 rounded">
            {{ __('Joinable Tee Times') }}
        </h2>
    </x-slot>
    
    <div class="bg-white p-4">
        <form method="GET" action="{{ route('tee-times.joinable') }}" class="flex items-center gap-4">
            <label for="filter" class="text-green-900 font-medium">Filter:</label>
            <select name="filter" id="filter" class="w-40 border-green-400 rounded p-2 focus:border-yellow-400 focus:ring-yellow-400">
                <option value="">All</option>
                <option value="nearby" {{ request('filter') === 'nearby' ? 'selected' : '' }}>Nearby</option>
            </select>
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Apply
            </button>
        </form>
    </div>

    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-[#006341]">Upcoming Tee Times</h1>
            </div>

            @foreach ($teeTimes as $teeTime)
                <div class="border p-4 mb-4 rounded shadow bg-green-50 flex justify-between items-center">
                    <!-- Left: Tee time info -->
                    <div>
                        <h2 class="text-xl font-semibold">{{ $teeTime->course_name }}</h2>
                        <p><strong>Scheduled:</strong> {{ \Carbon\Carbon::parse($teeTime->scheduled_at)->format('M d, Y h:i A') }}</p>
                        <p><strong>Organizer:</strong> {{ $teeTime->creator->username }}</p>
                        <p><strong>Notes:</strong> {{ $teeTime->notes ?? 'N/A' }}</p>
                        <p><strong>Players:</strong> {{ $teeTime->participants->count() }}{{ $teeTime->max_players ? ' / ' . $teeTime->max_players : '' }}</p>
                        <ul class="text-sm text-gray-700 list-disc list-inside">
                            @foreach ($teeTime->participants as $participant)
                                <li>{{ $participant->username }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Right: Join/Leave/Full -->
                    <div class="flex flex-col gap-2 items-end">
                        @if ($teeTime->participants->contains(auth()->user()))
                            <form method="POST" action="{{ route('tee-times.leave', $teeTime) }}">
                                @csrf
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                                    Leave Tee Time
                                </button>
                            </form>
                        @elseif ($teeTime->participants->count() < 4)
                            <form method="POST" action="{{ route('tee-times.join', $teeTime) }}">
                                @csrf
                                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-yellow-400">
                                    Join Tee Time
                                </button>
                            </form>
                        @else
                            <span class="text-gray-500">Full</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
