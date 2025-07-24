<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight bg-[#006341] p-4 rounded">
            {{ __('My Tee Times') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-[#006341]">Upcoming Tee Times</h1>
                <a href="{{ route('courses.index') }}" class="bg-green-600 text-white px-4 py-2 rounded">
                    + Create Tee Time
                </a>
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

                    <!-- Right: Action buttons -->
                    <div class="flex flex-col gap-2 items-end">
                        @if ($teeTime->participants->contains(auth()->user()))
                            <form method="POST" action="{{ route('tee-times.leave', $teeTime) }}">
                                @csrf
                                <button type="submit" class="bg-yellow-400 text-white px-4 py-2 rounded hover:bg-yellow-600">
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

                        @if(Auth::id() === $teeTime->user_id)
                            <form action="{{ route('tee-times.destroy', $teeTime) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this tee time?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                                    Cancel Tee Time
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
