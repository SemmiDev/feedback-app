<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Masjid;
use App\Models\Penceramah;
use App\Helpers\PhonePasswordHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showLoginPengurusMasjidForm()
    {
        return view('auth.login-pengurus-masjid');
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
                    return redirect()->intended(route('dashboard.index'))->with('success', 'Selamat datang kembali!');
                }

                // Create new user in local database
                $user = User::create([
                    'name' => $penceramah->nama_penceramah,
                    'username' => $penceramah->no_hp,
                    'role' => 'penceramah',
                    'id_penceramah' => $penceramah->id,
                    'password' => Hash::make($credentials['password']),
                ]);

                // Auto-login the new user
                Auth::login($user, $request->boolean('remember'));
                $request->session()->regenerate();

                return redirect()->intended(route('dashboard.index'))->with('success', 'Selamat datang! Akun Anda berhasil dibuat dan Anda telah login.');
            }
        }

        // If all checks fail, throw validation exception
        throw ValidationException::withMessages([
            'username' => 'Username atau password tidak sesuai.',
        ]);
    }

    public function loginPengurusMasjid(Request $request)
    {
        $credentials = $request->validate([
            'imapp_id_masjid' => 'required|string',
            'password' => 'required|string',
        ]);

        // First, check if user exists in local database and attempt authentication
        if (Auth::attempt(['id_masjid' => $credentials['imapp_id_masjid'], 'password' => $credentials['password']], $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard.index'))->with('success', 'Selamat datang kembali!');
        }

        // If local authentication fails, check masjid database
        $masjid = Masjid::where('id', $credentials['imapp_id_masjid'])->first();

        if ($masjid) {
            // Check if user with this id_masjid already exists
            $existingUser = User::where('id_masjid', $masjid->id)->first();

            if ($existingUser) {
                // User exists but password doesn't match - check if they're using the input password
                if (Hash::check($credentials['password'], $existingUser->password)) {
                    Auth::login($existingUser, $request->boolean('remember'));
                    $request->session()->regenerate();
                    return redirect()->intended(route('dashboard.index'))->with('success', 'Selamat datang kembali!');
                } else {
                    // Password doesn't match
                    throw ValidationException::withMessages([
                        'password' => 'Password yang Anda masukkan tidak sesuai.',
                    ]);
                }
            } else {
                // Create new user in local database with default password 123456
                $user = User::create([
                    'name' => $masjid->nama_masjid,
                    'username' => Str::slug($masjid->nama_masjid),
                    'role' => 'pengurus_masjid',
                    'id_masjid' => $masjid->id,
                    'password' => Hash::make('123456'),
                ]);

                // Check if the provided password matches the default password
                if ($credentials['password'] === '123456') {
                    // Auto-login the new user
                    Auth::login($user, $request->boolean('remember'));
                    $request->session()->regenerate();
                    return redirect()->intended(route('dashboard.index'))->with('success', 'Selamat datang! Akun Anda berhasil dibuat dengan password default. Silakan ubah password Anda di pengaturan.');
                } else {
                    // Password doesn't match default
                    throw ValidationException::withMessages([
                        'password' => 'Akun baru dibuat dengan password default: 123456. Silakan gunakan password tersebut untuk login.',
                    ]);
                }
            }
        }

        // If masjid not found
        throw ValidationException::withMessages([
            'imapp_id_masjid' => 'ID Masjid tidak ditemukan.',
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
