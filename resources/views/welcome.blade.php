<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'DisMap') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            .navbar {
                background-color: #296E5B;
                color: white;
            }
            .stats-card {
                border: 2px solid #296E5B;
                background-color: rgba(255, 255, 255, 0.9);
                backdrop-filter: blur(5px);
            }
            .stats-card h2 {
                color: #296E5B;
            }
            .stats-card p {
                color: #296E5B;
            }
            /* Remove border from body if present */
            body {
                margin: 0;
                padding: 0;
                border: none;
            }
            .text-custom-green {
             color: #296E5B;
            }
        </style>
    </head>
    <body class="bg-g-bg text-[#1b1b18] flex flex-col items-center min-h-screen">
        <header class="w-full max-w-5xl text-sm mb-4">
            <nav class="navbar p-2 flex items-center justify-end gap-4">
                @if (Route::has('login'))
                    @auth
                        @if(Auth::user()->user_type === 'Doctor')
                            <a href="{{ route('admin.home') }}"
                               class="inline-block px-4 py-1 hover:bg-g-light hover:text-g-dark rounded-md text-sm font-medium transition duration-200 text-white">
                                Dashboard
                            </a>
                        @elseif(Auth::user()->user_type === 'Admin')
                            <a href="{{ route('superadmin.home') }}"
                               class="inline-block px-4 py-1 hover:bg-g-light hover:text-g-dark rounded-md text-sm font-medium transition duration-200 text-white">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('welcome') }}"
                               class="inline-block px-4 py-1 hover:bg-g-light hover:text-g-dark rounded-md text-sm font-medium transition duration-200 text-white">
                                You are not authorized
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}"
                           class="inline-block px-4 py-1 hover:bg-g-light hover:text-g-dark rounded-md text-sm font-medium transition duration-200 text-white">
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="inline-block px-4 py-1 hover:bg-g-light hover:text-g-dark rounded-md text-sm font-medium transition duration-200 text-white">
                                Sign up
                            </a>
                        @endif
                    @endauth
                @endif
            </nav>
        </header>

         <!-- Disease Monitoring Section -->
    <div class="relative min-h-screen bg-blue-100 flex items-center justify-center p-5">
        <div class="text-center px-5">
            <!-- Title and Subtitle -->
            <h1 class="text-2xl md:text-4xl font-bold text-custom-green mb-8 text-center p-4" 
                style="font-size: 3.6rem; text-align: center;">
                Disease Monitoring in Cebu City
            </h1>
            <p class="text-md md:text-lg text-custom-green mb-10 max-w-2xl mx-auto text-center p-4" 
                style="font-size: 1.6rem; text-align: center;">
                Real-time disease surveillance and heatmap visualization for effective public health monitoring across all barangays in Cebu City.
            </p>
                
                <!-- Statistics Cards -->
                <div class="flex flex-row justify-center gap-4">
                    <!-- Total Cases -->
                    <div class="stats-card p-4 w-48 flex items-center justify-between">
                        <span class="text-2xl">👤</span>
                        <div class="text-center">
                            <h2 class="text-3xl font-bold">999</h2>
                            <p class="text-base">Total Cases</p>
                        </div>
                    </div>
                    
                    <!-- Total Active Cases -->
                    <div class="stats-card p-4 w-48 flex items-center justify-between">
                        <span class="text-2xl">➕</span>
                        <div class="text-center">
                            <h2 class="text-3xl font-bold">99</h2>
                            <p class="text-base">Total Active Cases</p>
                        </div>
                    </div>
                    
                    <!-- Total Critical Cases -->
                    <div class="stats-card p-4 w-48 flex items-center justify-between">
                        <span class="text-2xl">⭐</span>
                        <div class="text-center">
                            <h2 class="text-3xl font-bold">9</h2>
                            <p class="text-base">Total Critical Cases</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
