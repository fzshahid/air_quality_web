<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Enums\DataCategoriesEnum;
use App\Http\Services\AirQualityReadingsService;
use App\Models\Ccs811Reading;
use App\Models\Scd41Reading;
use App\Models\Sps30Reading;
use Carbon\CarbonPeriod;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use App\Models\AirQualityReading;
use DB;

class DashboardController extends Controller
{
    protected $sps30Reading, $ccs811Reading, $scd41Reading, $airQualityReadingService;

    /**
     *
     * @param Sps30Reading $sps30Reading
     * @param Ccs811Reading $ccs811Reading
     * @param Scd41Reading $scd41Reading
     * @param AirQualityReadingsService $airQualityReadingService
     */
    public function __construct(Sps30Reading $sps30Reading, Ccs811Reading $ccs811Reading, Scd41Reading $scd41Reading, AirQualityReadingsService $airQualityReadingsService) {
        $this->sps30Reading = $sps30Reading;
        $this->ccs811Reading = $ccs811Reading;
        $this->scd41Reading = $scd41Reading;
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

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return array|Factory|View
     */
    // public function temperatureLineChart(Request $request)
    // {
    //     $start_date = $request->get('start_date', now()->subDays(7)->format(DATE_FORMAT));
    //     $end_date = $request->get('end_date', now()->format(DATE_FORMAT));
    //     $analytics = $this->scd41Reading
    //     // ->active()
    //     ->whereDate('created_at', '>=', $start_date)
    //     ->whereDate('created_at', '<=', $end_date)
    //     ->groupByRaw('DATE(created_at)')
    //     ->selectRaw('DATE(created_at) as created_at_date, SUM(temperature) AS total')
    //     ->pluck('total', 'created_at_date');
    //     $ranges = CarbonPeriod::create($start_date, $end_date);
    //     $data = [];
    //     foreach ($ranges as $date) {
    //         $created_date = $date->format(DATE_FORMAT);
    //         $data[$created_date] = isset($analytics[$created_date]) ? $analytics[$created_date] : 0;
    //     }
    //     return response()->json($data);
    // }
    
    /**
     * Analytic of offers.
     *
     * @param Request $request
     * @return array|Factory|View
     */
    public function lineChartCo2(Request $request)
    {
        $lastFilter = $request->query('last');
        $resp = $this->airQualityReadingService->getChartData($lastFilter)->whereIn('category_name', [DataCategoriesEnum::CO2, DataCategoriesEnum::ECO2])->values()->all();
        return response()->json($resp);
    }

    /**
     * Analytic of offers.
     *
     * @param Request $request
     * @return array|Factory|View
     */
    public function temperatureLineChart(Request $request)
    {
        $lastFilter = $request->query('last');
        $resp = $this->airQualityReadingService->getChartData($lastFilter)->whereIn('category_name', [DataCategoriesEnum::TEMPERATURE])->values()->all();
        return response()->json($resp);
    }

    /**
     * Analytic of offers.
     *
     * @param Request $request
     * @return array|Factory|View
     */
    public function lineChartHumidity(Request $request)
    {
        $lastFilter = $request->query('last');
        $resp = $this->airQualityReadingService->getChartData($lastFilter)->whereIn('category_name', [DataCategoriesEnum::HUMIDITY])->values()->all();
        return response()->json($resp);
    }
    /**
     * Analytic of offers.
     *
     * @param Request $request
     * @return array|Factory|View
     */
    public function lineChartPM1(Request $request)
    {
        $lastFilter = $request->query('last');
        $resp = $this->airQualityReadingService->getChartData($lastFilter)->whereIn('category_name', [DataCategoriesEnum::PM1])->values()->all();
        return response()->json($resp);
    }
    /**
     * Analytic of offers.
     *
     * @param Request $request
     * @return array|Factory|View
     */
    public function lineChartPM25(Request $request)
    {
        $lastFilter = $request->query('last');
        $resp = $this->airQualityReadingService->getChartData($lastFilter)->whereIn('category_name', [DataCategoriesEnum::PM2_5])->values()->all();
        return response()->json($resp);
    }
    /**
     * Analytic of offers.
     *
     * @param Request $request
     * @return array|Factory|View
     */
    public function lineChartPM4(Request $request)
    {
        $lastFilter = $request->query('last');
        $resp = $this->airQualityReadingService->getChartData($lastFilter)->whereIn('category_name', [DataCategoriesEnum::PM4])->values()->all();
        return response()->json($resp);
    }
    /**
     * Analytic of offers.
     *
     * @param Request $request
     * @return array|Factory|View
     */
    public function lineChartPM10(Request $request)
    {
        $lastFilter = $request->query('last');
        $resp = $this->airQualityReadingService->getChartData($lastFilter)->whereIn('category_name', [DataCategoriesEnum::PM10])->values()->all();
        return response()->json($resp);
    }
    /**
     * Analytic of offers.
     *
     * @param Request $request
     * @return array|Factory|View
     */
    public function lineChartTvoc(Request $request)
    {
        $lastFilter = $request->query('last');
        $resp = $this->airQualityReadingService->getChartData($lastFilter)->whereIn('category_name', [DataCategoriesEnum::TVOC])->values()->all();
        return response()->json($resp);
    }

    /**
     * Analytic of offers.
     *
     * @param Request $request
     * @return array|Factory|View
     */
    public function lineChartCarbon(Request $request)
    {
        $data = [];
        for ($i=0; $i < 10; $i++) { 
            // $temp = [
            //     'category_id' => 1,
            //     'category_name' => 'Temperature',
            //     'date' => now()->subDays($i)->format(DATE_FORMAT),
            //     'total' => random_int(0, 50),
            // ];
            // $humid = [
            //     'category_id' => 2,
            //     'category_name' => 'Humidity',
            //     'date' => now()->subDays($i)->format(DATE_FORMAT),
            //     'total' => random_int(0, 50),
            // ];
            // $pm2_5 = [
            //     'category_id' => 3,
            //     'category_name' => 'PM2.5',
            //     'date' => now()->subDays($i)->format(DATE_FORMAT),
            //     'total' => random_int(0, 50),
            // ];
            // $pm10 = [
            //     'category_id' => 4,
            //     'category_name' => 'PM10',
            //     'date' => now()->subDays($i)->format(DATE_FORMAT),
            //     'total' => random_int(0, 50),
            // ];
            // array_push($data, $temp);
            // array_push($data, $pm2_5);
        }

        return response()->json($data);
    }
}
