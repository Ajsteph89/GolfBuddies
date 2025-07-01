<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GolfCourseService
{
    public function getCoursesByCoords($lat, $lon, $radius = 25)
    {
        $response = Http::withHeaders([
            'X-RapidAPI-Key' => config('services.rapidapi.key'),
            'X-RapidAPI-Host' => config('services.rapidapi.host'),
        ])->get('https://golf-course-finder.p.rapidapi.com/api/golf-clubs/', [
            'latitude' => $lat,
            'longitude' => $lon,
            'miles' => $radius, // max 50 miles :contentReference[oaicite:8]{index=8}
            'page' => 1,
        ]);
    
        
        if ($response->failed()) {
            \Log::error('RapidAPI golf request failed', $response->json());
            return [];
        }
        // dd($response->json());
        return $response->json() ?? [];

    }
}
