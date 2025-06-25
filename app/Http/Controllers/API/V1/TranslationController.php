<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\translations\CreateTranslationRequest;
use App\Http\Requests\translations\UpdateTranslationRequest;
use App\Models\Translation;
use Illuminate\Http\Request;

class TranslationController extends Controller
{
    /**
     * translation index
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $translations = Translation::paginate(10);
        if ($translations->isEmpty()) {
            return api_response([], __('general.translation.not_found'), 404);
        }
        return api_response($translations, __('general.translation.index'), 200);
    }

    /**
     * translation show
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $translation = Translation::where('id', $id)->first();
        if (!$translation) {
            return api_response([], __('general.translation.not_found'), 404);
        }
        return api_response($translation, __('general.translation.show'), 200);
    }

    /**
     * translation store
     * @param CreateTranslationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateTranslationRequest $request)
    {
        $translation = Translation::create($request->validated());

        return api_response($translation, __('general.translation.store'), 201);
    }

    /**
     * translation update
     * @param UpdateTranslationRequest $request
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateTranslationRequest $request, $id)
    {
        $translation = Translation::findOrFail($id);

        if (!$translation) {
            return api_response([], __('general.translation.not_found'), 404);
        }

        $translation->update($request->validated());

        return api_response($translation, __('general.translation.update'), 200);
    }

    /**
     * translation destroy
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        $translation = Translation::findOrFail($id);

        if (!$translation) {
            return api_response([], __('general.translation.not_found'), 404);
        }

        $translation->delete();

        return api_response([], __('general.translation.destroy'), 200);
    }
}
