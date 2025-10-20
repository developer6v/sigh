<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClienteLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login-cliente');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt(array_merge($credentials, ['role' => 'cliente']), $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/cliente/consultas');
        }

        return back()->withErrors([
            'email' => 'As credenciais estão incorretas ou este usuário não é um cliente.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login/cliente');
    }
}
