<!DOCTYPE html>
<html>
<head>
    <style>
        .otp-container {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
        }
        .otp-code {
            font-size: 32px;
            font-weight: bold;
            color: #0d6efd;
            letter-spacing: 5px;
            text-align: center;
            margin: 20px 0;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="otp-container">
        <h2>Admin Login Verification</h2>
        <p>Hello Admin,</p>
        <p>Your one-time password (OTP) for logging into the portal is:</p>
        <div class="otp-code">{{ $otp }}</div>
        <p>This code is valid for 10 minutes. If you did not request this login, please ignore this email.</p>
        <p>Regards,<br>Test and Notes Team</p>
    </div>
</body>
</html>
