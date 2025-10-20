@php
    $layout = Auth::user()?->role === 'cliente' ? 'app-cliente' : 'app';
@endphp

@extends('layouts.' . $layout)

@section('content')
<div class="flex justify-center py-10 bg-gray-50 dark:bg-gray-900">
    <div class="w-full max-w-lg bg-white dark:bg-gray-800 shadow-xl rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-700">

        <!-- Cabeçalho -->
        <div class="flex items-center gap-3 px-6 py-4" style="background-color:#66c1dd;">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-6 w-6 text-white"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <h2 class="text-lg font-semibold tracking-wide text-white">
                Agendar Nova Consulta
            </h2>
        </div>

        <!-- Conteúdo -->
        <div class="p-8">
            <form method="POST" action="{{ route('appointments.store') }}" class="space-y-6">
                @csrf

                <!-- Médico -->
                <div class="flex flex-col">
                    <label for="doctor_id" class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Médico Responsável
                    </label>
                    <select id="doctor_id" name="doctor_id"
                        class="w-full rounded-md border border-gray-300 dark:border-gray-600 
                               dark:bg-gray-800 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 
                               focus:border-indigo-500 text-sm p-2"
                        required>
                        <option value="">Selecione o médico...</option>
                        @foreach($doctors as $doc)
                            <option value="{{ $doc->id }}">{{ $doc->name }} {{ $doc->crm ? "({$doc->crm})" : '' }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Data e hora -->
                <div class="flex flex-col">
                    <label for="scheduled_at" class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Data e Hora
                    </label>
                    <input id="scheduled_at" type="datetime-local" name="scheduled_at"
                        class="w-full rounded-md border border-gray-300 dark:border-gray-600 
                               dark:bg-gray-800 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 
                               focus:border-indigo-500 text-sm p-2"
                        required>
                </div>

                <!-- Observações -->
                <div class="flex flex-col">
                    <label for="notes" class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Observações (opcional)
                    </label>
                    <textarea id="notes" name="notes" rows="3"
                        class="w-full rounded-md border border-gray-300 dark:border-gray-600 
                               dark:bg-gray-800 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 
                               focus:border-indigo-500 text-sm p-2 resize-none"
                        placeholder="Ex: sintomas, preferências, detalhes adicionais..."></textarea>
                </div>

                <!-- Botões -->
                <div class="flex justify-end items-center gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('appointments.index') }}"
                        class="px-5 py-2.5 rounded-md text-sm font-medium text-gray-600 dark:text-gray-300 
                               hover:text-indigo-700 dark:hover:text-white transition">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-6 py-2.5 rounded-md font-semibold text-sm shadow-md transition-all duration-200"
                        style="background-color:#66c1dd; color:white;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-white" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Confirmar Agendamento
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
