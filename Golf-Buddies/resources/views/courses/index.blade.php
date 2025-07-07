<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight bg-[#006341] p-4 rounded">
            {{ __('Courses') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold mb-6 text-[#006341]">Find Golf Courses by ZIP Code</h1>

            <form method="GET" action="{{ route('courses.index') }}" class="mb-4 flex gap-2">
                <input type="text" name="zip" placeholder="Enter ZIP code" required class="border p-2 rounded w-1/3" />
                <button type="submit" class="bg-[#006341] hover:bg-[#004d33] text-white px-4 py-2 rounded">
                    Search
                </button>
            </form>

            @if(!empty($courses))
                <h2 class="text-lg font-semibold mb-4">Courses near {{ $zip }}:</h2>
                <ul class="space-y-4">
                    @foreach($courses as $c)
                        <li class="border p-4 rounded shadow bg-green-50">
                        <h3 class="text-xl font-bold text-[#006341]">{{ $c['club_name'] }}</h3>
                        
                            <div><strong>Membership:</strong> {{ $c['club_membership'] }}</div>
                        <div><strong>Holes:</strong> {{ $c['number_of_holes'] }}</div>
                        
                        <div><strong>Driving Range:</strong> {{ $c['driving_range'] ? 'Yes' : 'No' }}</div>
                        
                        <div>
                            <strong>Address:</strong> {{ $c['address'] }},
                            {{ $c['city'] }}, {{ $c['state'] }} {{ $c['postal_code'] }}
                        </div>

                        <div><strong>Phone:</strong> {{ $c['phone'] }}</div>

                        @if(!empty($c['website']))
                            <div>
                                <strong>Website:</strong>
                                <a href="{{ $c['website'] }}" target="_blank" class="text-blue-600 underline">
                                    {{ $c['website'] }}
                                </a>
                            </div>
                        @endif


                    </li>
                    @endforeach
                </ul>
            @elseif(isset($zip))
                <p>No golf courses found near <strong>{{ $zip }}</strong>.</p>
            @endif
        </div>
    </div>
</x-app-layout>
