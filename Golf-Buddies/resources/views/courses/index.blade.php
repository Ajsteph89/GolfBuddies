<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight bg-[#006341] p-4 rounded">
            {{ __('Courses') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold mb-6 text-[#006341]">Find Golf Courses by ZIP Code</h1>

            <form method="GET" action="{{ route('courses.index') }}" class="mb-8 flex items-center space-x-3">
                <input 
                    type="text" 
                    name="zip" 
                    value="{{ old('zip', $zip ?? '') }}" 
                    placeholder="Enter ZIP code" 
                    required 
                    pattern="\d{5}"
                    title="Please enter a 5-digit ZIP code"
                    class="border-2 border-[#006341] p-2 rounded w-40 focus:outline-none focus:ring-2 focus:ring-[#FFD700]"
                />
                <button type="submit" class="bg-[#FFD700] text-[#006341] px-4 py-2 rounded font-semibold hover:bg-yellow-400 transition">
                    Search
                </button>
            </form>

            @if(!empty($courses))
                <h2 class="text-2xl font-semibold mb-4 text-[#006341]">Courses near {{ $zip }}:</h2>
                <ul class="space-y-4">
                    @foreach($courses as $course)
                        <li class="border border-[#006341] p-4 rounded shadow bg-green-50">
                            <strong class="text-lg text-[#006341]">{{ $course['course_name'] ?? 'Unknown Course' }}</strong><br />
                            @php
                                $loc = $course['location'] ?? [];
                            @endphp
                            <span class="text-gray-700">{{ $loc['address'] ?? 'Address not available' }}</span><br />
                            <span class="text-gray-600">{{ $loc['city'] ?? '' }}, {{ $loc['state'] ?? '' }} {{ $loc['postal_code'] ?? '' }}</span>
                        </li>
                    @endforeach
                </ul>
            @elseif(isset($zip))
                <p class="text-gray-500">No courses found near {{ $zip }}.</p>
            @endif
        </div>
    </div>
</x-app-layout>
