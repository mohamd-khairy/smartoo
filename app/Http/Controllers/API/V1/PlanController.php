<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        // Logic to get all palns
        $palns = Plan::paginate(10);
        return api_response($palns, __('general.paln.index'), 200);
    }

    public function show($id)
    {
        // Logic to get a specific paln
        $paln = Plan::find($id);
        if (!$paln) {
            return api_response(null, __('general.paln.not_found'), 404);
        }
        return api_response($paln, __('general.paln.show'), 200);
    }

    public function store(Request $request)
    {
        // Logic to create a new paln
        $paln = Plan::create($request->all());
        return api_response($paln, __('general.paln.store'), 201);
    }

    public function update(Request $request, $id)
    {
        // Logic to update a paln
        $paln = Plan::find($id);
        if (!$paln) {
            return api_response(null, __('general.paln.not_found'), 404);
        }
        $paln->update($request->all());
        return api_response($paln, __('general.paln.update'), 200);
    }

    public function destroy($id)
    {
        // Logic to delete a paln
        $paln = Plan::find($id);
        if (!$paln) {
            return api_response(null, __('general.paln.not_found'), 404);
        }
        $paln->delete();
        return api_response(null, __('general.paln.destroy'), 200);
    }
}
