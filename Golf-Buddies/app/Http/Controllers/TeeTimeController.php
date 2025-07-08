<?php

namespace App\Http\Controllers;

use App\Models\TeeTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeeTimeController extends Controller
{
    public function index()
    {
        $teeTimes = TeeTime::with('participants', 'creator')->latest()->get();
        return view('tee-times.index', compact('teeTimes'));
    }

    public function create(Request $request)
    {
        $course = $request->query('course');

        return view('tee-times.create', [
            'course' => $course,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_name' => 'required|string|max:255',
            'scheduled_at' => 'required|date',
            'max_players' => 'required|integer|min:1|max:4',
            'notes' => 'nullable|string',
        ]);

        $teeTime = TeeTime::create([
            'user_id' => Auth::id(),
            'course_name' => $validated['course_name'],
            'scheduled_at' => $validated['scheduled_at'],
            'max_players' => $validated['max_players'],
            'notes' => $validated['notes'],
        ]);

        // Creator joins their own tee time
        $teeTime->participants()->attach(Auth::id());

        return redirect()->route('tee-times.index')->with('success', 'Tee time created!');
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
}
