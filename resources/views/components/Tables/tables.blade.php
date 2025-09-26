@props(['tableType', 'data' => [], 'title' => '', 'icon' => null]) 

@php
    $columns = match($tableType) {
        'pendingAdmins' => ['Name', 'Hospital', 'Email', 'Username', 'Certificates', 'Actions'],
        'allAdmins' => ['Name', 'Hospital', 'Email', 'Username', 'Status', 'Certificates'],
        'pendingHospitals' => ['Doctor', 'Hospital', 'Certification', 'Actions'],
        'allPatients' => ['Name', 'Birthdate', 'Barangay', 'Latest Date Reported', 'Status'],
        'patientRecords' => ['Disease', 'Date Reported', 'Date Recovered', 'Status', 'Details'],
        'diseaseRecords' => ['Name', 'Total Cases', 'Active', 'Recovered', 'Date Reported', 'Patients'],
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
                                <x-tables.certificate-button :certification="$item->hospitals->first()?->pivot?->certification" />
                            </x-tables.td>
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
                                <x-tables.certificate-button :certification="$item->hospitals->first()?->pivot?->certification" />
                            </x-tables.td>
                        @break

                        {{-- Pending Hospitals --}}
                        @case('pendingHospitals')
                            <x-tables.td>{{ $item->doctor_name }}</x-tables.td>
                            <x-tables.td>{{ $item->hospital_name }}</x-tables.td>
                            <x-tables.td>
                                <x-tables.certificate-button :certification="$item->certification" />
                            </x-tables.td>
                            <x-tables.td>
                                <x-tables.action-buttons :id="$item->id" />
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
                                <button class="bg-g-dark text-white px-3 py-1 rounded hover:bg-[#296E5B]/90">
                                    View
                                </button>
                            </x-tables.td>
                        @break

                        {{-- Patient Records --}}
                        @case('patientRecords')
                            <x-tables.td>{{ $item->disease->specification ?? 'N/A' }}</x-tables.td>
                            <x-tables.td>{{ \Carbon\Carbon::parse($item->date_reported)->format('F j, Y') }}</x-tables.td>
                            <x-tables.td>{{ $item->date_recovered ? \Carbon\Carbon::parse($item->date_recovered)->format('F j, Y') : '-' }}</x-tables.td>
                            <x-tables.td>
                                <x-tables.status-badge :status="$item->date_recovered ? 'Recovered' : $item->patient->status" />
                            </x-tables.td>
                            <x-tables.td>
                                <button onclick="showDetails({{ $item->id }})" 
                                        class="text-blue-600 hover:underline font-medium">
                                    {{ $item->date_recovered ? 'View' : 'Update' }}
                                </button>
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
