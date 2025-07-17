<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserQuestion;

class UserQuestionController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'phone' => ['required', 'string', 'max:20'],
            'question' => ['required', 'string', 'max:2000'],
        ]);

        UserQuestion::create($validated);

        return back()->with('status', __('user_question.status_thanks'));
    }
}
