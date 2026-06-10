<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // --- FITUR LOGIN ---
    public function showLogin() {
        return view('auth.login');
    }

    public function processLogin(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    // --- FITUR DAFTAR (REGISTER) ---
    public function showRegister() {
        return view('auth.register');
    }

    public function processRegister(Request $request) {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', // Harus ada input password_confirmation
        ]);

        // Simpan ke Database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Password di-encrypt
        ]);

        // --- BUAT DOMPET & KATEGORI DEFAULT ---
        \App\Models\Wallet::create([
            'user_id' => $user->id,
            'name' => 'Dompet Utama',
            'type' => 'cash',
            'balance' => 0,
            'icon' => '👛'
        ]);

        $defaultCategories = [
            ['name' => 'Gaji', 'type' => 'income', 'icon' => '💰'],
            ['name' => 'Uang Jajan', 'type' => 'income', 'icon' => '💵'],
            ['name' => 'Makan & Minum', 'type' => 'expense', 'icon' => '🍔'],
            ['name' => 'Transportasi', 'type' => 'expense', 'icon' => '🚗'],
            ['name' => 'Belanja', 'type' => 'expense', 'icon' => '🛍️'],
        ];

        foreach ($defaultCategories as $cat) {
            \App\Models\Category::create([
                'user_id' => $user->id,
                'name' => $cat['name'],
                'type' => $cat['type'],
                'icon' => $cat['icon']
            ]);
        }

        // Langsung login otomatis setelah daftar
        Auth::login($user);

        return redirect('/dashboard');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
