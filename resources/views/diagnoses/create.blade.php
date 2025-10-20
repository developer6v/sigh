@php
    // Detecta layout de acordo com o tipo de usuário
    $layout = Auth::user()?->role === 'cliente' ? 'app-cliente' : 'app';
@endphp

@extends('layouts.' . $layout)

@section('content')
<div class="max-w-4xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-6 border-b pb-4">
                Diagnóstico da Consulta #{{ $appointment->id }}
            </h2>

            <form method="POST" action="{{ route('diagnoses.store', $appointment) }}" class="space-y-6">
                @csrf

                <!-- Campo CID -->
                <div>
                    <label for="icd_code" class="block text-sm font-medium text-gray-700">
                        CID (Código Internacional de Doenças) - <span class="text-gray-500">Opcional</span>
                    </label>
                    <div class="mt-1">
                        <input type="text" name="icd_code" id="icd_code"
                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-3 transition duration-150 ease-in-out"
                            placeholder="Ex: J45.0 (Asma, não especificada)">
                    </div>
                    <p class="mt-2 text-sm text-gray-500">
                        Preencha com o código CID relevante, se aplicável.
                    </p>
                </div>

                <!-- Campo Descrição -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">
                        Descrição do Diagnóstico <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1">
                        <textarea name="description" id="description" rows="8" required
                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-3 transition duration-150 ease-in-out"
                            placeholder="Detalhe o diagnóstico, achados clínicos e plano de tratamento."></textarea>
                    </div>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Botão de Ação -->
                <div class="flex justify-end">
                    <button type="submit"
                        class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M7.707 10.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V6h-1v5.586L7.707 10.293z" />
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8 6a6 6 0 100-12 6 6 0 000 12z" clip-rule="evenodd" />
                        </svg>
                        Salvar Diagnóstico
                    </button>
                </div>

                <!-- Mensagem de Erro Geral -->
                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-400 p-4 mt-6 rounded-md">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                          clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">
                                    Houve um erro ao tentar salvar o diagnóstico.
                                </h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <ul role="list" class="list-disc pl-5 space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection
