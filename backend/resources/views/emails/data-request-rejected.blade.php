<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Request Status Update</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #dc3545; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background: #f9f9f9; padding: 20px; border: 1px solid #ddd; border-top: none; }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #666; }
        .details-box { background: white; padding: 15px; border-left: 4px solid #dc3545; margin: 15px 0; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Data Request Update</h1>
        </div>
        <div class="content">
            <p>Dear {{ $dataRequest->name }},</p>
            
            <p>We regret to inform you that your data request could not be approved at this time.</p>
            
            <div class="details-box">
                <p><strong>Request Details:</strong></p>
                <p><strong>Requested Data:</strong> {{ $dataRequest->requested_disease ?? 'N/A' }}</p>
                <p><strong>Date Range:</strong> 
                    @if($dataRequest->from_date && $dataRequest->to_date)
                        {{ \Carbon\Carbon::parse($dataRequest->from_date)->format('F j, Y') }} to {{ \Carbon\Carbon::parse($dataRequest->to_date)->format('F j, Y') }}
                    @else
                        All available data
                    @endif
                </p>
                <p><strong>Purpose:</strong> {{ $dataRequest->purpose ?? 'N/A' }}</p>
                @if($reason)
                <p><strong>Reason for Decline:</strong> {{ $reason }}</p>
                @endif
            </div>
            
            <p>If you have any questions or would like to submit a new request with additional information, please don't hesitate to contact us.</p>
            
            <p>Best regards,<br>Disease Surveillance System Administrator</p>
        </div>
        <div class="footer">
            <p>This is an automated message. Please do not reply to this email.</p>
        </div>
    </div>
</body>
</html>