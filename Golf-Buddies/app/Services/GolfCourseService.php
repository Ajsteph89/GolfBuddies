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

    public function getCoursesByZip($zip)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Key ' . config('services.golfapi.key'),
        ])->get('https://api.golfcourseapi.com/v1/courses', [
            'zip_code' => $zip,
        ]);

        $data = $response->json();

        return $data['courses'] ?? [];
    }
}
