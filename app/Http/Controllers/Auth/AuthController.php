<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pelanggan; // Pastikan Model Pelanggan sudah dibuat
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'login' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = [
            'email' => $request->input('login'),
            'password' => $request->input('password'),
        ];

        \Log::info('Login attempt with credentials: ', ['email' => $credentials['email']]);

        // Attempt authentication menggunakan attempt() yang lebih sederhana
        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();
            
            $user = auth()->user();
            \Log::info('Login successful for user: ' . $user->email . ' with role: ' . $user->role);
            
            // Redirect berdasarkan role
            if ($user->role === 'owner') {
                \Log::info('Redirecting owner to admin.dashboard at: ' . route('admin.dashboard'));
                return redirect(route('admin.dashboard'))
                    ->with('success', 'Selamat datang kembali, Owner!');
            }
            
            \Log::info('Redirecting customer to customer.dashboard at: ' . route('customer.dashboard'));
            return redirect(route('customer.dashboard'))
                ->with('success', 'Selamat datang di Three D Bakery!');
        }

        \Log::info('Login failed - invalid credentials');
        return back()
            ->withInput($request->only('login'))
            ->withErrors([
                'login' => 'Kredensial tidak sesuai dengan data kami.',
            ]);
    }

    protected function authenticated(Request $request, $user)
    {
        // Method ini tidak dipakai - redirect dilakukan di login() method
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Simpan user baru ke tabel 'users'
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'pelanggan', // Default untuk registrasi web
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect('/')
            ->with('success', 'Akun berhasil dibuat! Selamat berbelanja.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('status', 'Anda telah berhasil keluar.');
    }
}