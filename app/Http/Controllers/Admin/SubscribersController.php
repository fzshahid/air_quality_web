<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Subscriber\BulkDestroySubscriber;
use App\Http\Requests\Admin\Subscriber\DestroySubscriber;
use App\Http\Requests\Admin\Subscriber\IndexSubscriber;
use App\Http\Requests\Admin\Subscriber\StoreSubscriber;
use App\Http\Requests\Admin\Subscriber\UpdateSubscriber;
use App\Models\Subscriber;
use App\Notifications\UserSubscribed;
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

class SubscribersController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexSubscriber $request
     * @return array|Factory|View
     */
    public function index(IndexSubscriber $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Subscriber::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'email', 'created_at'],

            // set columns to searchIn
            ['id', 'email', 'created_at']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.subscriber.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.subscriber.create');

        return view('admin.subscriber.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreSubscriber $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreSubscriber $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Subscriber
        $subscriber = Subscriber::create($sanitized);

        $subscriber->notify(new UserSubscribed());

        if ($request->ajax()) {
            return ['redirect' => url('admin/subscribers'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/subscribers');
    }

    /**
     * Display the specified resource.
     *
     * @param Subscriber $subscriber
     * @throws AuthorizationException
     * @return void
     */
    public function show(Subscriber $subscriber)
    {
        $this->authorize('admin.subscriber.show', $subscriber);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Subscriber $subscriber
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Subscriber $subscriber)
    {
        $this->authorize('admin.subscriber.edit', $subscriber);


        return view('admin.subscriber.edit', [
            'subscriber' => $subscriber,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSubscriber $request
     * @param Subscriber $subscriber
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateSubscriber $request, Subscriber $subscriber)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Subscriber
        $subscriber->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/subscribers'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/subscribers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroySubscriber $request
     * @param Subscriber $subscriber
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroySubscriber $request, Subscriber $subscriber)
    {
        $subscriber->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroySubscriber $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroySubscriber $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Subscriber::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
