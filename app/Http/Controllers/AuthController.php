<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Traits\LogsActivity;

class AuthController extends Controller {
    use LogsActivity;

    public function login() {
        return view('auth.login');
    }

    public function register() {
        return view('auth.register');
    }

    public function authenticate(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // ✅ PERBAIKAN: gunakan route() untuk menghasilkan URL
            // Jika ada intended URL (misal sebelumnya akses halaman yang butuh login), pakai intended()
            // Jika tidak, redirect ke route 'my.dashboard'
            return redirect()->intended(route('my.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        Auth::login($user);

        // ✅ redirect ke route 'my.dashboard' sudah benar
        return redirect()->route('my.dashboard');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}

