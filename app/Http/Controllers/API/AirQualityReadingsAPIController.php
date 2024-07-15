<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AirQualityReading\StoreAirQualityReading;
use App\Http\Requests\API\AirQualityReading\StoreScd41APIReading;
// use App\Http\Requests\API\AirQualityReading\StoreAirQualityReading;
use App\Http\Services\AirQualityReadingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class AirQualityReadingsAPIController extends Controller
{

    protected $airQualityReadingsService;

    /**
     *
     * @param AirQualityReadingsService $airQualityReadingsService
     */
    public function __construct(AirQualityReadingsService $airQualityReadingsService)
    {
        $this->airQualityReadingsService = $airQualityReadingsService;
    }

    /**
     * Store SPS30 Reading resource in storage.
     *
     * @param StoreAirQualityReading $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreAirQualityReading $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();
        // Store the AirQualityReading
        // $airQualityReading = $this->airQualityReadingsService->storeSps30($sanitized);
        $sanitized['pm1_0'] = round($sanitized['pm1_0'] / 1000, 2);
        $sanitized['pm2_5'] = round($sanitized['pm2_5'] / 1000, 2);
        $sanitized['pm4'] = round($sanitized['pm4'] / 1000, 2);
        $sanitized['pm10'] = round($sanitized['pm10'] / 1000, 2);

        $airQualityReading = \App\Models\AirQualityReading::create($sanitized);
        
        $aqiData = $this->airQualityReadingsService->calculateAqiIndex($airQualityReading);
        
        $airQualityReading->aqi_pm2_5 = $aqiData['aqi_pm2_5']['aqi'];
        $airQualityReading->aqi_pm10 = $aqiData['aqi_pm10']['aqi'];
        $airQualityReading->save();

        return response()->json([
            'message' => 'Aqi reading stored successfully!',
            'reading' => $airQualityReading
        ]);
    }
}
