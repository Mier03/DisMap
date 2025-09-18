@props(['tableType', 'data', 'title', 'icon'])

@php
    $columns = [];
    
    switch($tableType) {
        case 'pendingAdmins':
            $columns = ['Name', 'Hospital', 'Email', 'Username', 'Certificates', 'Actions'];
            break;
        case 'allAdmins':
            $columns = ['Name', 'Hospital', 'Email', 'Username', 'Certificates']; // Removed Actions
            break;
        case 'patients':
            break;
        case 'diseases':
            break;
        default:
            $columns = ['Column 1', 'Column 2', 'Column 3', 'Actions'];
    }
@endphp

<div class="p-4 bg-white border border-g-dark rounded-lg">
    <p class="flex items-center space-x-2 text-m text-g-dark mb-4">
        @if($icon)
            <x-dynamic-component :component="$icon" class="w-7 h-7 text-g-dark" />
        @endif
        <span>{{ $title }}</span>
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
                            // Certificate button (used in both pending and all admins)
                            $certificateButton = $item->certification
                                ? '<button onclick="viewCertificate(\'' . asset('storage/'.$item->certification) . '\')"
                                          class="bg-g-dark text-white px-3 py-1 rounded hover:bg-g-dark/80 transition">
                                          View
                                      </button>'
                                : '<span class="text-gray-500">No certificate</span>';

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
                            @case('allAdmins')
                                <td class="p-2">
                                    <a href="{{ route('superadmin.view_admin', $item->id) }}" class="text-blue-600 hover:underline">
                                        {{ $item->name }}
                                    </a>
                                </td>
                                <td class="p-2">{{ $item->hospitals->first()->name ?? 'N/A' }}</td>
                                <td class="p-2">{{ $item->email }}</td>
                                <td class="p-2">{{ $item->username }}</td>
                                <td class="p-2">{!! $certificateButton !!}</td>
                                
                                {{-- Only show action buttons for pending admins --}}
                                @if($tableType === 'pendingAdmins')
                                    <td class="p-2">{!! $actionButtons !!}</td>
                                @endif
                                @break
                                
                            @case('patients')
                                {{-- Add patient row structure here --}}
                                @break
                                
                            @case('diseases')
                                {{-- Add disease row structure here --}}
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