<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterGestorController extends Controller
{
    /**
     * Exibe o formulário de registro do gestor/médico.
     */
    public function showForm()
    {
        return view('auth.register-gestor');
    }

    /**
     * Processa o registro de um novo gestor/médico.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);

        // Cria o novo usuário com role de gestor
        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => 'gestor',
        ]);

        // Faz login automático após o registro
        auth()->login($user);

        // Redireciona para a lista de consultas do gestor
        return redirect()
            ->route('gestor.appointments.index')
            ->with('success', 'Conta de gestor criada com sucesso! Bem-vindo(a).');
    }
}
