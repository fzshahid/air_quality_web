<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Sps30Reading\BulkDestroySps30Reading;
use App\Http\Requests\Admin\Sps30Reading\DestroySps30Reading;
use App\Http\Requests\Admin\Sps30Reading\IndexSps30Reading;
use App\Http\Requests\Admin\Sps30Reading\StoreSps30Reading;
use App\Http\Requests\Admin\Sps30Reading\UpdateSps30Reading;
use App\Models\Sps30Reading;
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

class Sps30ReadingsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexSps30Reading $request
     * @return array|Factory|View
     */
    public function index(IndexSps30Reading $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Sps30Reading::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'pm1_0', 'pm2_5', 'pm4', 'pm10'],

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

        return view('admin.sps30-reading.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.sps30-reading.create');

        return view('admin.sps30-reading.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreSps30Reading $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreSps30Reading $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Sps30Reading
        $sps30Reading = Sps30Reading::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/sps30-readings'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/sps30-readings');
    }

    /**
     * Display the specified resource.
     *
     * @param Sps30Reading $sps30Reading
     * @throws AuthorizationException
     * @return void
     */
    public function show(Sps30Reading $sps30Reading)
    {
        $this->authorize('admin.sps30-reading.show', $sps30Reading);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Sps30Reading $sps30Reading
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Sps30Reading $sps30Reading)
    {
        $this->authorize('admin.sps30-reading.edit', $sps30Reading);


        return view('admin.sps30-reading.edit', [
            'sps30Reading' => $sps30Reading,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSps30Reading $request
     * @param Sps30Reading $sps30Reading
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateSps30Reading $request, Sps30Reading $sps30Reading)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Sps30Reading
        $sps30Reading->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/sps30-readings'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/sps30-readings');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroySps30Reading $request
     * @param Sps30Reading $sps30Reading
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroySps30Reading $request, Sps30Reading $sps30Reading)
    {
        $sps30Reading->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroySps30Reading $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroySps30Reading $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Sps30Reading::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
