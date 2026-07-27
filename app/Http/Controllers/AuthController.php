<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('id_user', $request->username)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            $redirect = $user->role === 'admin' 
                ? route('dashboard.pertamina') 
                : route('dashboard.awak');
            return response()->json([
                'success' => true,
                'redirect' => $redirect,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'ID User atau Password salah.',
        ], 401);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ], [
            'new_password.min' => 'Password baru minimal 6 karakter.',
            'confirm_password.same' => 'Konfirmasi password baru tidak cocok.',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password lama tidak sesuai.',
            ], 422);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Password berhasil diperbarui!',
        ]);
    }

    private function redirectBasedOnRole($user)
    {
        if ($user->role === 'admin') {
            return redirect()->route('dashboard.pertamina');
        } else {
            return redirect()->route('dashboard.awak');
        }
    }
}
