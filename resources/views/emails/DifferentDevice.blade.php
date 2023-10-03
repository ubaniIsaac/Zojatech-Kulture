<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unauthorized Device Detected</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            -webkit-text-size-adjust: 100%;
            background-color: #f5f5f5;
            color: #333;
            font-family: Arial, Helvetica, sans-serif;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 5px;
        }

        .header {
            text-align: center;
            margin: 20px 0;
        }

        .header img {
            width: 50px;
            height: 30px;
            vertical-align: middle;
        }

        .header h1 {
            font-weight: 600;
            font-size: 20px;
            color: #333;
            vertical-align: middle;
            display: inline-block;
            margin-left: 5px;
        }

        .content {
            padding: 20px;
            background-color: #ffffff;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .message {
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }

        .details {
            margin-bottom: 20px;
            color: #333;
        }

        .details p {
            margin: 0;
            line-height: 1.5;
        }

        .details a {
            color: #007bff;
            text-decoration: none;
        }

        .button {
        display: inline-block;
        padding: 15px 30px; /* Increase padding for larger button */
        background-color: #007bff;
        color: #e74c3c;
        text-decoration: none;
        border-radius: 5px;
        font-size: 16px; /* Increase font size for bigger text */
        font-weight: bold; /* Make the text bold */
    }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #6a6a6a;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="https://ravebooking.netlify.app/images/awuf.png" alt="company-logo">
            <h1>Kulture</h1>
        </div>
        <div class="content">
            <div class="message" style="color: #e74c3c;">
                <strong>Security Alert!</strong>
            </div>
            <div class="details">
                <p>Hey {{$user->username}},</p>
                <p>We detected a new login on your account and we wanted to confirm it was you.</p>
                <br>
                <p>Device Details</p>
                <br>
                <p><strong>Device ID:</strong> {{$data['device_id']}}</p>
                <p><strong>Device Name:</strong> {{$data['device_name']}}</p>
                <p><strong>Device IP:</strong> {{$data['device_ip']}}</p>
                <p><strong>Device OS:</strong> {{$data['device_os']}}</p>
                <p>Date: {{ date('Y-m-d H:i:s') }}</p>

                <br>
                <p>If this was you, please ignore this email.</p>
                <p>If this was not you, please click the following button to log out this device:</p>
                <br>
                <a href="{{ route('logout.device', ['device_id' => $data['device_id']]) }}" class="button">Logout</a>

                <br>
                <p>Thanks,</p>
            </div>
        </div>
        <div class="footer">
            &copy; 2023 Kulture. All rights reserved.
        </div>
    </div>
</body>

</html>
