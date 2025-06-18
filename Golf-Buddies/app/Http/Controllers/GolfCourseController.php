<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GolfCourseService;

class GolfCourseController extends Controller
{
    public function index(Request $request, GolfCourseService $golfService)
    {
        $zip = $request->input('zip');
        $courses = $zip ? $golfService->getCoursesByZip($zip) : [];

        return view('courses.index', compact('courses', 'zip'));
    }
}
