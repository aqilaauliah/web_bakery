<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Debug route
Route::post('/debug-login', function (\Illuminate\Http\Request $request) {
    return response()->json([
        'all' => $request->all(),
        'login' => $request->input('login'),
        'password' => $request->input('password'),
        'has_login' => $request->has('login'),
        'has_password' => $request->has('password'),
    ]);
});

Route::get('/check-auth', function () {
    return response()->json([
        'authenticated' => auth()->check(),
        'user' => auth()->user() ? [
            'id' => auth()->user()->id,
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
            'role' => auth()->user()->role,
        ] : null,
    ]);
});

// Test route - simulate login
Route::get('/test-login', function () {
    $user = \App\Models\User::where('email', 'ownerbakery@gmail.com')->first();
    if ($user) {
        auth()->login($user);
        return redirect()->route('admin.dashboard');
    }
    return 'User not found';
});

// Debug login POST (without CSRF for testing)
Route::post('/test-login-post', function (\Illuminate\Http\Request $request) {
    // Test login with Auth::attempt
    $credentials = [
        'email' => $request->input('login'),
        'password' => $request->input('password'),
    ];
    
    \Log::info('Testing login with credentials: ', $credentials);
    
    if (\Illuminate\Support\Facades\Auth::attempt($credentials)) {
        $request->session()->regenerate();
        $user = auth()->user();
        
        \Log::info('Login SUCCESS for user: ' . $user->email . ' with role: ' . $user->role);
        
        return response()->json([
            'status' => 'success',
            'message' => 'Login successful',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ],
            'redirect_to' => $user->role === 'owner' ? route('admin.dashboard') : route('customer.dashboard'),
        ]);
    }
    
    \Log::info('Login FAILED - invalid credentials');
    
    return response()->json([
        'status' => 'failed',
        'message' => 'Invalid credentials',
    ]);
})->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [\App\Http\Controllers\Auth\AuthController::class, 'showLoginForm'])->name('login');
    Route::get('/login-simple', function () {
        return view('auth.login-simple');
    });
    Route::get('/login-direct', function () {
        return view('auth.login-direct');
    });
    Route::post('/login', [\App\Http\Controllers\Auth\AuthController::class, 'login'])->name('login.submit');

    Route::get('/register', [\App\Http\Controllers\Auth\AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [\App\Http\Controllers\Auth\AuthController::class, 'register'])->name('register.submit');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\Auth\AuthController::class, 'logout'])->name('logout');
    
    // Admin Dashboard (untuk owner)
    Route::get('/admin', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Customer Dashboard (untuk pelanggan)
    Route::get('/dashboard', function () {
        return 'Customer Dashboard';
    })->name('customer.dashboard');
});

Route::get('/password/reset', function () {
    return view('auth.reset-password');
})->name('password.request');
