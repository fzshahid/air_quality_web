<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AirQualityReading\BulkDestroyAirQualityReading;
use App\Http\Requests\Admin\AirQualityReading\DestroyAirQualityReading;
use App\Http\Requests\Admin\AirQualityReading\IndexAirQualityReading;
use App\Http\Requests\Admin\AirQualityReading\StoreAirQualityReading;
use App\Http\Requests\Admin\AirQualityReading\UpdateAirQualityReading;
use App\Http\Services\AirQualityReadingsService;
use App\Models\AirQualityReading;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AirQualityReadingsController extends Controller
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
     * @param IndexAirQualityReading $request
     * @return array|Factory|View
     */
    public function index(IndexAirQualityReading $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(AirQualityReading::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'temperature', 'humidity', 'co2', 'pm1_0', 'pm2_5', 'pm4', 'pm10', 'eco2', 'tvoc', 'created_at'],

            // set columns to searchIn
            ['id']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.air-quality-reading.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.air-quality-reading.create');

        return view('admin.air-quality-reading.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAirQualityReading $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreAirQualityReading $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the AirQualityReading
        // $airQualityReading = AirQualityReading::create($sanitized);
        $airQualityReading = $this->airQualityReadingsService->store($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/air-quality-readings'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/air-quality-readings');
    }

    /**
     * Display the specified resource.
     *
     * @param AirQualityReading $airQualityReading
     * @throws AuthorizationException
     * @return void
     */
    public function show(AirQualityReading $airQualityReading)
    {
        $this->authorize('admin.air-quality-reading.show', $airQualityReading);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param AirQualityReading $airQualityReading
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(AirQualityReading $airQualityReading)
    {
        $this->authorize('admin.air-quality-reading.edit', $airQualityReading);


        return view('admin.air-quality-reading.edit', [
            'airQualityReading' => $airQualityReading,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAirQualityReading $request
     * @param AirQualityReading $airQualityReading
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateAirQualityReading $request, AirQualityReading $airQualityReading)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values AirQualityReading
        $airQualityReading->update($sanitized);

        $aqiData = $this->airQualityReadingsService->calculateAqiIndex($airQualityReading);

        $airQualityReading->aqi_pm2_5 = $aqiData['aqi_pm2_5']['aqi'];
        $airQualityReading->aqi_pm10 = $aqiData['aqi_pm10']['aqi'];
        $airQualityReading->save();

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/air-quality-readings'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/air-quality-readings');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyAirQualityReading $request
     * @param AirQualityReading $airQualityReading
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyAirQualityReading $request, AirQualityReading $airQualityReading)
    {
        $airQualityReading->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyAirQualityReading $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyAirQualityReading $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    AirQualityReading::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
