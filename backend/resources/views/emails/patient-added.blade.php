<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to Disease Surveillance System</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #296E5B; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background: #f9f9f9; padding: 20px; border: 1px solid #ddd; border-top: none; }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #666; }
        .details-box { background: white; padding: 15px; border-left: 4px solid #296E5B; margin: 15px 0; border-radius: 4px; }
        .credentials { background: #f8f9fa; padding: 15px; border-radius: 4px; margin: 15px 0; }
        .download-app { background: #e8f5e9; padding: 15px; border-radius: 4px; margin: 20px 0; border-left: 4px solid #4CAF50; }
        .app-link { display: inline-block; background: #296E5B; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px; margin-top: 10px; }
        .app-link:hover { background: #1e5345; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome to Disease Surveillance System</h1>
        </div>
        <div class="content">
            <p>Dear {{ $patient->name }},</p>
            
            <p>Your patient account has been successfully created in our Disease Surveillance System.</p>
            
            <div class="details-box">
                <p><strong>Account Details:</strong></p>
                <p><strong>Full Name:</strong> {{ $patient->name }}</p>
                <p><strong>Date of Birth:</strong> {{ \Carbon\Carbon::parse($patient->birthdate)->format('F j, Y') }}</p>
                <p><strong>Sex:</strong> {{ $patient->sex }}</p>
                <p><strong>Ethnicity:</strong> {{ $patient->ethnicity }}</p>
            </div>

            <div class="credentials">
                <p><strong>Login Credentials:</strong></p>
                <p><strong>Email:</strong> {{ $patient->email }}</p>
                <p><strong>Password:</strong> {{ $password }}</p>
                <p><em>For security reasons, please change your password after your first login.</em></p>
            </div>

            <div class="download-app">
                <p><strong>Download Our Mobile App:</strong></p>
                <p>To access your health records and communicate with healthcare providers, please download our mobile application.</p>
                <a href="https://drive.google.com/file/d/1LkwUvJHYPmGxxZZcfQB6qxdTfjBf8mMI/view?usp=drive_link" class="app-link" target="_blank">
                    📱 Download Mobile App
                </a>
                <p><small><strong>Download Link:</strong> https://drive.google.com/file/d/1LkwUvJHYPmGxxZZcfQB6qxdTfjBf8mMI/view?usp=drive_link</small></p>
            </div>
            
            <p>If you have any questions or need assistance, please don't hesitate to contact our support team.</p>
            
            <p>Best regards,<br>Disease Surveillance System Team</p>
        </div>
        <div class="footer">
            <p>This is an automated message. Please do not reply to this email.</p>
        </div>
    </div>
</body>
</html>