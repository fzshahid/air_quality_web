<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\AirQualityReading\StoreCcs811APIReading;
use App\Http\Requests\API\AirQualityReading\StoreScd41APIReading;
use App\Http\Requests\API\AirQualityReading\StoreSps30APIReading;
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
