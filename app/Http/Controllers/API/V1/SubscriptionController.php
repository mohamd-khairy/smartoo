<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\subscriptions\CreateSubscriptionRequest;
use App\Http\Requests\subscriptions\UpdateSubscriptionRequest;
use App\Models\Subscription;
use App\Services\AppleJwtService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        return DB::transaction(function () use ($request) {
            $data = $request->validated();

            $user = auth()->user();

            $appleRes = $this->appleJwtService->verifyTransaction($data['original_transaction_id']);

            if ($appleRes && $user) { // ناجح
                $subscription = Subscription::updateOrCreate(
                    ['original_transaction_id' => $data['original_transaction_id']],
                    [
                        'user_id' => $user->id,
                        'product_id' => $appleRes['productId'] ?? null,
                        'transaction_id' => $appleRes['transactionId'] ?? null,
                        'expires_at' => isset($appleRes['expiresDate']) ? Carbon::createFromTimestampMs($appleRes['expiresDate']) : null,
                        'is_renewal' => true,
                        'status' => $appleRes['isActive'] ? 'active' : 'inactive',
                        'type' => $appleRes['environment'] ?? 'Sandbox',
                        'data' => $appleRes ?? [],
                    ]
                );

                if ($subscription) {
                    $user->subscription_id = $subscription->id;
                    $user->save();
                }
                return api_response(true, __('general.subscription.store'), 201);
            }

            return api_response(null, __('general.subscription.not_found'), 400);
        });
    }

    /**
     * @hideFromAPIDocumentation
     */
    public function webhookHandle(Request $request)
    {
        $data = $this->appleJwtService->verifyWebhook($request);

        if ($data && isset($data['transactionId']) && isset($data['expiresAt'])) {

            $subscription = Subscription::where('transaction_id', $data['transactionId'])->first();
            // Update subscription in DB
            $subscription->expires_at = isset($data['expiresAt']) ? $data['expiresAt'] : null;
            $subscription->status = $data['isActive'];
            $subscription->save();

            info("Subscription {$subscription->id} with {$subscription->transaction_id} checked: " . ($data['isActive'] ? 'active' : 'expired'));

            return api_response($subscription, __('general.subscription.update'), 200);
        }

        return api_response(null, __('general.subscription.not_found'), 404);
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
