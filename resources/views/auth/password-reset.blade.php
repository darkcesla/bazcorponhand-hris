<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Request</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .header {
            font-size: 24px;
            font-weight: bold;
            color: #333333;
            margin-bottom: 20px;
        }
        .content {
            font-size: 16px;
            color: #555555;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        .button {
            background-color: #fc9904;
            border: none;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 20px;
        }
        .button:hover {
            background-color: #fc9904;
        }
        .footer {
            font-size: 14px;
            color: #777777;
            margin-top: 30px;
            border-top: 1px solid #dddddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            Password Reset Request
        </div>
        <div class="content">
            Dear User,<br><br>
            We received a request to reset your password for the Bazcorp system. Please click the button below to proceed with changing your password.
        </div>
        <a href="{{ route('password.reset', ['token' => $token]) }}" class="button">Reset Password</a>
        <div class="content" style="margin-top: 20px;">
            If you did not request a password reset, please disregard this email or contact our support team if you have any questions.
            <br><br>
            Thank you for using our HRIS.
        </div>
        <div class="footer">
            HR Culture & Engagement | Bazcorp<br>
        </div>
    </div>
</body>
</html>