<!-- resources/views/google-auth/success.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Google Authorization Success</title>
    <style>
        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            font-family: system-ui, -apple-system, sans-serif;
        }
        .token-box {
            background: #f5f5f5;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
            word-break: break-all;
        }
        .instructions {
            white-space: pre-wrap;
            background: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Google Authorization Successful</h1>
        
        <h2>Your Refresh Token:</h2>
        <div class="token-box">
            {{ $refresh_token }}
        </div>

        <h2>Setup Instructions:</h2>
        <div class="instructions">
            {{ $instructions }}
        </div>

        <p><strong>Important:</strong> Store these values securely. The refresh token will only be shown once.</p>
    </div>
</body>
</html>