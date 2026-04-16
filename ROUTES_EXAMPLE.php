<?php

/*
|--------------------------------------------------------------------------
| Three D Bakery - Authentication Routes Configuration Example
|--------------------------------------------------------------------------
|
| This file shows how to set up authentication routes for your Three D Bakery
| application. Add these routes to your routes/web.php file.
|
| Authentication Flow:
| 1. Guest users can access login/register
| 2. After login, users are redirected based on role:
|    - owner → admin.dashboard
|    - customer → customer.dashboard
| 3. Authenticated users can logout
|
*/

use App\Http\Controllers\Auth\AuthController;

Route::middleware('guest')->group(function () {
    // Login Routes
    Route::get('/login', [AuthController::class, 'showLoginForm'])
        ->name('login');
    
    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.post');

    // Registration Routes (Customers Only)
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])
        ->name('register');
    
    Route::post('/register', [AuthController::class, 'register'])
        ->name('register.post');

    // Password Reset Routes (Optional)
    Route::get('/password/reset', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');
    
    Route::post('/password/email', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');
    
    Route::get('/password/reset/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');
    
    Route::post('/password/reset', [NewPasswordController::class, 'store'])
        ->name('password.update');

    // Email Verification (Optional)
    Route::get('/verify-email', [EmailVerificationPromptController::class, '__invoke'])
        ->name('verification.notice');
    
    Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
    
    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});

/**
 * ============================================================================
 * USER DASHBOARD ROUTES (Role-Based)
 * ============================================================================
 */

// Admin/Owner Dashboard
Route::middleware('auth', 'owner')->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/admin/orders', function () {
        return view('admin.orders');
    })->name('admin.orders');

    Route::get('/admin/products', function () {
        return view('admin.products');
    })->name('admin.products');

    Route::get('/admin/customers', function () {
        return view('admin.customers');
    })->name('admin.customers');

    Route::get('/admin/reports', function () {
        return view('admin.reports');
    })->name('admin.reports');

    Route::get('/admin/settings', function () {
        return view('admin.settings');
    })->name('admin.settings');
});

// Customer Dashboard
Route::middleware('auth', 'customer')->group(function () {
    Route::get('/dashboard', function () {
        return view('customer.dashboard');
    })->name('customer.dashboard');

    Route::get('/orders', function () {
        return view('customer.orders');
    })->name('customer.orders');

    Route::get('/order/{id}', function ($id) {
        return view('customer.order-detail', ['order' => $id]);
    })->name('customer.order-detail');

    Route::get('/profile', function () {
        return view('customer.profile');
    })->name('customer.profile');

    Route::get('/addresses', function () {
        return view('customer.addresses');
    })->name('customer.addresses');

    Route::get('/favorites', function () {
        return view('customer.favorites');
    })->name('customer.favorites');
});

/**
 * ============================================================================
 * MIDDLEWARE SETUP
 * ============================================================================
 * 
 * Add these middleware to your app/Http/Kernel.php
 * 
 * protected $routeMiddleware = [
 *     ...
 *     'owner' => \App\Http\Middleware\IsOwner::class,
 *     'customer' => \App\Http\Middleware\IsCustomer::class,
 * ];
 */

/**
 * ============================================================================
 * REQUIRED MIDDLEWARE FILES
 * ============================================================================
 * 
 * Create app/Http/Middleware/IsOwner.php:
 * 
 * <?php
 * namespace App\Http\Middleware;
 * 
 * class IsOwner
 * {
 *     public function handle($request, $next)
 *     {
 *         if (auth()->check() && auth()->user()->role === 'owner') {
 *             return $next($request);
 *         }
 *         return redirect('login');
 *     }
 * }
 * 
 * 
 * Create app/Http/Middleware/IsCustomer.php:
 * 
 * <?php
 * namespace App\Http\Middleware;
 * 
 * class IsCustomer
 * {
 *     public function handle($request, $next)
 *     {
 *         if (auth()->check() && auth()->user()->role === 'customer') {
 *             return $next($request);
 *         }
 *         return redirect('login');
 *     }
 * }
 */
