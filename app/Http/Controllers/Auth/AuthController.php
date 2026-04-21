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
        // Validasi: field 'login' bisa diisi email atau username
        $validated = $request->validate([
            'login' => ['required', 'string'], 
            'password' => ['required', 'string'],
        ]);

        // Cari user berdasarkan email ATAU username
        $user = User::where('email', $validated['login'])
            ->orWhere('username', $validated['login'])
            ->first();

        // Validasi password
        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return back()->withErrors([
                'login' => 'Kredensial yang diberikan tidak cocok dengan data kami.',
            ])->onlyInput('login');
        }

        // Proses Login
        Auth::login($user, $request->has('remember'));

        // Redirect berdasarkan role (owner atau pelanggan)
        return $this->authenticated($request, $user);
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->role === 'owner') {
            return redirect()->route('admin.dashboard')
                ->with('success', 'Selamat datang kembali, Owner!');
        }

        return redirect()->route('customer.dashboard') // Sesuaikan dengan route kamu
            ->with('success', 'Selamat datang di Three D Bakery!');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:50', 'unique:user,username'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:user,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'nama' => ['required', 'string', 'max:100'],
            'no_tlp' => ['nullable', 'string', 'max:15'],
            'alamat' => ['nullable', 'string'],
        ]);

        // 1. Simpan ke tabel 'user'
        $user = User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'pelanggan', // Default untuk registrasi web
        ]);

        // 2. Simpan profil ke tabel 'pelanggan' (Sesuai ERD kamu)
        Pelanggan::create([
            'id_user' => $user->id_user,
            'nama' => $validated['nama'],
            'no_tlp' => $validated['no_tlp'],
            'alamat' => $validated['alamat'],
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