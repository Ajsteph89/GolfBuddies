<?php

namespace App\Http\Controllers;

use App\Models\TeeTime;
use Illuminate\Http\Request;
use App\Services\ZipGeocodeService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;


class TeeTimeController extends Controller
{
    public function create(Request $request)
    {
        $course = $request->query('course');

        return view('tee-times.create', [
            'course' => $request->input('course'),
            'postal_code' => $request->input('postal_code'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
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

        $geo = null;
        if ($request->postal_code) {
            $geo = (new ZipGeocodeService)->getCoordinates($request->postal_code);
        }

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
    
        // Base query for joinable tee times
        $query = TeeTime::with(['participants', 'creator'])
            ->whereDoesntHave('participants', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->where('user_id', '!=', $user->id)
            ->where('scheduled_at', '>', now())
            ->whereRaw('(SELECT COUNT(*) FROM tee_time_user WHERE tee_time_user.tee_time_id = tee_times.id) < tee_times.max_players')
            ->oldest('scheduled_at');
    
        $teeTimes = $query->get(); // get all matching tee times as a Collection
    
        // Nearby filter using Haversine if selected
        if ($filter === 'nearby' && $user->zipcode) {
            $coords = (new ZipGeocodeService)->getCoordinates($user->zipcode);
    
            if ($coords) {
                $lat1 = $coords['lat'];
                $lon1 = $coords['lon'];
    
                $teeTimes = $teeTimes->filter(function ($teeTime) use ($lat1, $lon1) {
                    if (!$teeTime->latitude || !$teeTime->longitude) return false;
    
                    $lat2 = $teeTime->latitude;
                    $lon2 = $teeTime->longitude;
    
                    $distance = 3959 * acos(
                        cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
                        cos(deg2rad($lon2 - $lon1)) +
                        sin(deg2rad($lat1)) * sin(deg2rad($lat2))
                    );
    
                    return $distance <= 25;
                });
            }
        }
    
        // Manual pagination for both filtered/unfiltered results
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 5;
        $paged = $teeTimes->slice(($currentPage - 1) * $perPage, $perPage)->values();
    
        $teeTimes = new LengthAwarePaginator(
            $paged,
            $teeTimes->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );
    
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
            ->oldest('scheduled_at')
            ->paginate(5)->withQueryString();

        return view('tee-times.mine', compact('teeTimes'));
    }

    public function join(TeeTime $teeTime)
    {
        $user = Auth::user();

        // Check if tee time is already full
        if ($teeTime->participants->count() >= $teeTime->max_players) {
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
