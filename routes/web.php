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

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', function () {
        return 'Login submitted';
    });

    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');

    Route::post('/register', [\App\Http\Controllers\Auth\AuthController::class, 'register'])->name('register.submit');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', function () {
        return 'Logout';
    })->name('logout');
});

// Demo redirects after login
Route::get('/admin', function () {
    return 'Admin Dashboard';
})->middleware('auth')->name('admin.dashboard');

Route::get('/dashboard', function () {
    return 'Customer Dashboard';
})->middleware('auth')->name('customer.dashboard');

Route::get('/password/reset', function () {
    return view('auth.reset-password');
})->name('password.request');
