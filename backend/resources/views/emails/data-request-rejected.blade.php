<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Request Declined</title>
    <style type="text/css">
        body { 
            font-family: Arial, Helvetica, sans-serif; 
            line-height: 1.6; 
            color: #333333; 
            margin: 0; 
            padding: 0; 
            background-color: #f5f5f5;
        }
        .container-dr { 
            max-width: 600px; 
            width: 100%; 
            margin: 20px auto 0 auto; 
            padding: 0; 
        }
        .header-dr { 
            background-color: #dc3545; 
            color: #ffffff; 
            padding: 25px 20px; 
            text-align: left; 
        }
        .content-dr { 
            background-color: #ffffff; 
            padding: 20px; 
            border: 1px solid #dddddd;
            border-top: none;
        }
        .footer { 
            text-align: center; 
            padding: 20px; 
            font-size: 12px; 
            color: #666666; 
            background-color: #f9f9f9;
        }
        .details-box { 
            background-color: #ffffff; 
            padding: 15px; 
            border-left: 4px solid #dc3545; 
            margin: 15px 0; 
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-label {
            font-weight: bold;
            color: #555555;
            padding: 5px 0;
            vertical-align: top;
            width: 140px;
        }
        .info-value {
            padding: 5px 0;
            vertical-align: top;
        }
        .rejection-reason {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 12px;
            margin: 15px 0;
        }
        .header-dr h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
            color: #ffffff;
        }
        p {
            margin: 0 0 15px 0;
        }
        .last-paragraph {
            margin-bottom: 0;
        }
    </style>
</head>
<body>
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f5f5f5;">
        <tr>
            <td style="padding: 20px 0;">
                <table class="container-dr" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td>
                            <!-- Header -->
                            <table class="header-dr" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <h1 style="margin: 0; font-size: 24px; font-weight: bold; color: #ffffff;">Data Request Declined</h1>
                                    </td>
                                </tr>
                            </table>
                            
                            <!-- Content -->
                            <table class="content-dr" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <p>Dear <strong>{{ $dataRequest->name }}</strong>,</p>

                                        <p>We regret to inform you that your data request has been declined by the Disease Surveillance System administration.</p>

                                        <!-- Details Box -->
                                        <table class="details-box" width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td>
                                                    <p style="margin-top: 0; color: #dc3545; font-weight: bold; margin-bottom: 15px;">Request Details:</p>
                                                    
                                                    <table class="info-table" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td class="info-label">Requester:</td>
                                                            <td class="info-value">{{ $dataRequest->name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="info-label">Email:</td>
                                                            <td class="info-value">{{ $dataRequest->email }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="info-label">Requested Disease:</td>
                                                            <td class="info-value">{{ $dataRequest->requested_disease }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="info-label">Date Range:</td>
                                                            <td class="info-value">
                                                                {{ $dataRequest->from_date !== 'Not specified' ? \Carbon\Carbon::parse($dataRequest->from_date)->format('F j, Y') : 'Any' }} 
                                                                to 
                                                                {{ $dataRequest->to_date !== 'Not specified' ? \Carbon\Carbon::parse($dataRequest->to_date)->format('F j, Y') : 'Any' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="info-label">Purpose:</td>
                                                            <td class="info-value">{{ $dataRequest->purpose }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="info-label">Date Requested:</td>
                                                            <td class="info-value">{{ $dataRequest->created_at->format('F j, Y') }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="info-label">Date Declined:</td>
                                                            <td class="info-value">{{ now()->format('F j, Y') }}</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>

                                        @if(isset($rejectionReason) && $rejectionReason)
                                        <!-- Rejection Reason -->
                                        <table class="rejection-reason" width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td>
                                                    <p style="margin-top: 0; color: #dc3545; font-weight: bold; margin-bottom: 10px;">Reason for Decline:</p>
                                                    <p style="margin: 0;">{{ $rejectionReason }}</p>
                                                </td>
                                            </tr>
                                        </table>
                                        @endif

                                        <p>If you have any questions about this decision, please contact the system administrator.</p>

                                        <p>Thank you for your interest in disease surveillance data.</p>

                                        <p class="last-paragraph">Best regards,<br>
                                        <strong>Disease Surveillance System Team</strong></p>
                                    </td>
                                </tr>
                            </table>
                            
                            <!-- Footer -->
                            <table class="footer" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <p>This is an automated message. Please do not reply to this email.</p>
                                        <p>Disease Surveillance System © {{ date('Y') }}</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>