<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\AirQualityReading\StoreAirQualityAPIReading;
use App\Http\Services\AirQualityReadingsService;
use App\Models\AirQualityReading;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class AirQualityReadingsAPIController extends Controller
{

    protected $airQualityReadingsService;

    /**
     *
     * @param AirQualityReadingsService $airQualityReadingsService
     */
    public function __construct(AirQualityReadingsService $airQualityReadingsService) {
        $this->airQualityReadingsService = $airQualityReadingsService;
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAirQualityAPIReading $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreAirQualityAPIReading $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();
        // $sanitized = [
        //     'co2' => 1200,
        //     'voc' => 800,
        //     'humidity' => 45,
        //     'temperature' => 22,
        //     'pm2_5' => 40,
        //     'pm10' => 160,
        // ];

        // Store the AirQualityReading
        $airQualityReading = $this->airQualityReadingsService->store($sanitized);

        return response()->json([
            'message' => 'AQI reading stored successfully!',
            'reading' => $airQualityReading
        ]);
    }
}
