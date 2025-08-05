<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Penceramah;
use App\Helpers\PhonePasswordHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // First, check if user exists in local database and attempt authentication
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard.index'));
        }

        // If local authentication fails, check peta_dakwah database
        $penceramah = Penceramah::where('no_hp', $credentials['username'])->first();

        if ($penceramah) {
            // Compare password directly with phone number in plain text
            if ($credentials['password'] === $penceramah->no_hp) {
                // Check if user with this id_penceramah already exists
                $existingUser = User::where('id_penceramah', $penceramah->id)->first();

                if ($existingUser) {
                    // Auto-login the existing user
                    Auth::login($existingUser, $request->boolean('remember'));
                    $request->session()->regenerate();
                    return redirect()->intended(route('dashboard.index'))
                        ->with('success', 'Selamat datang kembali!');
                }

                // Create new user in local database
                $user = User::create([
                    'name' => $penceramah->nama_penceramah,
                    'username' => $penceramah->no_hp,
                    'role' => 'penceramah',
                    'id_penceramah' => $penceramah->id,
                    'password' => Hash::make($credentials['password'])
                ]);

                // Auto-login the new user
                Auth::login($user, $request->boolean('remember'));
                $request->session()->regenerate();

                return redirect()->intended(route('dashboard.index'))
                    ->with('success', 'Selamat datang! Akun Anda berhasil dibuat dan Anda telah login.');
            }
        }

        // If all checks fail, throw validation exception
        throw ValidationException::withMessages([
            'username' => 'Username atau password tidak sesuai.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
