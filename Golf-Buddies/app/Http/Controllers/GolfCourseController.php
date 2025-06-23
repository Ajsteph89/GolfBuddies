<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GolfCourseService;
use App\Services\ZipGeocodeService;

class GolfCourseController extends Controller
{
    public function index(Request $request, GolfCourseService $golfService)
    {
        $zip = $request->input('zip');
        $courses = [];
    
        if ($zip) {
            $geoService = new ZipGeocodeService();
            $coordinates = $geoService->getCoordinates($zip);
    
            if ($coordinates) {
                // Pass coordinates to view (for future distance filtering)
                $courses = $golfService->getCoursesByZip($zip);
            } else {
                return back()->with('error', 'Could not find location for that ZIP code.');
            }
        }
    
        return view('courses.index', [
            'zip' => $zip,
            'courses' => $courses,
            // Optional: 'coordinates' => $coordinates, if you want to debug/display
        ]);
    }
}
