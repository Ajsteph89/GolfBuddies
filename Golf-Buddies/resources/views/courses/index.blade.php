<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Courses') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold mb-4">Find Golf Courses by ZIP Code</h1>

            <form method="GET" action="{{ route('courses.index') }}" class="mb-6 flex items-center space-x-2">
                <input 
                    type="text" 
                    name="zip" 
                    value="{{ old('zip', $zip ?? '') }}" 
                    placeholder="Enter ZIP code" 
                    required 
                    pattern="\d{5}"
                    title="Please enter a 5-digit ZIP code"
                    class="border p-2 rounded w-40"
                />
                <button type="submit" class="bg-blue-500 text-black px-4 py-2 rounded hover:bg-blue-600 transition">
                    Search
                </button>
            </form>

            @if(!empty($courses))
                <h2 class="text-xl font-semibold mb-2">Courses near {{ $zip }}:</h2>
                <ul class="space-y-4">
                    @foreach($courses as $course)
                        <li class="border p-4 rounded shadow">
                            <strong>{{ $course['course_name'] ?? 'Unknown Course' }}</strong><br />
                            @php
                                $loc = $course['location'] ?? [];
                            @endphp
                            {{ $loc['address'] ?? 'Address not available' }}<br />
                            {{ $loc['city'] ?? '' }}, {{ $loc['state'] ?? '' }} {{ $loc['postal_code'] ?? '' }}
                        </li>
                    @endforeach
                </ul>
            @elseif(isset($zip))
                <p class="text-gray-600">No courses found near {{ $zip }}.</p>
            @endif
        </div>
    </div>
</x-app-layout>
