<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\users\CreateUserRequest;
use App\Http\Requests\users\UpdateUserRequest;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * user index
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Logic to get all users
        $users = User::paginate(10);
        return api_response($users, __('general.user.index'), 200);
    }

    /**
     * user show
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        // Logic to get a specific user
        $user = User::find($id);
        if (!$user) {
            return api_response(null, __('general.user.not_found'), 404);
        }
        return api_response($user, __('general.user.show'), 200);
    }

    /**
     * user store
     * @param \App\Http\Requests\users\CreateUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateUserRequest $request)
    {
        // Logic to create a new user
        $user = User::create($request->validated());

        // Check if a new subscription ID is provided in the request
        if ($request->has('subscription_id')) {
            // Check if the provided subscription_id exists in the subscriptions table
            $subscription = Subscription::find($request->subscription_id);

            if ($subscription) {
                // Update the user's subscription_id with the new plan
                $user->subscription()->associate($subscription);
                $user->save();
            }
        }

        return api_response($user, __('general.user.store'), 201);
    }

    /**
     * user update
     * @param \App\Http\Requests\users\UpdateUserRequest $request
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateUserRequest $request,int $id)
    {
        // Logic to update a user
        $user = User::find($id);
        if (!$user) {
            return api_response(null, __('general.user.not_found'), 404);
        }

        $user->update($request->validated());

        // Check if a new subscription ID is provided in the request
        if ($request->has('subscription_id')) {
            // Check if the provided subscription_id exists in the subscriptions table
            $subscription = Subscription::find($request->subscription_id);

            if ($subscription) {
                // Update the user's subscription_id with the new plan
                $user->subscription()->associate($subscription);
                $user->save();
            }
        }

        return api_response($user, __('general.user.update'), 200);
    }

    /**
     * user destroy
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        // Logic to delete a user
        $user = User::find($id);
        if (!$user) {
            return api_response(null, __('general.user.not_found'), 404);
        }
        $user->delete();
        return api_response(null, __('general.user.destroy'), 200);
    }
}
