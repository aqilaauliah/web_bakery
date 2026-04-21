<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Three D Bakery - Login Direct Test</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #f5f5f5 0%, #e8e8e8 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
        h1 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #333;
        }
        .subtitle {
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            font-family: inherit;
            transition: border-color 0.2s;
        }
        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #A8D5BA;
        }
        button {
            width: 100%;
            padding: 12px;
            background: #A8D5BA;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }
        button:hover {
            background: #92c5a8;
        }
        button:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
        .error {
            background: #fee;
            color: #c00;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            border-left: 4px solid #c00;
        }
        .success {
            background: #efe;
            color: #060;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            border-left: 4px solid #060;
        }
        .test-creds {
            background: #f0f0f0;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 12px;
            color: #666;
        }
        .test-creds strong {
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Three D Bakery Login</h1>
        <p class="subtitle">Direct Simple Form - No Complexity</p>

        @if ($errors->any())
        <div class="error">
            <strong>Login Failed!</strong>
            @foreach ($errors->all() as $error)
                <div>• {{ $error }}</div>
            @endforeach
        </div>
        @endif

        <div class="test-creds">
            <strong>Test Credentials:</strong><br>
            Email: ownerbakery@gmail.com<br>
            Password: owner123
        </div>

        <form method="POST" action="{{ route('login.submit') }}" id="loginForm" style="margin-top: 20px;">
            @csrf

            <div class="form-group">
                <label for="login">Email Address</label>
                <input type="email" id="login" name="login" placeholder="Enter email" required value="{{ old('login') }}">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter password" required>
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="remember" value="1">
                    Remember me
                </label>
            </div>

            <button type="submit" id="submitBtn">Login Now</button>
        </form>

        <p style="margin-top: 20px; font-size: 12px; color: #999; text-align: center;">
            Created for direct testing. If redirect works here, the issue is in the main login form styling/JS.
        </p>
    </div>

    <script>
        const form = document.getElementById('loginForm');
        const btn = document.getElementById('submitBtn');

        form.addEventListener('submit', function(e) {
            console.log('Form submitted!');
            console.log('Action:', this.action);
            console.log('Method:', this.method);
            console.log('CSRF Token present:', !!document.querySelector('input[name="_token"]'));
            
            btn.disabled = true;
            btn.textContent = 'Logging in...';
        });

        // Auto-fill test credentials for quick testing
        if (location.search.includes('autofill')) {
            document.getElementById('login').value = 'ownerbakery@gmail.com';
            document.getElementById('password').value = 'owner123';
        }
    </script>
</body>
</html>
