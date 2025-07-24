<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Services\GolfCourseService;
use App\Services\ZipGeocodeService;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class GolfCourseController extends Controller
{
    public function index(Request $request, GolfCourseService $golfService)
    {
        $zip = $request->input('zip');
        $courses = collect();
        $lat = $lon = null;
    
        if ($zip) {
            // Use existing ZipGeocodeService for lat/lon
            $coords = (new ZipGeocodeService)->getCoordinates($zip);
            if (!$coords) {
                return back()->with('error', 'Invalid ZIP');
            }
    
            $lat = $coords['lat'];
            $lon = $coords['lon'];

            $rawCourses = $golfService->getCoursesByCoords($lat, $lon);

            $courses = collect($rawCourses); // Turn array into Collection

            // Paginate manually
            $perPage = 5;
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $pagedCourses = $courses->slice(($currentPage - 1) * $perPage, $perPage)->values();


            $courses = new LengthAwarePaginator(
                $pagedCourses,
                $courses->count(),
                $perPage,
                $currentPage,
                ['path' => $request->url(), 'query' => $request->query()]
            );
        } else {
            // Ensures pagination still works with no results
            $courses = new LengthAwarePaginator([], 0, 5, 1, [
                'path' => $request->url(),
                'query' => $request->query(),
            ]);
        }
    
        return view('courses.index', compact('courses', 'zip', 'lat', 'lon'));
    }
}