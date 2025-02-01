<!DOCTYPE html>
<html>
<head>
    <title>Something Went Wrong</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { 
            background: #f4f4f4; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            padding: 20px;
            box-sizing: border-box;
        }
        .error-container {
            text-align: center;
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            max-width: 400px;
        }
        .logo {
            max-width: 80%;
            height: auto;
            margin-bottom: 20px;
            object-fit: contain;
        }
        @media (max-width: 600px) {
            .error-container {
                padding: 20px;
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="error-container">
        <img src="{{ asset('landing/assets/img/tru-picture.png') }}" alt="Company Logo" class="logo">
        <h1>🚧 Oops! Technical Hiccup</h1>
        <p>Our system is temporarily unavailable. Please try again later.</p>
    </div>
</body>
</html>