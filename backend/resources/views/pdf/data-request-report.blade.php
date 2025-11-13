<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Request Report</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        
        .report-container {
            width: 100%;
            max-width: 1200px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }
        
        .report-header {
            background: linear-gradient(135deg, #296E5B 0%, #1e4d3f 100%);
            color: white;
            padding: 25px 30px;
        }
        
        .report-title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 15px;
        }
        
        .report-subtitle {
            font-size: 16px;
            font-weight: 400;
            opacity: 0.9;
            margin-bottom: 20px;
        }
        
        .request-info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            background: rgba(255, 255, 255, 0.1);
            padding: 15px;
            border-radius: 6px;
            margin-top: 15px;
        }
        
        .info-item {
            display: flex;
            align-items: flex-start;
        }
        
        .info-label {
            font-weight: 700;
            font-size: 13px;
            margin-right: 8px;
            min-width: 120px;
            opacity: 0.9;
        }
        
        .info-value {
            font-weight: 400;
            font-size: 13px;
            flex: 1;
            line-height: 1.4;
        }
        
        .report-body {
            padding: 0;
        }
        
        .summary-section {
            padding: 20px 30px;
            background: #f8fafc;
            border-bottom: 1px solid #eaeaea;
        }
        
        .summary-text {
            font-size: 14px;
            color: #4b5563;
            font-weight: 500;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th {
            background-color: #f1f5f9;
            color: #296E5B;
            font-weight: 700;
            text-align: left;
            padding: 12px 15px;
            border-bottom: 2px solid #296E5B;
            font-size: 13px;
        }
        
        td {
            padding: 10px 15px;
            border-bottom: 1px solid #eaeaea;
            font-size: 13px;
        }
        
        tr:hover {
            background-color: #f8fafc;
        }
        
        .status {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .status-recovered {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .status-active {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .footer {
            padding: 15px 30px;
            background-color: #f8fafc;
            border-top: 1px solid #eaeaea;
            text-align: center;
            color: #6b7280;
            font-size: 12px;
        }
        
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #6b7280;
            background: #f9fafb;
            margin: 20px;
            border-radius: 8px;
            border: 2px dashed #d1d5db;
        }
        
        .empty-state i {
            font-size: 48px;
            margin-bottom: 10px;
            display: block;
        }
        
        .empty-state p {
            font-size: 16px;
            margin: 10px 0;
        }
        
        .empty-state .sub-message {
            font-size: 14px;
            color: #6b7280;
            margin-top: 10px;
        }
        
        /* Blur effect for sensitive information */
        .blur-sensitive {
            filter: blur(4px);
            -webkit-filter: blur(4px);
            -moz-filter: blur(4px);
            -o-filter: blur(4px);
            -ms-filter: blur(4px);
            color: transparent;
            text-shadow: 0 0 8px rgba(0, 0, 0, 0.5);
        }
        
        .blur-sensitive:hover {
            filter: none;
            -webkit-filter: none;
            -moz-filter: none;
            -o-filter: none;
            -ms-filter: none;
            color: inherit;
            text-shadow: none;
        }
        
        .sensitive-note {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 10px 15px;
            margin: 10px 30px;
            border-radius: 4px;
            font-size: 12px;
            color: #856404;
            text-align: center;
        }
        
        @media (max-width: 768px) {
            .request-info {
                grid-template-columns: 1fr;
            }
            
            .report-header {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="report-container">
        <div class="report-header">
            <div class="report-title">Data Request Report</div>
            <div class="report-subtitle">Disease Surveillance System</div>
            
            <div class="request-info">
                <div class="info-item">
                    <span class="info-label">Requester:</span>
                    <span class="info-value">{{ $dataRequest->name }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Email:</span>
                    <span class="info-value">{{ $dataRequest->email }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Requested Disease:</span>
                    <span class="info-value">{{ $dataRequest->requested_disease }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Date Range:</span>
                    <span class="info-value">
                        {{ $dataRequest->from_date !== 'Not specified' ? \Carbon\Carbon::parse($dataRequest->from_date)->format('F j, Y') : 'Any' }} 
                        to 
                        {{ $dataRequest->to_date !== 'Not specified' ? \Carbon\Carbon::parse($dataRequest->to_date)->format('F j, Y') : 'Any' }}
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Purpose:</span>
                    <span class="info-value">{{ $dataRequest->purpose }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Date Requested:</span>
                    <span class="info-value">{{ $dataRequest->created_at->format('F j, Y') }}</span>
                </div>
            </div>
        </div>
        
        <div class="summary-section">
            <div class="summary-text">
                @if($hasRecords)
                    Found {{ $patientRecords->count() }} record(s) matching the request criteria.
                @else
                    No records found matching the specified criteria.
                @endif
            </div>
        </div>
        
        @if($hasRecords)
        <div class="sensitive-note">
            ⚠️ <strong>Privacy Notice:</strong> Patient names and reporter information have been blurred to protect privacy
        </div>
        @endif
        
        <div class="report-body">
            @if($hasRecords)
            <table>
                <thead>
                    <tr>
                        <th>Patient Name</th>
                        <th>Disease</th>
                        <th>Hospital</th>
                        <th>Reported By</th>
                        <th>Status</th>
                        <th>Date Reported</th>
                        <th>Date Recovered</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($patientRecords as $record)
                    <tr>
                        <!-- Blurred Patient Name -->
                        <td class="blur-sensitive">{{ $record->patient->name ?? 'N/A' }}</td>
                        
                        <!-- Disease remains clear -->
                        <td>{{ $record->disease->specification ?? 'N/A' }}</td>
                        
                        <!-- Hospital remains clear -->
                        <td>{{ $record->reportedByDoctorHospital->hospital->name ?? 'N/A' }}</td>
                        
                        <!-- Blurred Reported By -->
                        <td class="blur-sensitive">
                            {{ optional($record->reportedByDoctorHospital?->doctor)->name ? 'Doc. ' . $record->reportedByDoctorHospital->doctor->name : 'N/A' }}
                        </td>
                        
                        <td>
                            <span class="status {{ $record->status === 'recovered' ? 'status-recovered' : 'status-active' }}">
                                {{ ucfirst($record->status) }}
                            </span>
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($record->date_reported)->format('F j, Y') }}
                        </td>
                        <td>
                            {{ $record->date_recovered ? \Carbon\Carbon::parse($record->date_recovered)->format('F j, Y') : '—' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state">
                <i>📄</i>
                <p><strong>No Data Available</strong></p>
                <p class="sub-message">No patient records were found matching your requested criteria.</p>
                <p class="sub-message">Requested Disease: <strong>{{ $dataRequest->requested_disease }}</strong></p>
                @if($dataRequest->from_date !== 'Not specified' || $dataRequest->to_date !== 'Not specified')
                <p class="sub-message">
                    Date Range: 
                    {{ $dataRequest->from_date !== 'Not specified' ? \Carbon\Carbon::parse($dataRequest->from_date)->format('F j, Y') : 'Any' }} 
                    to 
                    {{ $dataRequest->to_date !== 'Not specified' ? \Carbon\Carbon::parse($dataRequest->to_date)->format('F j, Y') : 'Any' }}
                </p>
                @endif
            </div>
            @endif
        </div>
        
        <div class="footer">
            <p>Generated on: {{ $generatedAt }}</p>
            <p>This report was generated automatically in response to a data request.</p>
            <p>Disease Surveillance System © {{ date('Y') }}</p>
        </div>
    </div>
</body>
</html>