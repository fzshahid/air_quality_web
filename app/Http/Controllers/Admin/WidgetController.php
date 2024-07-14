<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\AirQualityReadingsService;
use App\Models\AirQualityReading;
use App\Models\Subscriber;
use App\Notifications\UserSubscribed;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WidgetController extends Controller
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
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return array|Factory|View
     */
    public function index(Request $request)
    {
        $airQualityReading = AirQualityReading::query()->latest()->first();
        return view('admin.widget.index', ['data' => $airQualityReading]);
    }

    /**
     * Get Widget Data
     *
     * @param Request $request
     * @return array|Factory|View
     */
    public function getWidgetData(Request $request)
    {
        $airQualityReading = AirQualityReading::query()->latest()->first();

        $data = [
            'humidity' => $airQualityReading->humidity,
            'temperature' => $airQualityReading->temperature,
            // 'pm1_5' => $airQualityReading->pm1_0,
            'pm2_5' => $airQualityReading->pm2_5,
            // 'pm4' => $airQualityReading->pm4,
            'pm10' => $airQualityReading->pm10,
            'tvoc' => $airQualityReading->tvoc,
            'co2' => $airQualityReading->co2,
            // 'eco2' => $airQualityReading->eco2,
            'tvoc' => $airQualityReading->tvoc,
            // 'all' => '',
        ];


        $messages = $this->airQualityReadingsService->checkVentilationNeed($airQualityReading);
        $aqiIndex = $this->airQualityReadingsService->calculateAqiIndex($airQualityReading);
        return response()->json(['data' => $data, 'messages' => $messages, 'aqi_index' => $aqiIndex]);
    }

    public function subscribe(Request $request)
    {
        $input = $request->validate([
            'email' => 'required|email'
        ]);

        $subscriber = Subscriber::query()->where(['email' => $input['email']])->first();

        if (empty($subscriber)) {
            $subscriber = Subscriber::create($input);
        }        // Logic to handle subscription, e.g., save to database or send email
        $subscriber->notify(new UserSubscribed());

        return response()->json(['message' => 'Subscription successful'], 200);
    }
}
