<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    //
    public function showlogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
        $user = User::where('username', $credentials['username'])->first();

        if (!$user) {
            return redirect('/login')
                ->with('error', 'Akun tidak ditemukan. Silakan coba lagi.');
        }

        // if ($user->is_active == '0') {
        //     return redirect('/login')
        //         ->with('error', 'Akun tidak aktif. Silakan hubungi admin.');
        // } else {
            if (Auth::attempt($credentials)) {
                if (Auth::user()->jabatan == 'admin') {
                    return redirect('/admin/dashboard');
                } elseif (Auth::user()->jabatan == 'petugas') {
                    return redirect('/admin/dashboard');
                } elseif (Auth::user()->jabatan == 'anggota') {
                    return redirect('/user/dashboarduser');
                }
            }
        // }

        return redirect('/login')
            ->with('error', 'username atau password salah. Silakan coba lagi.');
    }

//     public function login(Request $request)
// {
//     $credentials = $request->only('username', 'password');

//     if (Auth::attempt($credentials)) {
//         $user = Auth::user();

//         if ($user->role == 'admin' || $user->role == 'petugas') {
//             return redirect('/admin/dashboard');
//         } elseif ($user->role == 'anggota') {
//             return redirect('/user');
//         }
//     } else {
//         return redirect('/login')
//             ->with('error', 'Email atau password salah. Silakan coba lagi.');
//     }

//     return redirect('/login')
//         ->with('error', 'Email atau password salah. Silakan coba lagi.');
// }


// public function showRegister()
// {
//     return view('auth.register');
// }

// public function register(Request $request)
// {
//     $request->validate([
//         'name' => 'required|string|max:255',
//         'alamat' => 'required|string|max:100',
//         'no_tlp' => 'required|string|max:13',
//         'tgl_bergabung' => 'required|date',
//         'email' => 'required|string|email|max:255|unique:users',
//         'password' => 'required|string|min:6|confirmed',
//         'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
//     ]);

//     if ($request->hasFile('foto')) {
//         $file = $request->file('foto');
//         $fileName = $file->getClientOriginalName(); // Memberikan nama unik untuk file
//         $file->move(public_path('storage/fotos/'), $fileName); 
//     } else {
//         $fileName = null; // Atau beri nilai default jika tidak ada file yang diunggah
//     }

//     // Simpan data user ke dalam database
//     $user = User::create([
//         'name' => $request->name,
//         'alamat' => $request->alamat,
//         'no_tlp' => $request->no_tlp,
//         'tgl_bergabung' => $request->tgl_bergabung,
//         'email' => $request->email,
//         'password' => Hash::make($request->password),
//         'role' => 'anggota', 
//         'foto' => $fileName,
//     ]);

//     // Redirect ke halaman login setelah registrasi berhasil
//     return redirect()->route('login')->with('success', 'Registrasi berhasil.');
// }
public function logout(Request $request)
    {
        Auth::logout();

        return redirect('/');
    }
}
