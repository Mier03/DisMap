<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Patient Records Report</title>
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
            max-width: 1000px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }
        
        .report-header {
            /* background: linear-gradient(135deg, #296E5B 0%, #1e4d3f 100%); */
              background: #296E5B;
            color: white;
            padding: 25px 30px;
        }
        
        .report-title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 15px;
        }
        
        .report-meta {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }
        
        .meta-item {
            display: flex;
            align-items: center;
        }
        
        .meta-label {
            font-weight: 800;
            font-size: 13px;
            margin-right: 8px;
            min-width: 90px;
        }
        
        .meta-value {
            font-weight: 400;
            font-size: 13px;
            padding: 4px 10px;
            border-radius: 4px;
            flex: 1;
        }
        
        .report-body {
            padding: 0;
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
        
        @media (max-width: 768px) {
            .report-meta {
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
                <div>
                    <div class="report-title">Patient Records Report</div>
                </div>
            <div class="report-meta">
              @if($fromDate && $toDate)
                    <div class="meta-item">
                        <span class="meta-label">Date Range:</span>
                        <span class="meta-value">{{ \Carbon\Carbon::parse($fromDate)->format('F j, Y') }} - {{ \Carbon\Carbon::parse($toDate)->format('F j, Y') }}
</span>
                    </div>
                @endif
                
                @if($isFilterApplied)
                    @if($hospitalId && $hospitalName)
                    <div class="meta-item">
                        <span class="meta-label">Hospital:</span>
                        <span class="meta-value">{{ $hospitalName }}</span>
                    </div>
                    @endif
                    
                    @if($diseaseId && $diseaseName)
                    <div class="meta-item">
                        <span class="meta-label">Disease:</span>
                        <span class="meta-value">{{ $diseaseName }}</span>
                    </div>
                    @endif
                @endif
                
                <div class="meta-item">
                    <span class="meta-label">Generated:</span>
                     <span class="meta-value">{{ \Carbon\Carbon::now('Asia/Manila')->format('M j, Y g:i A') }}</span>
                </div>
            </div>
        </div>
        
        <div class="report-body">
            <table>
                <thead>
                     <tr>
                        <th>Patient Name</th>
                        @if($addDiseaseColumn)
                            <th>Disease</th>
                        @endif
                        @if($addHospitalColumn)
                            <th>Hospital</th>
                        @endif
                        <th>Reported By</th>
                        <th>Recovered By</th>
                        <th>Status</th>
                        <th>Date Reported</th>
                        <th>Date Recovered</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($patientRecords as $record)
                        <tr>
                            <td>{{ $record->patient->name ?? 'N/A' }}</td>
                            @if($addDiseaseColumn)
                                <td>{{ $record->disease->specification ?? 'N/A' }}</td>
                            @endif
                            @if($addHospitalColumn)
                                <td>{{ $record->reportedByDoctorHospital->hospital->name ?? 'N/A' }}</td>
                            @endif
                            <td>
                                {{ optional($record->reportedByDoctorHospital?->doctor)->name ? 'Doc. ' . $record->reportedByDoctorHospital->doctor->name : 'N/A' }}
                            </td>
                            <td>
                                {{ optional($record->recoveredByDoctorHospital?->doctor)->name ? 'Doc. ' . $record->recoveredByDoctorHospital->doctor->name : '—' }}
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
                                {{ $record->date_recovered ? \Carbon\Carbon::parse($record->date_recovered)->format('F j, Y') : 'N/A' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ 6 + ($addDiseaseColumn ? 1 : 0) + ($addHospitalColumn ? 1 : 0) }}">
                                <div class="empty-state">
                                    <i>📄</i>
                                    <p>No records found matching your criteria</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>