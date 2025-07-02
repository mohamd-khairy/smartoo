<!-- resources/views/components/admin-logo.blade.php -->

<div class="flex items-center space-x-3">
    <!-- Logo Image -->
    <img src="{{ url('images/logo.png') }}" alt="Logo" class="h-10  w-auto">

    <!-- Brand Name -->
    <span class="text-xl p-2 font-semibold">{{ config('app.name', 'My Project Name') }}</span>
</div>
