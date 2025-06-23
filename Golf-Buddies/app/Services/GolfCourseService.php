<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GolfCourseService
{
    protected $key;
    protected $host;

    public function __construct()
    {
        $this->key = config('services.golfapi.key');
        $this->host = config('services.golfapi.host');
    }

    public function getCoursesByZip($zip, $radius = 300)
    {
        $geoService = new \App\Services\ZipGeocodeService();
        $userCoords = $geoService->getCoordinates($zip);

        if (!$userCoords) {
            return [];
        }

        $response = Http::withHeaders([
            'Authorization' => 'Key ' . config('services.golfapi.key'),
        ])->get('https://api.golfcourseapi.com/v1/search', [
            'search_query' => 'golf',
        ]);

        // $data = $response->json();

        dd($data);

        if (!isset($data['courses'])) {
            return [];
        }

        // dd($data['courses']);


            // Filter courses within the radius
        return array_filter($data['courses'], function ($course) use ($userCoords, $radius) {
            if (!isset($course['location']['latitude'], $course['location']['longitude'])) {
                return false;
            }
        
            $lat = $course['location']['latitude'];
            $lon = $course['location']['longitude'];
        
            return $this->haversineDistance(
                $userCoords['lat'],
                $userCoords['lon'],
                $lat,
                $lon
            ) <= $radius;
        });
    }

    private function haversineDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 3959; // Miles

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $lat1 = deg2rad($lat1);
        $lat2 = deg2rad($lat2);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            sin($dLon / 2) * sin($dLon / 2) * cos($lat1) * cos($lat2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
