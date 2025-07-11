<?php

namespace App\Http\Controllers;

use App\Models\TeeTime;
use Illuminate\Http\Request;
use App\Services\ZipGeocodeService;
use Illuminate\Support\Facades\Auth;

class TeeTimeController extends Controller
{
    public function create(Request $request)
    {
        $course = $request->query('course');

        return view('tee-times.create', [
            'course' => $course,
        ]);
    }

    public function destroy(TeeTime $teeTime)
        {
            if ($teeTime->user_id !== Auth::id()) {
                abort(403, 'Unauthorized action.');
            }

            $teeTime->delete();

            return redirect()->route('tee-times.mine')->with('success', 'Tee time cancelled successfully.');
        }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_name' => 'required|string|max:255',
            'scheduled_at' => 'required|date|after:now',
            'max_players' => 'required|integer|min:1|max:4',
            'notes' => 'nullable|string',
            'postal_code' => 'nullable|string|max:20',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $teeTime = TeeTime::create([
            'user_id' => Auth::id(),
            'course_name' => $validated['course_name'],
            'scheduled_at' => $validated['scheduled_at'],
            'max_players' => $validated['max_players'],
            'notes' => $validated['notes'],
            'postal_code' => $request->postal_code,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        // Creator joins their own tee time
        $teeTime->participants()->attach(Auth::id());

        return redirect()->route('tee-times.mine')->with('success', 'Tee time created!');
    }

    public function joinable(Request $request)
    {
        $user = Auth::user();
        $filter = $request->input('filter', 'all');

        $query = TeeTime::with(['participants', 'creator'])
            ->whereDoesntHave('participants', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->where('user_id', '!=', $user->id)
            ->where('scheduled_at', '>', now())
            ->latest();

        if ($request->input('filter') === 'nearby') {
            $zip = $request->input('zip') ?? $user->zip;

            if ($zip) {
                $coords = (new ZipGeocodeService)->getCoordinates($zip);

                if ($coords) {
                    $lat = $coords['lat'];
                    $lon = $coords['lon'];

                    // Simple radius filter using Haversine formula (25 miles)
                    $query->select('*')->selectRaw("
                        (3959 * acos(
                            cos(radians(?)) * cos(radians(latitude)) *
                            cos(radians(longitude) - radians(?)) +
                            sin(radians(?)) * sin(radians(latitude))
                        )) AS distance
                    ", [$lat, $lon, $lat])
                    ->having("distance", "<", 25)
                    ->orderBy("distance");
                }
            }
        }

        $teeTimes = $query->get();

        return view('tee-times.joinable', compact('teeTimes', 'filter'));

    }

    public function mine()
    {
        $user = Auth::user();

        $teeTimes = TeeTime::with('participants')
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhereHas('participants', function ($q) use ($user) {
                        $q->where('user_id', $user->id);
                    });
            })
            ->latest()
            ->get();

        return view('tee-times.mine', compact('teeTimes'));
    }

    public function join(TeeTime $teeTime)
    {
        $user = Auth::user();

        // Check if tee time is already full
        if ($teeTime->participants->count() >= 4) {
            return back()->with('error', 'This tee time is already full.');
        }

        // Check if user is already a participant
        if (!$teeTime->participants->contains($user->id)) {
            $teeTime->participants()->attach($user->id);
            return back()->with('success', 'You joined the tee time!');
        }

        return back()->with('info', 'You have already joined this tee time.');
    }

    public function leave(TeeTime $teeTime)
    {
        $user = Auth::user();

        if ($teeTime->participants->contains($user->id)) {
            $teeTime->participants()->detach($user->id);
        }

        return back()->with('success', 'You have left the tee time.');
    }
}
