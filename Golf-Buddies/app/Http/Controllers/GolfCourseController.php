<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GolfCourseService;
use App\Services\ZipGeocodeService;
use Illuminate\Support\Facades\Http;

class GolfCourseController extends Controller
{
    public function index(Request $request, GolfCourseService $golfService)
    {
        $zip = $request->input('zip');
        $courses = [];
        $lat = $lon = null;
    
        if ($zip) {
            // Use existing ZipGeocodeService for lat/lon
            $coords = (new ZipGeocodeService)->getCoordinates($zip);
            if (!$coords) {
                return back()->with('error', 'Invalid ZIP');
            }
    
            $lat = $coords['lat'];
            $lon = $coords['lon'];
            $courses = $golfService->getCoursesByCoords($lat, $lon);
        }
    
        return view('courses.index', compact('courses', 'zip', 'lat', 'lon'));
    }
}