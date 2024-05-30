<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubscriptionRequest;
use App\Http\Requests\UpdateSubscriptionRequest;
use App\Http\Resources\V1\SubscriptionResource;
use App\Models\Package;
use App\Models\Receipt;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    private $limits = 15;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort = $request->input('sort', 'created_at');
        $direction = $request->input('direction', 'desc');

        $subscriptions = Subscription::orderBy($sort, $direction)
        ->paginate($this->limits);

        return view('admin.subscriptions.index', [
            'subscriptions' => $subscriptions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('role', 'member')->get();
        $packages = Package::get();

        return view('admin.subscriptions.create', ['users' => $users, 'packages' => $packages]); // 传递到视图
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubscriptionRequest $request)
    {
        $data = $request->validated();

        // Retrieve the package using the provided package_id
        $package = Package::findOrFail($data['package_id']);

        // Calculate the end date based on the package duration
        if ($package->duration) {
            $end_date = Carbon::now()->addDays($package->duration);
        } else {
            // If no duration is provided, you might consider this as unlimited
            $end_date = null; // Or use Carbon::now()->addYears(100) if you need a placeholder far in the future
        }

        // Create the subscription
        $subscription = new Subscription();
        $subscription->user_id = $data['user_id'];
        $subscription->package_id = $data['package_id'];
        $subscription->start_date = Now();
        $subscription->end_date = $end_date;
        $subscription->status = 'active';
        $subscription->save();

        // Update the receipt status
        if (isset($data['receipt_id'])) {
            $receipt = Receipt::findOrFail($data['receipt_id']);
            $receipt->processed = true;
            $receipt->save();
        }

        return new SubscriptionResource($subscription);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Subscription $subscription)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Subscription $subscription)
    {
        $users = User::where('role', 'member')->get();
        $packages = Package::get();

        return view('admin.subscriptions.edit', ['subscription' => $subscription, 'users' => $users, 'packages' => $packages]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSubscriptionRequest $request, Subscription $subscription)
    {
        $data = $request->validated();

        $subscription->update($data);

        return new SubscriptionResource($subscription);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscription $subscription)
    {
        $subscription->delete();

        return response()->json(['message' => 'Subscription deleted successfully']);
    }
}
