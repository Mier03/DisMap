@extends('layouts.app')

@section('content')
<div class="bg-[#FDFDFC] dark:bg-[#DCFCE7] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">

    <!-- Disease Monitoring Section -->
    <div class="relative min-h-screen bg-blue-100 flex items-center justify-center p-5">
        <div class="text-center px-5">
            <!-- Title and Subtitle -->
            <h1 class="text-3xl md:text-4xl font-bold text-teal-800 mb-8 text-center p-4" 
                style="font-size: 4rem; text-align: center;">
                Disease Monitoring in Cebu City
            </h1>
            <p class="text-md md:text-lg text-teal-700 mb-10 max-w-2xl mx-auto text-center p-4" 
                style="font-size: 2rem; text-align: center;">
                Real-time disease surveillance and heatmap visualization for effective public health monitoring across all barangays in Cebu City.
            </p>
            
            <!-- Statistics Cards -->
            <div class="flex flex-row md:flex-row justify-center gap-6 mt-10 p-4">
                <!-- Total Cases -->
                <div class="bg-white rounded-lg shadow-md p-4 w-48">
                    <div class="flex items-center space-x-2">
                        <span class="text-teal-600">👤</span>
                        <div>
                            <h2 class="text-2xl font-bold text-teal-800">999</h2>
                            <p class="text-teal-700 text-sm">Total Cases</p>
                        </div>
                    </div>
                </div>
                
                <!-- Total Active Cases -->
                <div class="bg-white rounded-lg shadow-md p-4 w-48">
                    <div class="flex items-center space-x-2">
                        <span class="text-teal-600">➕</span>
                        <div>
                            <h2 class="text-2xl font-bold text-teal-800">99</h2>
                            <p class="text-teal-700 text-sm">Total Active Cases</p>
                        </div>
                    </div>
                </div>
                
                <!-- Total Critical Cases -->
                <div class="bg-white rounded-lg shadow-md p-4 w-48">
                    <div class="flex items-center space-x-2">
                        <span class="text-teal-600">⭐</span>
                        <div>
                            <h2 class="text-2xl font-bold text-teal-800">9</h2>
                            <p class="text-teal-700 text-sm">Total Critical Cases</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-blue-100 {
        background-color: #e6f0fa;
    }
    .text-teal-800 {
        color: #1f5f5b;
    }
    .text-teal-700 {
        color: #2d7d79;
    }
    @media (max-width: 768px) {
        .flex-col {
            flex-direction: row;
        }
        .w-48 {
            width: 100%;
        }
    }
</style>
@endsection
