<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Scd41Reading\BulkDestroyScd41Reading;
use App\Http\Requests\Admin\Scd41Reading\DestroyScd41Reading;
use App\Http\Requests\Admin\Scd41Reading\IndexScd41Reading;
use App\Http\Requests\Admin\Scd41Reading\StoreScd41Reading;
use App\Http\Requests\Admin\Scd41Reading\UpdateScd41Reading;
use App\Models\Scd41Reading;
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

class Scd41ReadingsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexScd41Reading $request
     * @return array|Factory|View
     */
    public function index(IndexScd41Reading $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Scd41Reading::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'temperature', 'humidity', 'eco2'],

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

        return view('admin.scd41-reading.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.scd41-reading.create');

        return view('admin.scd41-reading.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreScd41Reading $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreScd41Reading $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Scd41Reading
        $scd41Reading = Scd41Reading::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/scd41-readings'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/scd41-readings');
    }

    /**
     * Display the specified resource.
     *
     * @param Scd41Reading $scd41Reading
     * @throws AuthorizationException
     * @return void
     */
    public function show(Scd41Reading $scd41Reading)
    {
        $this->authorize('admin.scd41-reading.show', $scd41Reading);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Scd41Reading $scd41Reading
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Scd41Reading $scd41Reading)
    {
        $this->authorize('admin.scd41-reading.edit', $scd41Reading);


        return view('admin.scd41-reading.edit', [
            'scd41Reading' => $scd41Reading,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateScd41Reading $request
     * @param Scd41Reading $scd41Reading
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateScd41Reading $request, Scd41Reading $scd41Reading)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Scd41Reading
        $scd41Reading->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/scd41-readings'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/scd41-readings');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyScd41Reading $request
     * @param Scd41Reading $scd41Reading
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyScd41Reading $request, Scd41Reading $scd41Reading)
    {
        $scd41Reading->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyScd41Reading $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyScd41Reading $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Scd41Reading::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
