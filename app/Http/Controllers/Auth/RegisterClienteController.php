<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterClienteController extends Controller
{
    /**
     * Exibe o formulário de registro de cliente.
     */
    public function showForm()
    {
        return view('auth.register-cliente');
    }

    /**
     * Processa o registro de um novo cliente.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);

        // Cria o novo usuário com role de cliente
        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => 'cliente',
        ]);

        // Faz login automático após registro
        auth()->login($user);

        // Redireciona para a página de consultas
        return redirect()
            ->route('appointments.index')
            ->with('success', 'Conta criada com sucesso! Bem-vindo(a) ao sistema.');
    }
}
