<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Exibe a tela de login padrão.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Processa o login do usuário autenticado.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();

        // 🔁 Redireciona de acordo com o tipo de usuário
        if ($user->isGestor()) {
            return redirect()->intended('/gestor/consultas');
        }

        return redirect()->intended('/cliente/consultas');
    }

    /**
     * Faz logout e destrói a sessão.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // 🔙 Redireciona para a tela de login do cliente
        return redirect()->route('login.cliente');
    }
}
