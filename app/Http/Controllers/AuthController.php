<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $request->validate([
            'login_method' => 'required|in:nik,username',
            'password' => 'required'
        ]);

        $user = null;

        if ($request->login_method === 'nik') {
            $request->validate(['nik' => 'required']);
            $person = Person::where('identityNumber', $request->nik)->first();
            if ($person && $person->user) {
                $user = $person->user;
            }
        } else {
            $request->validate(['username' => 'required']);
            $user = User::where('username', $request->username)->first();
        }

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Login gagal. Cek kembali kredensial Anda.');
        }

        Auth::login($user);
        session()->put('last_active', now());
        config(['session.lifetime' => 600]);
        $user->update(['last_login' => now()]);

        return redirect()->route('dashboard')->with('success', 'Berhasil login.');
    }


    public function logout(Request $request)
    {
        // dd('logout');
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Berhasil logout.');
    }
}
