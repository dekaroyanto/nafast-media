<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Periksa status user
            if ($user->status !== 'active') {
                Auth::logout();
                return back()->with('error', 'Akun Anda tidak aktif. Silakan hubungi admin.');
            }

            $request->session()->regenerate();

            return $user->role === 'admin'
                ? redirect()->route('menu')
                : redirect()->route('presensi');
        }

        return back()->with('error', 'Username atau password salah.');
    }

    public function registerform()
    {
        $jabatans = Jabatan::all();
        return view('auth.register', compact('jabatans'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'username.required' => 'Username harus diisi',
            'username.unique' => 'Username sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Password tidak cocok',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'jabatan_id' => $request->jabatan_id,
            'role' => 'karyawan',
            'status' => 'inactive',
        ]);

        return redirect()->route('register')->with('success', 'Akun berhasil didaftarkan. Silakan menunggu aktivasi dari admin.');
    }

    public function editProfile()
    {
        $user = Auth::user();
        return view('auth.edit', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'username' => 'required|string|max:255|unique:users,username,' . Auth::id(),
        ]);

        $user = Auth::user();

        if ($user instanceof User) {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->username = $request->username;
            $user->save();
        } else {
            return redirect()->route('profile.edit')->with('error', 'User tidak ditemukan.');
        }

        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui.');
    }


    public function editPassword()
    {
        return view('auth.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                function ($attribute, $value, $fail) use ($request) {
                    if (Hash::check($value, $request->user()->password)) {
                        $fail('Password baru tidak boleh sama dengan password lama.');
                    }
                },
            ],
        ], [
            'current_password.required' => 'Password lama harus diisi.',
            'new_password.required' => 'Password baru harus diisi.',
            'new_password.min' => 'Password baru minimal 8 karakter.',
            'new_password.confirmed' => 'Password baru tidak cocok.',
        ]);

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Password lama tidak sesuai.');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()
            ->route('profile.editPassword')
            ->with('success', 'Password berhasil diubah.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
