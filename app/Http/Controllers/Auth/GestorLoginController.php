<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GestorLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login-gestor');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt(array_merge($credentials, ['role' => 'gestor']), $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/gestor/dashboard');
        }

        return back()->withErrors([
            'email' => 'As credenciais estão incorretas ou este usuário não é um gestor.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login/gestor');
    }
}
