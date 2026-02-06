<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? config('app.name') }}</title>

    @vite(['resources/css/app.css'])

    @livewireStyles
    @fluxAppearance
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>
<body class="min-h-screen overflow-x-hidden">
@if(!request()->routeIs('lock-screen'))
    <x-top-bar/>
    <x-bottom-nav/>
@endif
<flux:main>
    {{ $slot }}
    <!-- Watermark -->
    <div class="fixed inset-x-0 bottom-4 flex justify-center pointer-events-none">
        <div class="opacity-20 text-xs uppercase tracking-wider">Password manager — Made in INDIA 🇮🇳</div>
    </div>
</flux:main>
@vite(['resources/js/app.js'])
@livewireScripts
@fluxScripts
</body>
</html>
