<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\plans\CreatePlanRequest;
use App\Http\Requests\plans\UpdatePlanRequest;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /**
     * plan index
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Logic to get all plans
        $plans = Plan::paginate(10);
        return api_response($plans, __('general.plan.index'), 200);
    }

    /**
     * plan show
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        // Logic to get a specific plan
        $plan = Plan::find($id);
        if (!$plan) {
            return api_response(null, __('general.plan.not_found'), 404);
        }
        return api_response($plan, __('general.plan.show'), 200);
    }

    /**
     * plan store
     * @param CreatePlanRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreatePlanRequest $request)
    {
        // Logic to create a new plan
        $plan = Plan::create($request->validated());
        return api_response($plan, __('general.plan.store'), 201);
    }

    /**
     * plan update
     * @param UpdatePlanRequest $request
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdatePlanRequest $request, $id)
    {
        // Logic to update a plan
        $plan = Plan::find($id);
        if (!$plan) {
            return api_response(null, __('general.plan.not_found'), 404);
        }
        $plan->update($request->validated());
        return api_response($plan, __('general.plan.update'), 200);
    }

    /**
     * plan destroy
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        // Logic to delete a plan
        $plan = Plan::find($id);
        if (!$plan) {
            return api_response(null, __('general.plan.not_found'), 404);
        }
        $plan->delete();
        return api_response(null, __('general.plan.destroy'), 200);
    }
}
