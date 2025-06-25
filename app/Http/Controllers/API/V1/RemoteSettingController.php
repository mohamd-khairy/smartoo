<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\remote_settings\ChangeLanguageRequest;
use App\Http\Requests\remote_settings\CreateRemoteSettingRequest;
use App\Http\Requests\remote_settings\UpdateRemoteSettingRequest;
use App\Models\RemoteSetting;
use Illuminate\Http\Request;

class RemoteSettingController extends Controller
{
    /**
     * remote setting index
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $remoteSettings = RemoteSetting::paginate(5);

        return api_response($remoteSettings, __('general.remote_settings.index'), 200);
    }

    /**
     * remote setting show
     * @param mixed $country_code
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($country_code)
    {
        // Logic to return a specific remote setting by country code
        $remoteSetting = RemoteSetting::where('country_code', $country_code)->first();

        if (!$remoteSetting) {
            return api_response([], __('general.remote_settings.not_found'), 404);
        }
        return api_response($remoteSetting, __('general.remote_settings.show'), 200);
    }

    /**
     * remote setting update
     * @param UpdateRemoteSettingRequest $request
     * @param mixed $country_code
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRemoteSettingRequest $request, $country_code)
    {
        // Logic to update a specific remote setting by country code
        $remoteSetting = RemoteSetting::where('country_code', $country_code)->first();

        if (!$remoteSetting) {
            return api_response([], __('general.remote_settings.not_found'), 404);
        }

        $remoteSetting->update($request->validated());

        return api_response($remoteSetting, __('general.remote_settings.update'), 200);
    }

    /**
     * remote setting store
     * @param CreateRemoteSettingRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateRemoteSettingRequest $request)
    {
        $remoteSetting = RemoteSetting::create($request->validated());

        return api_response($remoteSetting, __('general.remote_settings.store'), 201);
    }

    /**
     * remote setting destroy
     * @param mixed $country_code
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($country_code)
    {
        // Logic to delete a specific remote setting by country code
        $remoteSetting = RemoteSetting::where('country_code', $country_code)->first();

        if (!$remoteSetting) {
            return api_response([], __('general.remote_settings.not_found'), 404);
        }

        $remoteSetting->delete();

        return api_response([], __('general.remote_settings.destroy'), 200);
    }

    /**
     * remote setting change language
     * @param ChangeLanguageRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeLanguage(ChangeLanguageRequest $request)
    {
        setEnv('APP_LOCALE', $request->locale);
        return api_response(true, 'Language changed successfully', 200);
    }
}
