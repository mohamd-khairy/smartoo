<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\subscriptions\CreateSubscriptionRequest;
use App\Http\Requests\subscriptions\UpdateSubscriptionRequest;
use App\Models\Subscription;
use App\Services\AppleJwtService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    protected $appleJwtService;

    public function __construct(AppleJwtService $appleJwtService)
    {
        $this->appleJwtService = $appleJwtService;
    }

    /**
     * subscription index
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Logic to get all subscriptions
        $subscriptions = Subscription::paginate(10);
        return api_response($subscriptions, __('general.subscription.index'), 200);
    }

    /**
     * Summary of show
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        // Logic to get a specific subscription
        $subscription = Subscription::find($id);
        if (!$subscription) {
            return api_response(null, __('general.subscription.not_found'), 404);
        }
        return api_response($subscription, __('general.subscription.show'), 200);
    }

    /**
     * subscription store
     * @param CreateSubscriptionRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateSubscriptionRequest $request)
    {
        $data = $request->validated();

        $user = auth()->user();

        $appleRes = $this->appleJwtService->verifyTransaction($data['original_transaction_id']);
     
        if ($appleRes && $user) { // ناجح
            $subscription = Subscription::updateOrCreate(
                ['original_transaction_id' => $data['original_transaction_id']],
                [
                    'user_id' => $user->id,
                    'product_id' => $appleRes['productId'],
                    'transaction_id' => $appleRes['transactionId'],
                    'expires_at' => Carbon::createFromTimestampMs($appleRes['expiresDate']),
                    'is_renewal' => false,
                    'status' => $appleRes['isActives'],
                ]
            );

            $user->subscription_id = $subscription->id;
            $user->save();
            return api_response(true, __('general.subscription.store'), 201);
        }

        return api_response(null, __('general.subscription.not_found'), 400);
    }

    /**
     * subscription update
     * @param UpdateSubscriptionRequest $request
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateSubscriptionRequest $request, $id)
    {
        // Logic to update a subscription
        $subscription = Subscription::find($id);
        if (!$subscription) {
            return api_response(null, __('general.subscription.not_found'), 404);
        }
        $subscription->update($request->validated());
        return api_response($subscription, __('general.subscription.update'), 200);
    }

    /**
     * subscription destroy
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
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
