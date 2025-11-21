@props(['tableType', 'data' => [], 'title' => '', 'icon' => null]) 

@php
    $columns = match($tableType) {
        'pendingAdmins' => ['Name', 'Hospital', 'Email', 'Username', 'Certificates', 'Actions'],
        'allAdmins' => ['Name', 'Hospital', 'Email', 'Username', 'Status', 'Certificates'],
        'pendingHospitals' => ['Doctor', 'Hospital', 'Certification', 'Actions'],
        'allHospitalRequests' => ['Doctor', 'Hospital', 'Certification', 'Status', 'Date Requested'],
        'pendingDataRequests' => ['Name', 'Email', 'Requested Data', 'Date Requested', 'Actions'],
        'allDataRequests' => ['Name', 'Email', 'Requested Data', 'Date Requested', 'Status'],
        'allPatients' => ['Name', 'Birthdate', 'Barangay', 'Latest Date Reported', 'Status'],
        'patientRecords' => ['Disease', 'Date Reported', 'Date Recovered', 'Status', 'Details'],
        'diseaseRecords' => ['Name', 'Total Cases', 'Active', 'Recovered', 'Date Reported', 'Patients'],
        'diseasePatientRecords' => ['Patient Name', 'Age', 'Barangay', 'Diagnosed', 'Hospital', 'Reported Date', 'Status'],
        default => ['Column 1', 'Column 2', 'Column 3', 'Actions'],
    };
@endphp

{{-- Wrapper --}}
<div class="p-4 bg-white border border-g-dark rounded-lg">
    
    {{-- Title --}}
    <div class="flex items-center space-x-2 mb-4">
        @if($icon)
            <x-dynamic-component :component="$icon" class="w-7 h-7 text-g-dark" />
        @endif
        <h3 class="text-m text-g-dark underline">{{ $title }}</h3>
    </div>

    {{-- Table --}}
    <table class="w-full text-left">
        <thead>
            <tr class="text-g-dark border-b">
                @foreach($columns as $column)
                    <x-tables.th>{{ $column }}</x-tables.th>
                @endforeach
            </tr>
        </thead>
        
        <tbody>
            @forelse($data as $item)
                <tr class="border-b">
                    @switch($tableType)

                        {{-- Pending Admins --}}
                        @case('pendingAdmins')
                            <x-tables.td>
                                <a href="{{ route('superadmin.view_admin', $item->id) }}" 
                                   class="text-blue-600 hover:underline">
                                    {{ $item->name }}
                                </a>
                            </x-tables.td>
                            <x-tables.td>{{ $item->hospitals->first()->name ?? 'N/A' }}</x-tables.td>
                            <x-tables.td>{{ $item->email }}</x-tables.td>
                            <x-tables.td>{{ $item->username }}</x-tables.td>
                             <x-tables.td>
                                 @if($item->hospitals->first()?->pivot?->certification)
                                    <button 
                                        onclick="viewCertificate('{{ asset('storage/'.$item->hospitals->first()->pivot->certification) }}')"
                                        class="bg-g-dark text-white px-3 py-1 rounded hover:bg-g-dark/80 transition">
                                        View
                                    </button>
                                @else
                                    <span class="text-gray-400 italic">No Certificate</span>
                                @endif                            </x-tables.td>
                            <x-tables.td>
                                <x-tables.action-buttons :id="$item->id" />
                            </x-tables.td>
                        @break

                        {{-- All Admins --}}
                        @case('allAdmins')
                            <x-tables.td>
                                <a href="{{ route('superadmin.view_admin', $item->id) }}" 
                                   class="text-blue-600 hover:underline">
                                    {{ $item->name }}
                                </a>
                            </x-tables.td>
                            <x-tables.td>{{ $item->hospitals->first()->name ?? 'N/A' }}</x-tables.td>
                            <x-tables.td>{{ $item->email }}</x-tables.td>
                            <x-tables.td>{{ $item->username }}</x-tables.td>
                            <x-tables.td>
                                <x-tables.status-badge :status="$item->status ?? 'Active'" />
                            </x-tables.td>
                            <x-tables.td>
                                 @if($item->hospitals->first()?->pivot?->certification)
                                    <button 
                                        onclick="viewCertificate('{{ asset('storage/'.$item->hospitals->first()->pivot->certification) }}')"
                                        class="bg-g-dark text-white px-3 py-1 rounded hover:bg-g-dark/80 transition">
                                        View
                                    </button>
                                @else
                                    <span class="text-gray-400 italic">No Certificate</span>
                                @endif
                            </x-tables.td>
                        @break

                        {{-- Pending Hospitals --}}
                        @case('pendingHospitals')
                            <x-tables.td>{{ $item->doctor->name ?? 'N/A' }}</x-tables.td>
                            <x-tables.td>{{ $item->hospital->name ?? 'N/A' }}</x-tables.td>
                            <x-tables.td>
                                @if($item->certification)
                                    <button onclick="viewCertificate('{{ asset('storage/'.$item->certification) }}')"
                                        class="bg-g-dark text-white px-3 py-1 rounded hover:bg-g-dark/80 transition">
                                        View
                                    </button>
                                @else
                                    <span class="text-gray-500">No certificate</span>
                                @endif
                            </x-tables.td>
                            <x-tables.td>
                                <x-tables.action-buttons :id="$item->id" />
                            </x-tables.td>
                        @break

                        {{-- All Hospital Requests --}}
                        @case('allHospitalRequests')
                            <x-tables.td>{{ $item->doctor->name ?? 'N/A' }}</x-tables.td>
                            <x-tables.td>{{ $item->hospital->name ?? 'N/A' }}</x-tables.td>
                            <x-tables.td>
                                @if($item->certification)
                                    <button onclick="viewCertificate('{{ asset('storage/'.$item->certification) }}')"
                                        class="bg-g-dark text-white px-3 py-1 rounded hover:bg-g-dark/80 transition">
                                        View
                                    </button>
                                @else
                                    <span class="text-gray-500">No certificate</span>
                                @endif
                            </x-tables.td>
                            <x-tables.td>
                                <x-tables.status-badge :status="$item->status ?? 'Pending'" />
                            </x-tables.td>
                            <x-tables.td>{{ $item->created_at->format('m/d/Y') }}</x-tables.td>
                        @break

                        {{-- Pending Data Requests --}}
                        {{-- Pending Data Requests --}}
                        @case('pendingDataRequests')
                            <x-tables.td>{{ $item->name }}</x-tables.td>
                            <x-tables.td>{{ $item->email }}</x-tables.td>
                            <x-tables.td>
                                <button onclick="viewRequestedData({{ $item->id }}, 'pending')"
                                    class="bg-g-dark text-white px-3 py-1 rounded hover:bg-g-dark/80 transition">
                                    View
                                </button>
                            </x-tables.td>
                            <x-tables.td>{{ $item->created_at->format('m/d/Y') }}</x-tables.td>
                            <x-tables.td>
                                <x-tables.action-buttons :id="$item->id" />
                            </x-tables.td>
                        @break

                        {{-- All Data Requests --}}
                        @case('allDataRequests')
                            <x-tables.td>{{ $item->name }}</x-tables.td>
                            <x-tables.td>{{ $item->email }}</x-tables.td>
                            <x-tables.td>
                                <button onclick="viewRequestedData({{ $item->id }}, 'all')"
                                    class="bg-g-dark text-white px-3 py-1 rounded hover:bg-g-dark/80 transition">
                                    View
                                </button>
                            </x-tables.td>
                            <x-tables.td>{{ $item->created_at->format('m/d/Y') }}</x-tables.td>
                            <x-tables.td>
                                <x-tables.status-badge :status="$item->status ?? 'Pending'" />
                            </x-tables.td>
                        @break

                        {{-- Manage Patients --}}
                        @case('allPatients')
                            @php
                                // Keep the original logic for latest record & status
                                $latestRecord = $item->patientRecords?->first();
                                $dateReported = $latestRecord ? \Carbon\Carbon::parse($latestRecord->date_reported)->format('F j, Y') : 'N/A';

                                $statusType = $latestRecord ? ($latestRecord->patient->status ?? 'No Records') : 'No Records';
                                $statusClass = $statusType === 'Active'
                                    ? 'bg-yellow-100 text-yellow-800'
                                    : ($statusType === 'Recovered'
                                        ? 'bg-green-100 text-green-800'
                                        : 'bg-gray-100 text-gray-800');
                            @endphp

                            <x-tables.td>
                                <a href="{{ route('admin.view_patients', $item->id) }}" class="text-blue-600 hover:underline">
                                    {{ $item->name }}
                                </a>
                            </x-tables.td>

                            <x-tables.td>{{ \Carbon\Carbon::parse($item->birthdate)->format('F j, Y') }}</x-tables.td>

                            <x-tables.td>{{ $item->barangay?->name ?? 'N/A' }}</x-tables.td>

                            <x-tables.td>{{ $dateReported }}</x-tables.td>

                            <x-tables.td>
                                <span class="px-2 py-1 rounded text-sm {{ $statusClass }}">
                                    {{ $statusType }}
                                </span>
                            </x-tables.td>
                        @break

                        {{-- Disease Records --}}
                        @case('diseaseRecords')
                            <x-tables.td>{{ $item->specification }}</x-tables.td>
                            <x-tables.td>{{ $item->total_cases }}</x-tables.td>
                            <x-tables.td>{{ $item->active }}</x-tables.td>
                            <x-tables.td>{{ $item->recovered }}</x-tables.td>
                            <x-tables.td>
                                {{ optional($item->patientRecords->first())->date_reported
                                    ? \Carbon\Carbon::parse($item->patientRecords->first()->date_reported)->format('F j, Y')
                                    : 'N/A' }}
                            </x-tables.td>
                            <x-tables.td>
                                <a href="{{ route('diseaserecords.details', $item) }}" 
                                class="bg-g-dark text-white px-3 py-1 rounded hover:bg-[#296E5B]/90 transition-colors">
                                    View
                                </a>
                            </x-tables.td>
                        @break

                        {{-- Patient Records --}}
                        @case('patientRecords')
                            {{-- Disease --}}
                            <x-tables.td>{{ $item->disease->specification ?? 'N/A' }}</x-tables.td>

                            {{-- Date Reported --}}
                            <x-tables.td>{{ \Carbon\Carbon::parse($item->date_reported)->format('F j, Y') }}</x-tables.td>

                            {{-- Date Recovered --}}
                            <x-tables.td>
                                @if($item->date_recovered)
                                    {{ \Carbon\Carbon::parse($item->date_recovered)->format('F j, Y') }}
                                @else
                                    -
                                @endif
                            </x-tables.td>

                            {{-- Status --}}
                            <x-tables.td>
                                <x-tables.status-badge :status="$item->date_recovered ? 'Recovered' : $item->patient->status" />
                            </x-tables.td>

                            {{-- Details --}}
                            <x-tables.td>
                                <x-tables.button 
                                    :label="$item->date_recovered ? 'View' : 'Update'" 
                                    onclick="showDetails({{ $item->id }})" 
                                />
                            </x-tables.td>
                        @break

                        {{-- Disease Patient Records --}}
                        @case('diseasePatientRecords')
                            <x-tables.td>
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-g-dark rounded-full flex items-center justify-center text-white font-semibold">
                                        {{ $item['patient']['initial'] }}
                                    </div>
                                    <div class="ml-4">
                                        <a href="{{ route('admin.view_patients', $item['patient']['id']) }}" 
                                        class="text-sm font-medium text-g-dark hover:text-green-800 hover:underline transition-colors">
                                            {{ $item['patient']['name'] }}
                                        </a>
                                        <div class="text-sm text-gray-500">
                                            {{ $item['patient']['gender'] }} {{-- Added gender if available --}}
                                        </div>
                                    </div>
                                </div>
                            </x-tables.td>
                            
                            <x-tables.td>
                                <div class="text-sm text-gray-900">{{ $item['patient']['age'] }}</div>
                            </x-tables.td>
                            
                            <x-tables.td>
                                <div class="text-sm text-gray-900">{{ $item['patient']['barangay'] }}</div>
                            </x-tables.td>
                            
                            <x-tables.td>
                                <div class="text-sm font-medium text-gray-900">{{ $item['disease_specification'] }}</div>
                            </x-tables.td>
                            
                            <x-tables.td>
                                <div class="text-sm text-gray-900">{{ $item['hospital'] }}</div>
                            </x-tables.td>
                            
                            <x-tables.td>
                                <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($item['date_reported'])->format('M j, Y') }}</div>
                            </x-tables.td>
                            
                            <x-tables.td>
                                @php
                                    $statusColors = [
                                        'Active' => 'bg-yellow-100 text-yellow-800',
                                        'Recovered' => 'bg-green-100 text-green-800', 
                                        'Pending' => 'bg-blue-100 text-blue-800',
                                    ];
                                    $color = $statusColors[$item['status']] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $color }}">
                                    {{ $item['status'] }}
                                </span>
                            </x-tables.td>
                        @break


                        {{-- Default fallback --}}
                        @default
                            <x-tables.td>{{ $item->id }}</x-tables.td>
                            <x-tables.td>{{ $item->name ?? 'N/A' }}</x-tables.td>
                            <x-tables.td>{{ $item->description ?? 'N/A' }}</x-tables.td>
                            <x-tables.td>
                                <button class="bg-g-dark text-white px-3 py-1 rounded">Action</button>
                            </x-tables.td>
                    @endswitch
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($columns) }}" class="p-4 text-center text-gray-500">
                        No data available
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
