<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ccs811Reading;
use App\Models\Scd41Reading;
use App\Models\Sps30Reading;
use Carbon\CarbonPeriod;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\View\View;

class DashboardController extends Controller
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
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return array|Factory|View
     */
    public function activeUsers(Request $request)
    {
        // $a = $this->analytic->groupByRaw('user_id, DATE(logged_at)')->selectRaw('COUNT(id) as total_active, DATE(logged_at) AS date')->pluck('total_active', 'date');
        $start_date = $request->get('start_date', now()->subDays(7)->format(DATE_FORMAT));
        $end_date = $request->get('end_date', now()->format(DATE_FORMAT));
        $analytics = $this->scd41Reading
        ->whereDate('created_at', '>=', $start_date)
        ->whereDate('created_at', '<=', $end_date)
        ->groupByRaw('DATE(created_at)')
        ->selectRaw('DATE(created_at) as created_at_date, COUNT(id) AS total')
        // ->select('temperature', 'created_at')
        ->pluck('total', 'created_at_date');
        $ranges = CarbonPeriod::create($start_date, $end_date);
        $data = [];
        foreach ($ranges as $date) {
            $created_date = $date->format(DATE_FORMAT);
            $data[$created_date] = isset($analytics[$created_date]) ? $analytics[$created_date] : 1;
        }
        return response()->json($data);
    }
    
    /**
     * Analytic of offers.
     *
     * @param Request $request
     * @return array|Factory|View
     */
    public function postedOffers(Request $request)
    {
        $data = [];
        for ($i=0; $i < 10; $i++) { 
            $temp = [
                'category_id' => 1,
                'category_name' => 'Temperature',
                'date' => now()->subDays($i)->format(DATE_FORMAT),
                'total' => random_int(0, 50),
            ];
            $humid = [
                'category_id' => 2,
                'category_name' => 'Humidity',
                'date' => now()->subDays($i)->format(DATE_FORMAT),
                'total' => random_int(0, 50),
            ];
            $pm2_5 = [
                'category_id' => 3,
                'category_name' => 'PM2.5',
                'date' => now()->subDays($i)->format(DATE_FORMAT),
                'total' => random_int(0, 500),
            ];
            $pm10 = [
                'category_id' => 4,
                'category_name' => 'PM10',
                'date' => now()->subDays($i)->format(DATE_FORMAT),
                'total' => random_int(0, 500),
            ];
            $pm10 = [
                'category_id' => 5,
                'category_name' => 'TVOC',
                'date' => now()->subDays($i)->format(DATE_FORMAT),
                'total' => random_int(0, 500),
            ];
            array_push($data, $temp, $humid, $pm2_5, $pm10);
        }

        return response()->json($data);
    }
    
    /**
     * Analytic of offers.
     *
     * @param Request $request
     * @return array|Factory|View
     */
    public function lineChartCo2(Request $request)
    {
        $data = [];
        for ($i=0; $i < 10; $i++) { 
            $temp = [
                'category_id' => 1,
                'category_name' => 'Temperature',
                'date' => now()->subDays($i)->format(DATE_FORMAT),
                'total' => random_int(0, 50),
            ];
            $humid = [
                'category_id' => 2,
                'category_name' => 'Humidity',
                'date' => now()->subDays($i)->format(DATE_FORMAT),
                'total' => random_int(0, 100),
            ];
            $pm2_5 = [
                'category_id' => 3,
                'category_name' => 'PM2.5',
                'date' => now()->subDays($i)->format(DATE_FORMAT),
                'total' => random_int(0, 500),
            ];
            $pm10 = [
                'category_id' => 4,
                'category_name' => 'PM10',
                'date' => now()->subDays($i)->format(DATE_FORMAT),
                'total' => random_int(0, 500),
            ];
            $co2 = [
                'category_id' => 4,
                'category_name' => 'CO2',
                'date' => now()->subDays($i)->format(DATE_FORMAT),
                'total' => random_int(0, 5000),
            ];
            $eco2 = [
                'category_id' => 5,
                'category_name' => 'eCO2',
                'date' => now()->subDays($i)->format(DATE_FORMAT),
                'total' => random_int(400, 5000),
            ];
            array_push($data, $temp, $humid, $pm2_5, $pm10, $co2, $eco2);
        }

        return response()->json($data);
    }

    /**
     * Analytic of offers.
     *
     * @param Request $request
     * @return array|Factory|View
     */
    public function temperatureLineChart(Request $request)
    {
        $data = [];
        for ($i=0; $i < 10; $i++) { 
            $temp = [
                'category_id' => 1,
                'category_name' => 'Temperature',
                'date' => now()->subDays($i)->format(DATE_FORMAT),
                'total' => random_int(0, 50),
            ];
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
            array_push($data, $temp);
        }

        return response()->json($data);
    }

    /**
     * Analytic of offers.
     *
     * @param Request $request
     * @return array|Factory|View
     */
    public function lineChartHumidity(Request $request)
    {
        $data = [];
        for ($i=0; $i < 10; $i++) { 
            
            $humid = [
                'category_id' => 2,
                'category_name' => 'Humidity',
                'date' => now()->subDays($i)->format(DATE_FORMAT),
                'total' => random_int(0, 100),
            ];
            array_push($data, $humid);
        }

        return response()->json($data);
    }
    /**
     * Analytic of offers.
     *
     * @param Request $request
     * @return array|Factory|View
     */
    public function lineChartPM15(Request $request)
    {
        $data = [];
        for ($i=0; $i < 10; $i++) { 
            
            $item = [
                'category_id' => 3,
                'category_name' => 'PM1.5',
                'date' => now()->subDays($i)->format(DATE_FORMAT),
                'total' => random_int(0, 500),
            ];
            
            array_push($data, $item);
        }

        return response()->json($data);
    }
    /**
     * Analytic of offers.
     *
     * @param Request $request
     * @return array|Factory|View
     */
    public function lineChartPM25(Request $request)
    {
        $data = [];
        for ($i=0; $i < 10; $i++) { 
            
            $item = [
                'category_id' => 3,
                'category_name' => 'PM2.5',
                'date' => now()->subDays($i)->format(DATE_FORMAT),
                'total' => random_int(0, 500),
            ];
            
            array_push($data, $item);
        }

        return response()->json($data);
    }
    /**
     * Analytic of offers.
     *
     * @param Request $request
     * @return array|Factory|View
     */
    public function lineChartPM4(Request $request)
    {
        $data = [];
        for ($i=0; $i < 10; $i++) { 
            
            $item = [
                'category_id' => 3,
                'category_name' => 'PM4.0',
                'date' => now()->subDays($i)->format(DATE_FORMAT),
                'total' => random_int(0, 500),
            ];
            
            array_push($data, $item);
        }

        return response()->json($data);
    }
    /**
     * Analytic of offers.
     *
     * @param Request $request
     * @return array|Factory|View
     */
    public function lineChartPM10(Request $request)
    {
        $data = [];
        for ($i=0; $i < 10; $i++) { 
            
            $item = [
                'category_id' => 3,
                'category_name' => 'PM10',
                'date' => now()->subDays($i)->format(DATE_FORMAT),
                'total' => random_int(0, 500),
            ];
            
            array_push($data, $item);
        }

        return response()->json($data);
    }
    /**
     * Analytic of offers.
     *
     * @param Request $request
     * @return array|Factory|View
     */
    public function lineChartTvoc(Request $request)
    {
        $data = [];
        for ($i=0; $i < 10; $i++) { 
            
            $item = [
                'category_id' => 3,
                'category_name' => 'TVOC',
                'date' => now()->subDays($i)->format(DATE_FORMAT),
                'total' => random_int(0, 60000),
            ];
            
            array_push($data, $item);
        }

        return response()->json($data);
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
