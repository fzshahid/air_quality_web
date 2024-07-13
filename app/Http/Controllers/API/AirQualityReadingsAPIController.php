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

        return response()->json([
            'message' => 'Aqi reading stored successfully!',
            'reading' => $airQualityReading
        ]);
    }

    /**
     * Store SPS30 Reading resource in storage.
     *
     * @param StoreSps30APIReading $request
     * @return array|RedirectResponse|Redirector
     */
    public function storeSps30(StoreSps30APIReading $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();
        // Store the AirQualityReading
        $airQualityReading = $this->airQualityReadingsService->storeSps30($sanitized);

        return response()->json([
            'message' => 'SPS30 reading stored successfully!',
            'reading' => $airQualityReading
        ]);
    }
    /**
     * Store a Scd41 resource in storage.
     *
     * @param StoreScd41APIReading $request
     * @return array|RedirectResponse|Redirector
     */
    public function storeScd41(StoreScd41APIReading $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the AirQualityReading
        $airQualityReading = $this->airQualityReadingsService->storeScd41($sanitized);

        return response()->json([
            'message' => 'SCD41 reading stored successfully!',
            'reading' => $airQualityReading
        ]);
    }
    /**
     * Store a newly scs811 resource in storage.
     *
     * @param StoreCcs811APIReading $request
     * @return array|RedirectResponse|Redirector
     */
    public function storeCcs811(StoreCcs811APIReading $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the AirQualityReading
        $airQualityReading = $this->airQualityReadingsService->storeCcs811($sanitized);

        return response()->json([
            'message' => 'CCS811 reading stored successfully!',
            'reading' => $airQualityReading
        ]);
    }
}
