@props(['tableType', 'data', 'title', 'icon'])

@php
    $columns = [];
    
    switch($tableType) {
        case 'pendingAdmins':
            $columns = ['Name', 'Hospital', 'Email', 'Username', 'Certificates', 'Actions'];
            break;
        case 'allAdmins':
            $columns = ['Name', 'Hospital', 'Email', 'Username', 'Status', 'Certificates']; 
            break;

        case 'pendingHospitals':
        $columns = ['Doctor', 'Hospital', 'Certification', 'Actions'];
        break;

        case 'patients':
            break;
        case 'diseases':
            break;
        case 'allPatients':
            $columns = ['Name', 'Birthdate', 'Barangay', 'Latest Date Reported', 'Status'];
            break;
        case 'patientRecords':
            $columns = ['Disease', 'Date Reported', 'Date Recovered', 'Status', 'Details'];
            break;
        default:
            $columns = ['Column 1', 'Column 2', 'Column 3', 'Actions'];
    }
@endphp

<div class="p-4 bg-white border border-g-dark rounded-lg">
    <p class="flex items-center space-x-2 text-m text-g-dark mb-4">
        @isset($icon)
            @if($icon)  {{-- Only render if non-empty --}}
                <x-dynamic-component :component="$icon" class="w-7 h-7 text-g-dark" />
            @endif
        @endisset
        <span class="underline">{{ $title }}</span>
    </p>
    <table class="w-full text-left">
        <thead>
            <tr class="text-g-dark border-b">
                @foreach($columns as $column)
                    <th class="p-2">{{ $column }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @if(isset($data) && count($data) > 0)
                @foreach($data as $item)
                    <tr class="border-b">
                       @php
                            $certificateButton = null;

                            if ($tableType === 'pendingAdmins' || $tableType === 'allAdmins') {
                                // Here $item is a User
                                $hospital = $item->hospitals->first();
                                $pivotCertification = $hospital?->pivot?->certification;

                                $certificateButton = $pivotCertification
                                    ? '<button onclick="viewCertificate(\'' . asset('storage/'.$pivotCertification) . '\')"
                                            class="bg-g-dark text-white px-3 py-1 rounded hover:bg-g-dark/80 transition">
                                            View
                                        </button>'
                                    : '<span class="text-gray-500">No certificate</span>';
                            }

                            // Action buttons (only for pending admins)
                            if ($tableType === 'pendingAdmins') {
                                $actionButtons = '
                                    <button type="button"
                                        onclick="openModal(\'approveModal-' . $item->id . '\')"
                                        class="bg-g-dark text-white px-3 py-1 rounded mr-2 hover:bg-g-dark/80 transition">✓</button>

                                    <button type="button"
                                        onclick="openModal(\'rejectModal-' . $item->id . '\')"
                                        class="bg-r-dark text-white px-3 py-1 rounded hover:bg-red-600 transition">✕</button>
                                ';
                            }
                        @endphp
                        
                        @switch($tableType)
                            @case('pendingAdmins')
                            <td class="p-2">
                                    <a href="{{ route('superadmin.view_admin', $item->id) }}" class="text-blue-600 hover:underline">
                                        {{ $item->name }}
                                    </a>
                                </td>
                                <td class="p-2">{{ $item->hospitals->first()->name ?? 'N/A' }}</td>
                                <td class="p-2">{{ $item->email }}</td>
                                <td class="p-2">{{ $item->username }}</td>
                                <td class="p-2">{!! $certificateButton !!}</td>
                                <td class="p-2">{!! $actionButtons !!}</td>
                                @break
                            @case('allAdmins')
                                <td class="p-2">
                                    <a href="{{ route('superadmin.view_admin', $item->id) }}" class="text-blue-600 hover:underline">
                                        {{ $item->name }}
                                    </a>
                                </td>
                                <td class="p-2">{{ $item->hospitals->first()->name ?? 'N/A' }}</td>
                                <td class="p-2">{{ $item->email }}</td>
                                <td class="p-2">{{ $item->username }}</td>
                                <td class="p-2">
                                    @php
                                        $status = $item->status ?? 'Active';
                                        $statusClass = match($status) {
                                            'Active' => 'bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-medium',
                                            'Inactive' => 'bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-medium',
                                            default => 'bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-medium'
                                        };
                                    @endphp
                                    <span class="{{ $statusClass }}">
                                        {{ ucfirst($status) }}
                                    </span>
                                </td>
                                <td class="p-2">{!! $certificateButton !!}</td>
                                
                                {{-- Only show action buttons for pending admins --}}
                                @if($tableType === 'pendingAdmins')
                                    <td class="p-2">{!! $actionButtons !!}</td>
                                @endif
                                @break
                                @case('pendingHospitals')
                                    <td class="p-2">{{ $item->doctor->name ?? 'N/A' }}</td>
                                    <td class="p-2">{{ $item->hospital->name ?? 'N/A' }}</td>
                                    <td class="p-2">
                                        @if($item->certification)
                                            <button onclick="viewCertificate('{{ asset('storage/'.$item->certification) }}')"
                                                class="bg-g-dark text-white px-3 py-1 rounded hover:bg-g-dark/80 transition">
                                                View
                                            </button>
                                        @else
                                            <span class="text-gray-500">No certificate</span>
                                        @endif
                                    </td>
                                    <td class="p-2">
                                        <button 
                                            class="bg-g-dark text-white px-3 py-1 rounded mr-2 hover:bg-g-dark/80 transition">✓</button>
                                        <button 
                                            class="bg-r-dark text-white px-3 py-1 rounded hover:bg-red-600 transition">✕</button>
                                    </td>
                                @break
                            @case('patients')
                                {{-- Add patient row structure here --}}
                                @break
                                
                            @case('diseases')
                                {{-- Add disease row structure here --}}
                                @break

                            {{-- Manage Patients --}}
                            @case('allPatients')
                                <td class="p-2">
                                    <a href="{{ route('admin.view_patients', $item->id) }}" class="text-blue-600 hover:underline">
                                        {{ $item->name }}
                                    </a>
                                </td>
                                <td class="p-2">{{ \Carbon\Carbon::parse($item->birthdate)->format('F j, Y') }}</td>
                                <td class="p-2">{{ $item->barangay?->name ?? 'N/A' }}</td>
                                <td class="p-2">
                                    @php
                                        $latestRecord = $item->patientRecords?->first();
                                        $dateReported = $latestRecord ? \Carbon\Carbon::parse($latestRecord->date_reported)->format('F j, Y') : 'N/A';
                                    @endphp
                                    {{ $dateReported }}
                                </td>
                                <td class="p-2">
                                    @php
                                        $statusType = $latestRecord ? ($latestRecord->patient->status ?? 'No Records') : 'No Records';
                                        $statusClass = $statusType === 'Active' ? 'bg-yellow-100 text-yellow-800' : ($statusType === 'Recovered' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800');
                                    @endphp
                                    <span class="px-2 py-1 rounded text-sm {{ $statusClass }}">
                                        {{ $statusType }}
                                    </span>
                                </td>
                                @break
                            
                            {{-- Patient Medical Records --}}
                            @case('patientRecords')
                                <td class="p-2">{{ $item->disease->specification ?? 'N/A' }}</td>
                                <td class="p-2">{{ \Carbon\Carbon::parse($item->date_reported)->format('F j, Y') }}</td>
                                <td class="p-2">
                                    @if($item->date_recovered)
                                        {{ \Carbon\Carbon::parse($item->date_recovered)->format('F j, Y') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="p-2">
                                    @php
                                        $statusType = 'No Records';
                                        $statusClass = 'bg-gray-100 text-gray-800';
                                        if ($item->date_recovered && $item->recovered_dh_id) {
                                            $statusType = 'Recovered';
                                            $statusClass = 'bg-green-100 text-green-800';
                                        } else {
                                            if ($item->patient->status === 'Active') {
                                                $statusType = 'Active';
                                                $statusClass = 'bg-yellow-100 text-yellow-800';
                                            }
                                        }
                                    @endphp
                                    <span class="px-2 py-1 rounded text-sm {{ $statusClass }}">
                                        {{ $statusType }}
                                    </span>
                                </td>
                                <td class="p-2">
                                    <button 
                                        onclick="showDetails({{ $item->id }})"
                                        class="text-blue-600 hover:underline font-medium">
                                        {{ $item->date_recovered ? 'View' : 'Update' }}
                                    </button>
                                </td>
                                @break

                            @default
                                {{-- Default row structure --}}
                                <td class="p-2">{{ $item->id }}</td>
                                <td class="p-2">{{ $item->name ?? 'N/A' }}</td>
                                <td class="p-2">{{ $item->description ?? 'N/A' }}</td>
                                <td class="p-2">
                                    <button class="bg-g-dark text-white px-3 py-1 rounded">Action</button>
                                </td>
                        @endswitch
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="{{ count($columns) }}" class="p-4 text-center text-gray-500">
                        No data available
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>