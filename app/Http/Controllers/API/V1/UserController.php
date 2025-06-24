<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Logic to get all users
        $users = User::paginate(10);
        return api_response($users, __('general.user.index'), 200);
    }

    public function show($id)
    {
        // Logic to get a specific user
        $user = User::find($id);
        if (!$user) {
            return api_response(null, __('general.user.not_found'), 404);
        }
        return api_response($user, __('general.user.show'), 200);
    }

    public function store(Request $request)
    {
        // Logic to create a new user
        $user = User::create($request->all());
        return api_response($user, __('general.user.store'), 201);
    }

    public function update(Request $request, $id)
    {
        // Logic to update a user
        $user = User::find($id);
        if (!$user) {
            return api_response(null, __('general.user.not_found'), 404);
        }
        $user->update($request->all());
        return api_response($user, __('general.user.update'), 200);
    }

    public function destroy($id)
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
