<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'DisMap') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-gray-900 flex flex-col min-h-screen">

    <header class="w-full shadow-md fixed top-0 left-0 z-50">
        <nav class="bg-g-dark text-white px-6 py-3 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="text-lg font-semibold tracking-wide">DisMap</div>
            </div>
            <div class="flex items-center gap-2 text-sm font-medium">
                @auth
                    <a href="{{ url('/dashboard') }}" class="px-4 py-2 rounded-md hover:bg-g-light hover:text-g-dark transition">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="bg-white text-g-dark px-4 py-2 rounded-md hover:bg-g-light transition">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-4 py-2 rounded-md hover:bg-g-light hover:text-g-dark transition">Sign up</a>
                    @endif
                @endauth
            </div>
        </nav>
    </header>

    <section class="min-h-screen flex flex-col items-center justify-center w-full px-6 pt-24 text-center bg-cover bg-center"
        style="background-image: url({{ Vite::asset('resources/svg/welcomebg.svg') }});">

        <div class="relative z-10">
            <h1 class="text-4xl md:text-5xl font-bold text-g-dark mb-4">
                Disease Monitoring in Cebu City
            </h1>
            <p class="text-lg md:text-xl text-g-dark mb-10 max-w-3xl">
                Real-time disease surveillance and heatmap visualization for effective public health monitoring across all barangays in Cebu City.
            </p>

            <div class="flex flex-col md:flex-row justify-center items-center gap-8 z-10">
                <x-stat-card :value="$totalCases" label="Total Cases">
                    <x-slot name="icon">
                        <img src="{{ Vite::asset('resources/svg/gmdi-people-alt-o.svg') }}" alt="Total Cases Icon" class="h-12 w-12">
                    </x-slot>
                </x-stat-card>
                <x-stat-card :value="$totalActiveCases" label="Total Active Cases">
                    <x-slot name="icon">
                        <img src="{{ Vite::asset('resources/svg/gmdi-person-search-o.svg') }}" alt="Total Active Cases Icon" class="h-12 w-12">
                    </x-slot>
                </x-stat-card>
                <x-stat-card :value="$totalCriticalCases" label="Total Critical Cases">
                    <x-slot name="icon">
                        <img src="{{ Vite::asset('resources/svg/gmdi-medical-information-o.svg') }}" alt="Total Critical Cases Icon" class="h-12 w-12">
                    </x-slot>
                </x-stat-card>
            </div>
        </div>
    </section>

    <section id="heatmap" class="min-h-screen w-full bg-g-bg flex flex-col items-center justify-center px-4 md:px-8 py-16">
        <div class="text-center mb-6">
            <h2 class="text-3xl md:text-4xl font-bold text-g-dark mb-2">
                Disease Heatmap
            </h2>
            <p class="text-md md:text-lg text-g-dark">
                Interactive map showing disease distribution across Cebu City barangays.
            </p>
        </div>

        <div class="w-full max-w-4xl flex items-baseline gap-4 mb-6">
            <div class="flex-grow">
                <x-search-bar placeholder="Search diseases, locations..." />
            </div>

            <button
                onclick="openModal('requestDataModal')"
                class="border border-g-dark text-g-dark bg-white px-4 py-2 rounded-lg hover:bg-[#F2F2F2]/90 transition shrink-0">
                Request Data
            </button>
        </div>

        <div class="text-sm text-g-dark">
            <span class="font-semibold">Active Filters:</span>
            <span class="inline-block bg-g-light text-g-dark px-3 py-1 rounded-full text-xs">Lahug</span>
        </div>

        <div class="w-full max-w-7xl h-[60vh] md:h-[75vh] rounded-lg overflow-hidden shadow-lg border border-g-dark mt-6">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d62827.591820344635!2d123.84120593429692!3d10.315699291245336!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a9995fb471b24d%3A0x8742b0c395c7a377!2sCebu%20City%2C%20Cebu!5e0!3m2!1sen!2sph!4v1630671470321!5m2!1sen!2sph"
                width="100%"
                height="100%"
                style="border:0;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
            ></iframe>
        </div>
    </section>

    {{-- Make sure this modal component exists --}}
    {{-- <x-modals.form-modals id="requestDataModal" /> --}}
</body>
</html>