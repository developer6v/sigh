<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login.cliente') }}">
        @csrf

        <h2 class="text-2xl font-semibold mb-6 text-center text-gray-800 dark:text-gray-100">
            Acesso do Paciente
        </h2>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('E-mail')" />
            <x-text-input id="email" class="block mt-1 w-full"
                type="email" name="email" :value="old('email')"
                required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Senha -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Senha')" />
            <x-text-input id="password" class="block mt-1 w-full"
                type="password" name="password"
                required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Lembrar -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                       class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm
                              focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                       name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Lembrar de mim') }}
                </span>
            </label>
        </div>

        <!-- Botões -->
        <div class="flex items-center justify-between mt-6">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100"
                   href="{{ route('password.request') }}">
                    {{ __('Esqueceu a senha?') }}
                </a>
            @endif

            <x-primary-button>
                {{ __('Entrar') }}
            </x-primary-button>
        </div>
    </form>

    <!-- Linha divisória -->
    <div class="my-6 flex items-center justify-center">
        <div class="w-full border-t border-gray-300 dark:border-gray-700"></div>
        <span class="px-3 text-gray-500 dark:text-gray-400 text-sm">ou</span>
        <div class="w-full border-t border-gray-300 dark:border-gray-700"></div>
    </div>

    <!-- Botão de Cadastro -->
    <div class="text-center">
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
            Ainda não tem uma conta?
        </p>
        <a href="{{ route('register.cliente') }}"
           class="inline-flex items-center justify-center px-6 py-2.5 rounded-md font-semibold text-sm shadow-md transition-all duration-200"
           style="background-color:#66c1dd; color:white;">
            Criar nova conta
        </a>
    </div>
</x-guest-layout>
