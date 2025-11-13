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
    
    @if (session('success'))
        <x-toast type="success" :message="session('success')" />
    @endif

    @if (session('error'))
        <x-toast type="error" :message="session('error')" />
    @endif
    
  <section class="min-h-screen flex flex-col items-center justify-center w-full px-6 pt-24 text-center bg-cover bg-center"
        style="background-image: url({{ asset('images/welcomebg.svg') }});"
        id="welcome-section">

        <div class="relative z-10">
            <h1 class="text-4xl md:text-5xl font-bold text-g-dark mb-4 opacity-0 transform translate-y-8 transition-all duration-700 ease-out [animation-fill-mode:both]"
                data-animate="fadeUp">
                Disease Monitoring in Cebu City
            </h1>
            <p class="text-lg md:text-xl text-g-dark mb-10 max-w-3xl opacity-0 transform translate-y-8 transition-all duration-700 ease-out delay-200 [animation-fill-mode:both]"
                data-animate="fadeUp">
                Real-time disease surveillance and heatmap visualization for effective public health monitoring across all barangays in Cebu City.
            </p>

            <div class="flex flex-col md:flex-row justify-center items-center gap-8 z-10">
                <div class="opacity-0 transform translate-y-8 transition-all duration-700 ease-out delay-300 [animation-fill-mode:both] hover:scale-105 hover:-translate-y-3 transition-all duration-500 ease-out group"
                    data-animate="fadeUp">
                    <x-cards.stat-card :value="$totalCases" label="Total Cases" statCardType="welcome">
                        <x-slot name="icon">
                            @svg('gmdi-people-alt-o', 'h-12 w-12 text-g-dark fill-current transition-transform duration-500 group-hover:scale-110')
                        </x-slot>
                    </x-cards.stat-card>
                </div>
                <div class="opacity-0 transform translate-y-8 transition-all duration-700 ease-out delay-400 [animation-fill-mode:both] hover:scale-105 hover:-translate-y-3 transition-all duration-500 ease-out group"
                    data-animate="fadeUp">
                    <x-cards.stat-card :value="$totalActiveCases" label="Total Active Cases" statCardType="welcome">
                        <x-slot name="icon">
                            @svg('gmdi-search', 'h-12 w-12 text-g-dark fill-current transition-transform duration-500 group-hover:scale-110')
                        </x-slot>
                    </x-cards.stat-card>
                </div>
                <div class="opacity-0 transform translate-y-8 transition-all duration-700 ease-out delay-500 [animation-fill-mode:both] hover:scale-105 hover:-translate-y-3 transition-all duration-500 ease-out group"
                    data-animate="fadeUp">
                    <x-cards.stat-card :value="$totalRecoveredCases" label="Total Critical Cases" statCardType="welcome">
                        <x-slot name="icon">
                            @svg('gmdi-medical-information-o', 'h-12 w-12 text-g-dark fill-current transition-transform duration-500 group-hover:scale-110')
                        </x-slot>
                    </x-cards.stat-card>
                </div>
            </div>
        </div>
    </section>

        <!-- Disease Heatmap Section -->

    <section class="min-h-screen w-full bg-g-bg flex flex-col items-center justify-center px-4 md:px-8 py-16 opacity-0 transform translate-y-12 transition-all duration-800 ease-out">
        <div class="w-full max-w-7xl">
            {{-- Title Section --}}
            <div class="text-center mb-6">
                <h2 class="text-3xl md:text-4xl font-bold text-g-dark mb-2 opacity-0 transform translate-y-8 transition-all duration-600 ease-out">
                    Disease Heatmap
                </h2>
                <p class="text-md md:text-lg text-g-dark opacity-0 transform translate-y-8 transition-all duration-600 ease-out delay-100">
                    Interactive map showing disease distribution across Cebu City barangays.
                </p>
            </div>

            {{-- Controls Section - All on one line --}}
            <div class="flex items-center justify-between gap-4 mb-4">
                {{-- Left side: Filters + Search --}}
                <div class="flex items-center gap-3 flex-1 min-w-0">
                    {{-- Filter Button --}}
                   <div class="flex-shrink-0">
                                    <button
                                        id="openFilterModal"
                                        class="group flex items-center h-[42px] rounded-lg px-4 transition-all duration-300 ease-out bg-white text-g-dark border border-g-dark hover:shadow-md hover:scale-[1.02] active:scale-[0.98]">
                                        <div class="flex items-center">
                                           <div class="transition-transform duration-300 group-hover:scale-110 group-hover:rotate-12 mr-2 [&_svg]:text-g-dark [&_svg]:fill-g-dark">
                                            <x-gmdi-filter-alt-o class="w-4 h-4" />
                                        </div>
                                            <span class="text-sm font-medium transition-all duration-300 group-hover:font-semibold">Filters</span>
                                        </div>
                                    </button>
                                </div>

                    {{-- Search Bar --}}
                    <div class="relative flex-1 min-w-0 opacity-0 transform translate-y-8 transition-all duration-600 ease-out delay-300">
                        <form method="GET" action="{{ route('welcome') }}">
                                        <input type="text" name="term" placeholder="Search diseases, locations..."
                                            value="{{ request('term') }}"
                                            class="w-full rounded-lg px-4 py-2 focus:outline-none focus:ring-1 focus:ring-[#19664E]" style="border: 2.5px solid [#19664E];">
                                    </form>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                            @svg('gmdi-search', 'w-5 h-5 text-gray-400')
                        </div>
                        
                    </div>
                </div>

                {{-- Right side: Request Data Button --}}
               <div class="flex-shrink-0">
                    <button
                        onclick="openModal('requestDataModal')"
                        class="flex items-center h-[42px] rounded-lg px-4 transition-all duration-300 ease-out bg-white text-g-dark border border-g-dark hover:shadow-md hover:scale-[1.02] active:scale-[0.98]">
                        <span class="text-sm font-medium">Request Data</span>
                    </button>
                </div>          
            </div>

            {{-- Active Filters --}}
              <div id="activeFiltersContainer" class="mt-3 flex flex-wrap items-center gap-2">
                                <span class="text-[#19664E] font-medium js-active-filter-span">Active Filters:</span>

                                <div class="server-filters flex flex-wrap items-center gap-2">
                                    {!! $activeFilters !!}
                                </div>
                                {{-- JS-added filters will appear here --}}
                            </div>

                {{-- Map Container --}}
                 <div class="w-full h-[60vh] md:h-[75vh] rounded-lg overflow-hidden shadow-lg border border-g-dark mt-6 opacity-0 transform translate-y-8 transition-all duration-600 ease-out delay-600">
                <div id="heatmap" class="h-full w-full"></div> 
             <!-- <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d62827.591820344635!2d123.84120593429692!3d10.315699291245336!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a9995fb471b24d%3A0x8742b0c395c7a377!2sCebu%20City%2C%20Cebu!5e0!3m2!1sen!2sph!4v1630671470321!5m2!1sen!2sph"
                    width="100%"
                    height="100%"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                ></iframe> -->
            </div>
        </div>
    </section>

    <!-- Compact Team Footer Section -->
    <footer class="bg-g-dark text-white py-8 px-6 opacity-0 transform translate-y-12 transition-all duration-800 ease-out" id="team-section">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold mb-2 opacity-0 transform translate-y-8 transition-all duration-600 ease-out">Our Team</h2>
                <p class="text-g-light text-sm opacity-0 transform translate-y-8 transition-all duration-600 ease-out delay-100">
                    The people behind DisMap
                </p>
            </div>
            <div class="relative mb-6 opacity-0 transform translate-y-8 transition-all duration-600 ease-out delay-200">
                <div class="flex justify-center items-center space-x-6">
                    <div class="text-center team-member transition-all duration-500 transform" data-member="0">
                        <div class="w-12 h-12 mx-auto mb-2 rounded-full bg-g-light flex items-center justify-center text-g-dark text-sm font-bold border-2 border-white/50 shadow transition-all duration-500 team-avatar">
                            EA
                        </div>
                        <h3 class="font-semibold text-xs mb-1 transition-all duration-500 team-name">Elaisha Mae Arias</h3>
                        <p class="text-g-light text-xs transition-all duration-500 team-role">UI/UX Front End</p>
                    </div>
                    <div class="text-center team-member transition-all duration-500 transform" data-member="1">
                        <div class="w-12 h-12 mx-auto mb-2 rounded-full bg-g-light flex items-center justify-center text-g-dark text-sm font-bold border-2 border-white/50 shadow transition-all duration-500 team-avatar">
                            AC
                        </div>
                        <h3 class="font-semibold text-xs mb-1 transition-all duration-500 team-name">Adrianne John Camus</h3>
                        <p class="text-g-light text-xs transition-all duration-500 team-role">UI/UX Front End</p>
                    </div>
                    <div class="text-center team-member transition-all duration-500 transform" data-member="2">
                        <div class="w-12 h-12 mx-auto mb-2 rounded-full bg-g-light flex items-center justify-center text-g-dark text-sm font-bold border-2 border-white/50 shadow transition-all duration-500 team-avatar">
                            AM
                        </div>
                        <h3 class="font-semibold text-xs mb-1 transition-all duration-500 team-name">Angelina Mier</h3>
                        <p class="text-g-light text-xs transition-all duration-500 team-role">Project Lead</p>
                    </div>
                    <div class="text-center team-member transition-all duration-500 transform" data-member="3">
                        <div class="w-12 h-12 mx-auto mb-2 rounded-full bg-g-light flex items-center justify-center text-g-dark text-sm font-bold border-2 border-white/50 shadow transition-all duration-500 team-avatar">
                            RS
                        </div>
                        <h3 class="font-semibold text-xs mb-1 transition-all duration-500 team-name">Rainelyn Sungahid</h3>
                        <p class="text-g-light text-xs transition-all duration-500 team-role">Back End Developer</p>
                    </div>
                    <div class="text-center team-member transition-all duration-500 transform" data-member="4">
                        <div class="w-12 h-12 mx-auto mb-2 rounded-full bg-g-light flex items-center justify-center text-g-dark text-sm font-bold border-2 border-white/50 shadow transition-all duration-500 team-avatar">
                            MS
                        </div>
                        <h3 class="font-semibold text-xs mb-1 transition-all duration-500 team-name">Mitch Lauren Santillan</h3>
                        <p class="text-g-light text-xs transition-all duration-500 team-role">Back End Developer</p>
                    </div>
                </div>

                <button class="absolute left-2 top-1/2 transform -translate-y-1/2 z-10 bg-white/20 hover:bg-white/30 text-white w-8 h-8 rounded-full flex items-center justify-center transition-all duration-300" onclick="changeHighlight(-1)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                
                <button class="absolute right-2 top-1/2 transform -translate-y-1/2 z-10 bg-white/20 hover:bg-white/30 text-white w-8 h-8 rounded-full flex items-center justify-center transition-all duration-300" onclick="changeHighlight(1)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>

            <div class="flex justify-center gap-2 mb-4 opacity-0 transform translate-y-8 transition-all duration-600 ease-out delay-300">
                <button class="w-2 h-2 rounded-full bg-white transition-all duration-300" onclick="goToHighlight(0)" id="highlight-indicator-0"></button>
                <button class="w-2 h-2 rounded-full bg-white/30 hover:bg-white/50 transition-all duration-300" onclick="goToHighlight(1)" id="highlight-indicator-1"></button>
                <button class="w-2 h-2 rounded-full bg-white/30 hover:bg-white/50 transition-all duration-300" onclick="goToHighlight(2)" id="highlight-indicator-2"></button>
                <button class="w-2 h-2 rounded-full bg-white/30 hover:bg-white/50 transition-all duration-300" onclick="goToHighlight(3)" id="highlight-indicator-3"></button>
                <button class="w-2 h-2 rounded-full bg-white/30 hover:bg-white/50 transition-all duration-300" onclick="goToHighlight(4)" id="highlight-indicator-4"></button>
            </div>

            <!-- Footer Bottom -->
            <div class="border-t border-g-light/20 pt-4 text-center opacity-0 transform translate-y-8 transition-all duration-600 ease-out delay-400">
                <div class="flex flex-col md:flex-row justify-between items-center space-y-2 md:space-y-0">
                    <div class="text-left">
                    </div>
                    <div class="text-g-light text-xs">
                        <p>&copy; 2025 DisMap. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <x-modals.form-modals id="requestDataModal" /> 
     <x-modals.filterModal :barangays="$activeBarangays" :diseases="$activeDiseases" :action="route('welcome')"/>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet.heat/dist/leaflet-heat.js"></script>
    
    <script>
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.remove('opacity-0', 'transform', 'translate-y-12');
                    entry.target.classList.add('opacity-100', 'translate-y-0');
                    
                    const staggerItems = entry.target.querySelectorAll('[class*="opacity-0"][class*="translate-y-8"]');
                    staggerItems.forEach(item => {
                        item.classList.remove('opacity-0', 'transform', 'translate-y-8');
                        item.classList.add('opacity-100', 'translate-y-0');
                    });
                }
            });
        }, observerOptions);

        document.addEventListener('DOMContentLoaded', function() {
            const sections = document.querySelectorAll('section, footer');
            sections.forEach(section => {
                observer.observe(section);
            });
            
            initTeamHighlight();
        });

        function initTeamHighlight() {
            let currentHighlight = 0;
            const totalHighlights = 5;
            let highlightInterval;

            function showHighlight(index) {
                currentHighlight = index;
                
                const teamMembers = document.querySelectorAll('.team-member');
                teamMembers.forEach(member => {
                    const avatar = member.querySelector('.team-avatar');
                    const name = member.querySelector('.team-name');
                    const role = member.querySelector('.team-role');
                    
                    member.classList.remove('scale-110', 'opacity-100');
                    member.classList.add('opacity-60', 'scale-90');
                    avatar.classList.remove('w-16', 'h-16', 'border-4', 'border-white', 'shadow-xl', 'bg-white', 'text-g-dark');
                    name.classList.remove('text-white', 'font-bold', 'text-sm');
                    role.classList.remove('text-white', 'text-xs');
                });
                
                const currentMember = document.querySelector(`[data-member="${index}"]`);
                if (currentMember) {
                    const avatar = currentMember.querySelector('.team-avatar');
                    const name = currentMember.querySelector('.team-name');
                    const role = currentMember.querySelector('.team-role');
                    
                    currentMember.classList.remove('opacity-60', 'scale-90');
                    currentMember.classList.add('scale-110', 'opacity-100');
                    avatar.classList.add('w-16', 'h-16', 'border-4', 'border-white', 'shadow-xl', 'bg-white', 'text-g-dark');
                    name.classList.add('text-white', 'font-bold', 'text-sm');
                    role.classList.add('text-white', 'text-xs');
                }
                
                for (let i = 0; i < totalHighlights; i++) {
                    const indicator = document.getElementById(`highlight-indicator-${i}`);
                    if (i === index) {
                        indicator.classList.remove('bg-white/30', 'hover:bg-white/50');
                        indicator.classList.add('bg-white');
                    } else {
                        indicator.classList.remove('bg-white');
                        indicator.classList.add('bg-white/30', 'hover:bg-white/50');
                    }
                }
            }

            window.changeHighlight = function(direction) {
                let newHighlight = currentHighlight + direction;
                
                if (newHighlight < 0) {
                    newHighlight = totalHighlights - 1; 
                } else if (newHighlight >= totalHighlights) {
                    newHighlight = 0;
                }
                
                showHighlight(newHighlight);
                resetHighlightAutoSlide();
            }

            window.goToHighlight = function(index) {
                showHighlight(index);
                resetHighlightAutoSlide();
            }

            function startHighlightAutoSlide() {
                highlightInterval = setInterval(() => {
                    window.changeHighlight(1); 
                }, 3000); 
            }

            function resetHighlightAutoSlide() {
                clearInterval(highlightInterval);
                startHighlightAutoSlide();
            }

            showHighlight(0); 
            startHighlightAutoSlide();
            
            const teamSection = document.querySelector('.relative');
            if (teamSection) {
                teamSection.addEventListener('mouseenter', () => {
                    clearInterval(highlightInterval);
                });
                
                teamSection.addEventListener('mouseleave', () => {
                    startHighlightAutoSlide();
                });
            }
        }
    </script>

     <script>
        // Pass PHP data to JavaScript
        const filterResults = @json($filterResults);
    </script>

    @vite(['resources/js/heatmap.js'])
</body>
</html>