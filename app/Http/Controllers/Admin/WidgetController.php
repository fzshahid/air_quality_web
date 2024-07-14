<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AirQualityReading;
use App\Models\Ccs811Reading;
use App\Models\Scd41Reading;
use App\Models\Sps30Reading;
use App\Models\Subscriber;
use App\Notifications\UserSubscribed;
use Carbon\CarbonPeriod;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\View\View;

class WidgetController extends Controller
{
    protected $sps30Reading, $ccs811Reading, $scd41Reading;

    /**
     *
     * @param Sps30Reading $sps30Reading
     * @param Ccs811Reading $ccs811Reading
     * @param Scd41Reading $scd41Reading
     */
    public function __construct(Sps30Reading $sps30Reading, Ccs811Reading $ccs811Reading, Scd41Reading $scd41Reading) {
        $this->sps30Reading = $sps30Reading;
        $this->ccs811Reading = $ccs811Reading;
        $this->scd41Reading = $scd41Reading;
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

        $airQualityReading = [
            'humidity' => $airQualityReading->humidity,
            'temperature' => $airQualityReading->temperature,
            'pm1_5' => $airQualityReading->pm1_0,
            'pm2_5' => $airQualityReading->pm2_5,
            'pm4' => $airQualityReading->pm4,
            'pm10' => $airQualityReading->pm10,
            'tvoc' => $airQualityReading->tvoc,
            'co2' => $airQualityReading->co2,
            'eco2' => $airQualityReading->eco2,
            'tvoc' => $airQualityReading->tvoc,
            'all' => '',

        ];
        return response()->json(['data' => $airQualityReading]);
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
