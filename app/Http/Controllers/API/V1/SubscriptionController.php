<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        // Logic to get all subscriptions
        $subscriptions = Subscription::paginate(10);
        return api_response($subscriptions, __('general.subscription.index'), 200);
    }

    public function show($id)
    {
        // Logic to get a specific subscription
        $subscription = Subscription::find($id);
        if (!$subscription) {
            return api_response(null, __('general.subscription.not_found'), 404);
        }
        return api_response($subscription, __('general.subscription.show'), 200);
    }

    public function store(Request $request)
    {
        // Logic to create a new subscription
        $subscription = Subscription::create($request->all());
        return api_response($subscription, __('general.subscription.store'), 201);
    }

    public function update(Request $request, $id)
    {
        // Logic to update a subscription
        $subscription = Subscription::find($id);
        if (!$subscription) {
            return api_response(null, __('general.subscription.not_found'), 404);
        }
        $subscription->update($request->all());
        return api_response($subscription, __('general.subscription.update'), 200);
    }

    public function destroy($id)
    {
        // Logic to delete a subscription
        $subscription = Subscription::find($id);
        if (!$subscription) {
            return api_response(null, __('general.subscription.not_found'), 404);
        }
        $subscription->delete();
        return api_response(null, __('general.subscription.destroy'), 200);
    }
}
