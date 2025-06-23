<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ZipGeocodeService
{
    public function getCoordinates($zip)
    {
        $response = Http::get("https://api.zippopotam.us/us/{$zip}");

        if ($response->successful()) {
            $place = $response->json('places')[0] ?? null;

            if ($place) {
                return [
                    'lat' => (float) $place['latitude'],
                    'lon' => (float) $place['longitude'],
                ];
            }
        }

        return null;
    }
}
