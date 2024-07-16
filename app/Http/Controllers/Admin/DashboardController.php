<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Enums\DataCategoriesEnum;
use App\Http\Services\AirQualityReadingsService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use App\Models\AirQualityReading;
use DB;

class DashboardController extends Controller
{
    protected $airQualityReadingService;

    /**
     *
     * @param AirQualityReadingsService $airQualityReadingService
     */
    public function __construct(AirQualityReadingsService $airQualityReadingsService) {
        $this->airQualityReadingService = $airQualityReadingsService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return array|Factory|View
     */
    public function index(Request $request)
    {
        $data = [];

        return view('admin.dashboard.index', ['data' => $data]);
    }

    public function lineChartCo2(Request $request)
    {
        $lastFilter = $request->query('last');
        $resp = $this->airQualityReadingService->getChartData($lastFilter)->whereIn('category_name', [DataCategoriesEnum::CO2, DataCategoriesEnum::ECO2])->values()->all();
        return response()->json($resp);
    }

    public function temperatureLineChart(Request $request)
    {
        $lastFilter = $request->query('last');
        $resp = $this->airQualityReadingService->getChartData($lastFilter)->whereIn('category_name', [DataCategoriesEnum::TEMPERATURE])->values()->all();
        return response()->json($resp);
    }

    public function lineChartHumidity(Request $request)
    {
        $lastFilter = $request->query('last');
        $resp = $this->airQualityReadingService->getChartData($lastFilter)->whereIn('category_name', [DataCategoriesEnum::HUMIDITY])->values()->all();
        return response()->json($resp);
    }
    public function lineChartPM(Request $request)
    {
        $lastFilter = $request->query('last');
        $resp = $this->airQualityReadingService->getChartData($lastFilter)->whereIn('category_name', [DataCategoriesEnum::PM1, DataCategoriesEnum::PM2_5, DataCategoriesEnum::PM4, DataCategoriesEnum::PM10])->values()->all();
        return response()->json($resp);
    }
    public function lineChartPM1(Request $request)
    {
        $lastFilter = $request->query('last');
        $resp = $this->airQualityReadingService->getChartData($lastFilter)->whereIn('category_name', [DataCategoriesEnum::PM1])->values()->all();
        return response()->json($resp);
    }
    public function lineChartPM25(Request $request)
    {
        $lastFilter = $request->query('last');
        $resp = $this->airQualityReadingService->getChartData($lastFilter)->whereIn('category_name', [DataCategoriesEnum::PM2_5])->values()->all();
        return response()->json($resp);
    }
    public function lineChartPM4(Request $request)
    {
        $lastFilter = $request->query('last');
        $resp = $this->airQualityReadingService->getChartData($lastFilter)->whereIn('category_name', [DataCategoriesEnum::PM4])->values()->all();
        return response()->json($resp);
    }
    public function lineChartPM10(Request $request)
    {
        $lastFilter = $request->query('last');
        $resp = $this->airQualityReadingService->getChartData($lastFilter)->whereIn('category_name', [DataCategoriesEnum::PM10])->values()->all();
        return response()->json($resp);
    }
    public function lineChartTvoc(Request $request)
    {
        $lastFilter = $request->query('last');
        $resp = $this->airQualityReadingService->getChartData($lastFilter)->whereIn('category_name', [DataCategoriesEnum::TVOC])->values()->all();
        return response()->json($resp);
    }
}
