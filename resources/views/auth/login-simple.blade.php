<!DOCTYPE html>
<html>
<head>
    <title>Simple Login Test</title>
    <style>
        body { font-family: Arial; margin: 40px; }
        .form-group { margin-bottom: 15px; }
        input { padding: 8px; width: 300px; }
        button { padding: 10px 20px; cursor: pointer; }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>
    <h1>Three D Bakery - Simple Login Test</h1>
    
    @if ($errors->any())
        <div class="error">
            @foreach ($errors->all() as $error)
                <p>• {{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login.submit') }}">
        @csrf
        
        <div class="form-group">
            <label>Email:</label><br>
            <input type="email" name="login" value="{{ old('login') }}" required>
        </div>
        
        <div class="form-group">
            <label>Password:</label><br>
            <input type="password" name="password" required>
        </div>
        
        <div class="form-group">
            <input type="checkbox" name="remember" value="1">
            <label>Remember me</label>
        </div>
        
        <button type="submit">Login</button>
    </form>

    <hr>
    <p><strong>Test Credentials:</strong></p>
    <p>Email: ownerbakery@gmail.com</p>
    <p>Password: owner123</p>
</body>
</html>
