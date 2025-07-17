{{-- resources/views/filament/pages/user-question.blade.php --}}
@php
    $locale = app()->getLocale();
    $rtlLocales = ['ar', 'he', 'fa', 'ur'];
    $dir = in_array($locale, $rtlLocales, true) ? 'rtl' : 'ltr';
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', $locale) }}" dir="{{ $dir }}" class="{{ $dir === 'rtl' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('user_question.meta_title') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Basic direction-aware tweaks */
        [dir="rtl"] input,
        [dir="rtl"] textarea {
            text-align: right;
        }

        [dir="rtl"] .text-start {
            text-align: right;
        }

        [dir="ltr"] .text-start {
            text-align: left;
        }

        /* Optional: flip inline gap ordering for link/button row if desired */
        [dir="rtl"] .inline-actions {
            flex-direction: row-reverse;
        }
    </style>
</head>

<body class="bg-gray-100 dark:bg-gray-900">

    <div class="max-w-2xl mx-auto p-8 space-y-6">
        <header class="text-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white">{{ __('user_question.title') }}</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-2">{{ __('user_question.subtitle') }}</p>
        </header>

        {{-- Flash success message --}}
        @if (session('status'))
            <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg" role="alert">
                {{ session('status') }}
            </div>
        @endif

        {{-- Validation errors --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-lg" role="alert">
                <p class="font-semibold mb-2">{{ __('user_question.fix_errors') }}</p>
                <ul class="list-disc list-inside space-y-1 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
            <form method="POST" action="{{ route('user.questions.store', request()->route('locale')) }}"
                class="space-y-6">
                @csrf

                {{-- Phone Number --}}
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                        {{ __('user_question.phone_label') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="tel" id="phone" name="phone" required inputmode="tel" pattern="^[+0-9\\s\\-()]{7,20}$"
                        maxlength="20" value="{{ old('phone') }}"
                        placeholder="{{ __('user_question.phone_placeholder') }}"
                        class="p-4 mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primary-500 focus:ring-primary-500">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ __('user_question.phone_help') }}</p>
                </div>

                {{-- Question Text --}}
                <div>
                    <label for="question" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                        {{ __('user_question.question_label') }} <span class="text-red-500">*</span>
                    </label>
                    <textarea id="question" name="question" required rows="6" maxlength="2000"
                        placeholder="{{ __('user_question.question_placeholder') }}"
                        class="p-4 mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-primary-500 focus:ring-primary-500">{{ old('question') }}</textarea>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        {{ __('user_question.question_help', ['max' => 2000]) }}
                    </p>
                </div>

                <div class="inline-actions flex items-center justify-end gap-3">
                    <a href="{{ url('/') }}"
                        class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 underline">
                        {{ __('user_question.cancel') }}
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-5 py-2.5 rounded-lg bg-primary-600 text-white font-medium hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                        {{ __('user_question.submit') }}
                    </button>
                </div>
            </form>
        </section>

        <footer class="text-center text-xs text-gray-500 dark:text-gray-400">
            {{ __('user_question.footer_agree') }}
            <a href="{{ route('privacy.policy', request()->route('locale')) }}"
                class="text-primary-500 hover:underline">
                {{ __('user_question.privacy_policy_link') }}
            </a>.
        </footer>
    </div>

</body>

</html>