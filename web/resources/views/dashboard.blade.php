<x-app-layout>
	<div class="bg-[#E8FCEB] flex min-h-screen w-full">
		{{-- Sidebar --}}
		@include('layouts.sidebar')

		{{-- Main Content --}}
		<div class="ml-64 flex-1 py-8 px-8">
			<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
				<div class="overflow-hidden">
					<div class="p-6 bg-inherit text-gray-900">

						{{-- Header --}}
						 <x-page-header title="Dashboard" />

						{{-- Filters + Search --}}
						<div class="mb-4">
							<div class="flex items-center space-x-4">
								<button
									id="openFilterModal"
									class="flex items-center space-x-2 bg-white border border-[#D0EEDF] text-[#19664E] px-3 py-2 rounded-lg shadow-sm hover:bg-[#19664E] hover:text-white transition">
									<x-gmdi-filter-alt-o class="w-4 h-4" />
									<span class="text-sm">Filters</span>
								</button>

								<div class="relative flex-1 max-w-[1050px]">
									<input type="text" placeholder="Search diseases, locations..."
										class="w-full rounded-lg px-4 py-2 focus:outline-none focus:ring-1 focus:ring-[#19664E]" style="border: 1px solid #E9FBF0;">
								</div>
							</div>

							<div id="activeFiltersContainer" class="mt-3 flex items-center space-x-3">
								<span class="text-[#19664E] font-medium">Active Filters:</span>
								<span class="bg-white text-[#19664E] px-3 py-1 rounded-full shadow text-sm">Lahug</span>
							</div>
						</div>

						

						{{-- Map Section --}}
						<div class="mt-2">
							<div class="rounded-lg overflow-hidden bg-white shadow-sm">
								<div class="h-[420px] w-full">
									<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3931.0165935698957!2d123.88543621535366!3d10.315699992630037!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a9995be0b9b20f%3A0x6f59709d20b9e7b3!2sCebu%20City!5e0!3m2!1sen!2sph!4v1631181589709!5m2!1sen!2sph"
										width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
								</div>
							</div>

							{{-- Legend centered --}}
							<div class="flex justify-center text-sm text-gray-700 mt-4 gap-8">
								<span class="text-[#4CAF50]">Low (0 - 100)</span>
								<span class="text-[#FFC107]">Medium (101 - 250)</span>
								<span class="text-[#FF9800]">High (251 - 400)</span>
								<span class="text-[#F44336]">Critical (500+)</span>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>

	{{-- Merged Filter Modal into the pop-up-modals component. Pass data here. --}}
	<x-modals.pop-up-modals :barangays="$barangays" :diseases="$diseases" />

</x-app-layout>
