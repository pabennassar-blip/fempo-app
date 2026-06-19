<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function login()
    {
        return view('admin.login');
    }

    public function authenticate(Request $request)
    {
        // Try to authenticate using email (admin@fempo.local)
        if ($request->username === 'admin' && $request->password === 'pterodactyl') {
            // Direct authentication for admin
            $user = \App\Models\User::where('email', 'admin@fempo.local')->first();
            if ($user) {
                Auth::login($user);
                return redirect()->route('admin.dashboard')->with('success', 'Benvingut a l\'administració');
            }
        }

        return back()->withErrors(['error' => 'Usuari o contrasenya incorrecta'])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}
