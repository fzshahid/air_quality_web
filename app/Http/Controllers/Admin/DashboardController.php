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
    public function newUsers(Request $request)
    {
        $start_date = $request->get('start_date', now()->subDays(7)->format(DATE_FORMAT));
        $end_date = $request->get('end_date', now()->format(DATE_FORMAT));
        $analytics = $this->sps30Reading
        // ->active()
        ->whereDate('created_at', '>=', $start_date)
        ->whereDate('created_at', '<=', $end_date)
        ->groupByRaw('DATE(created_at)')
        ->selectRaw('DATE(created_at) as created_at_date, COUNT(pm2_5) AS total')
        ->pluck('total', 'created_at_date');
        $ranges = CarbonPeriod::create($start_date, $end_date);
        $data = [];
        foreach ($ranges as $date) {
            $created_date = $date->format(DATE_FORMAT);
            $data[$created_date] = isset($analytics[$created_date]) ? $analytics[$created_date] : 0;
        }
        return response()->json($data);
    }
    
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
        
        $data = $this->offerService->offersStats();
        return response()->json($data);
    }
}
