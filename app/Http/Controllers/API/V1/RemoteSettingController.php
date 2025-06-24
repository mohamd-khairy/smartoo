<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\RemoteSetting;
use Illuminate\Http\Request;

class RemoteSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $remoteSettings = RemoteSetting::paginate(5);

        return api_response($remoteSettings, ___('general.remote_settings.index'), 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($country_code)
    {
        // Logic to return a specific remote setting by country code
        $remoteSetting = RemoteSetting::where('country_code', $country_code)->first();

        if (!$remoteSetting) {
            return api_response([], ___('general.remote_settings.not_found'), 404);
        }
        return api_response($remoteSetting, ___('general.remote_settings.show'), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $country_code)
    {
        $data = $request->validate([
            'type' => 'required|string|in:json,xml,yaml',
            'value' => 'required|array',
        ]);

        // Logic to update a specific remote setting by country code
        $remoteSetting = RemoteSetting::where('country_code', $country_code)->first();

        if (!$remoteSetting) {
            return api_response([], ___('general.remote_settings.not_found'), 404);
        }

        $remoteSetting->update($data);

        return api_response($remoteSetting, ___('general.remote_settings.update'), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Logic to create a new remote setting
        $data = $request->validate([
            'country_code' => 'required|string|max:10|unique:remote_settings,country_code',
            'type' => 'required|string|in:json,xml,yaml',
            'value' => 'required|array',
        ]);

        $remoteSetting = RemoteSetting::create($data);

        return api_response($remoteSetting, ___('general.remote_settings.store'), 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($country_code)
    {
        // Logic to delete a specific remote setting by country code
        $remoteSetting = RemoteSetting::where('country_code', $country_code)->first();

        if (!$remoteSetting) {
            return api_response([], ___('general.remote_settings.not_found'), 404);
        }

        $remoteSetting->delete();

        return api_response([], ___('general.remote_settings.destroy'), 200);
    }
}
