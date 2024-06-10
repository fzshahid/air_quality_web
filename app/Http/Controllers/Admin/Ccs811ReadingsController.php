<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Ccs811Reading\BulkDestroyCcs811Reading;
use App\Http\Requests\Admin\Ccs811Reading\DestroyCcs811Reading;
use App\Http\Requests\Admin\Ccs811Reading\IndexCcs811Reading;
use App\Http\Requests\Admin\Ccs811Reading\StoreCcs811Reading;
use App\Http\Requests\Admin\Ccs811Reading\UpdateCcs811Reading;
use App\Models\Ccs811Reading;
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

class Ccs811ReadingsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexCcs811Reading $request
     * @return array|Factory|View
     */
    public function index(IndexCcs811Reading $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Ccs811Reading::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'temperature', 'humidity', 'eco2', 'tvoc'],

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

        return view('admin.ccs811-reading.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.ccs811-reading.create');

        return view('admin.ccs811-reading.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCcs811Reading $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreCcs811Reading $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Ccs811Reading
        $ccs811Reading = Ccs811Reading::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/ccs811-readings'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/ccs811-readings');
    }

    /**
     * Display the specified resource.
     *
     * @param Ccs811Reading $ccs811Reading
     * @throws AuthorizationException
     * @return void
     */
    public function show(Ccs811Reading $ccs811Reading)
    {
        $this->authorize('admin.ccs811-reading.show', $ccs811Reading);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Ccs811Reading $ccs811Reading
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Ccs811Reading $ccs811Reading)
    {
        $this->authorize('admin.ccs811-reading.edit', $ccs811Reading);


        return view('admin.ccs811-reading.edit', [
            'ccs811Reading' => $ccs811Reading,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCcs811Reading $request
     * @param Ccs811Reading $ccs811Reading
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateCcs811Reading $request, Ccs811Reading $ccs811Reading)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Ccs811Reading
        $ccs811Reading->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/ccs811-readings'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/ccs811-readings');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyCcs811Reading $request
     * @param Ccs811Reading $ccs811Reading
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyCcs811Reading $request, Ccs811Reading $ccs811Reading)
    {
        $ccs811Reading->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyCcs811Reading $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyCcs811Reading $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Ccs811Reading::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
