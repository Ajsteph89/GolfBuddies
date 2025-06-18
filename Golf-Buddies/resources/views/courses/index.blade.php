<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Find Golf Courses</title>
</head>
<body>
    <h1>Find Golf Courses by ZIP Code</h1>

    <form method="GET" action="{{ route('courses.index') }}">
        <input 
            type="text" 
            name="zip" 
            value="{{ old('zip', $zip ?? '') }}" 
            placeholder="Enter ZIP code" 
            required 
            pattern="\d{5}"
            title="Please enter a 5-digit ZIP code"
        />
        <button type="submit">Search</button>
    </form>

    @if(!empty($courses))
    <h2>Courses near {{ $zip }}:</h2>
    <ul>
        @foreach($courses as $course)
            <li>
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
    <p>No courses found near {{ $zip }}.</p>
@endif


</body>
</html>
