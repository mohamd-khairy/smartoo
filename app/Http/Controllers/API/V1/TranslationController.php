<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Translation;
use Illuminate\Http\Request;

class TranslationController extends Controller
{
    public function index(Request $request)
    {
        $translations = Translation::paginate(10);
        if ($translations->isEmpty()) {
            return api_response([], __('general.translation.not_found'), 404);
        }
        return api_response($translations, __('general.translation.index'), 200);
    }

    public function show($locale)
    {
        $translation = Translation::where('code', $locale)->first();
        if (!$translation) {
            return api_response([], __('general.translation.not_found'), 404);
        }
        return api_response($translation, __('general.translation.show'), 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|max:10',
            'key' => 'required|string|max:255',
            'value' => 'required|string',
        ]);

        $translation = Translation::create($data);

        return api_response($translation, __('general.translation.store'), 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'value' => 'required|string',
        ]);

        $translation = Translation::findOrFail($id);

        if (!$translation) {
            return api_response([], __('general.translation.not_found'), 404);
        }

        $translation->update($request->only('value'));

        return api_response($translation, __('general.translation.update'), 200);
    }

    public function destroy($id)
    {
        $translation = Translation::findOrFail($id);

        if (!$translation) {
            return api_response([], __('general.translation.not_found'), 404);
        }

        $translation->delete();

        return api_response([], __('general.translation.destroy'), 200);
    }
}
