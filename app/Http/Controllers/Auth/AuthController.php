<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules;

/**
 * Three D Bakery - Authentication Controller
 * 
 * Handles login, registration, and role-based authentication
 * for both Owner (Admin) and Customer accounts.
 */
class AuthController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request
     * 
     * Supports both email and username login
     * Redirects based on user role (owner → admin, customer → dashboard)
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Attempt login with email or username
        $user = User::where('email', $validated['email'])
            ->orWhere('username', $validated['email'])
            ->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }

        // Check if account is active
        if ($user->is_active === false) {
            return back()->withErrors([
                'email' => 'Your account has been deactivated. Please contact support.',
            ])->onlyInput('email');
        }

        // Authenticate the user
        Auth::login($user, $request->has('remember'));

        // Log the login activity
        activity()
            ->causedBy($user)
            ->log('User logged in');

        // Redirect based on role
        return $this->authenticated($request, $user);
    }

    /**
     * Authenticated - Role-based redirection
     */
    protected function authenticated(Request $request, $user)
    {
        if ($user->role === 'owner') {
            return redirect()->route('admin.dashboard')
                ->with('success', 'Welcome back, Admin! Everything looks fresh and ready.');
        }

        return redirect()->route('customer.dashboard')
            ->with('success', 'Welcome back! Ready to order some fresh treats?');
    }

    /**
     * Show the registration form
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle registration request
     * 
     * Only customers can self-register.
     * Owner accounts are pre-created in the database by admin.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => ['nullable', 'string', 'max:20'],
            'terms' => ['required', 'accepted'],
        ]);

        // Create the user (always as customer)
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'role' => 'customer',  // Only customers can register
            'is_active' => true,
        ]);

        // Fire the Registered event (triggers email verification if enabled)
        event(new Registered($user));

        // Optional: Auto-login after registration
        Auth::login($user);

        // Log the registration
        activity()
            ->causedBy($user)
            ->log('New customer registered');

        // Redirect ke halaman home dan set session flash 'registered' untuk trigger JS
        return redirect('/')
            ->with('registered', true)
            ->with('success', 'Selamat datang di Three D Bakery! Akun Anda berhasil dibuat.');
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        $user = Auth::user();

        // Log the logout activity
        activity()
            ->causedBy($user)
            ->log('User logged out');

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('status', 'You have been logged out successfully. See you soon!');
    }
}
