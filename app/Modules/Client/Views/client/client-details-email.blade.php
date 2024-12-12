
<!DOCTYPE html>
<html>
<head>
    <title>Your Login Credentials</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 650px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .button {
            display: inline-block;
            margin-top: 16px;
            padding: 8px 12px;
            background-color: #4B49AC;
            color:white;
            text-decoration: none;
            border-radius: 6px;
        }
        .button:hover {
            background-color:  #37368d;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Hi {{ $client->display_name ?? $client->name }},</h2>
        <p>Welcome to our platform! Below are your login credentials:</p>
        <p>
            <strong>Email:</strong> {{ $client->email }}<br>
            <strong>Password:</strong> {{ $plain_pasword }}
        </p>
        <p>Please keep this information secure.</p>
       
        <p>Click the button below to log in to your account:</p>
        <a href="{{ $login_url }}" class="button">Login to Your Account</a>
        <p>If you have any questions, feel free to contact us.</p>
      
        <p>Best regards,</p>
        <p><strong>{{ $client->company_name }}</strong></p>
    </div>
</body>
</html>
