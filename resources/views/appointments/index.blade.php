@php
    $layout = Auth::user()?->role === 'cliente' ? 'app-cliente' : 'app';
@endphp

@extends('layouts.' . $layout)

@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    
    {{-- Mensagem de sucesso --}}
    @if (session('success'))
        <div x-data="{ show: true }"
             x-show="show"
             x-transition
             class="mb-6 flex items-center justify-between bg-green-100 border border-green-300 text-green-800 text-sm px-4 py-3 rounded-lg shadow-sm">
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
            <button @click="show = false" class="text-green-600 hover:text-green-800 font-bold">×</button>
        </div>
    @endif

    {{-- Bloco principal --}}
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
        <div class="flex items-center justify-between mb-6 border-b pb-4">
            <h2 class="text-3xl font-extrabold text-gray-900 dark:text-gray-100">
                @if($user->isMedico())
                    Minhas Consultas (Médico)
                @else
                    Minhas Consultas (Paciente)
                @endif
            </h2>

            {{-- ✅ Botão de nova consulta (só aparece para o paciente) --}}
            @if(!$user->isMedico())
                <a href="{{ route('appointments.create') }}"
                   class="inline-flex items-center px-4 py-2 rounded-md font-semibold text-sm uppercase shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150"
                   style="background-color:#66c1dd; color:white;">
                    + Agendar Nova Consulta
                </a>
            @endif
        </div>

        {{-- Lista de consultas --}}
        @if($appointments->isEmpty())
            <div class="text-center py-12">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-200">Nenhuma consulta encontrada</h3>
                <p class="mt-1 text-sm text-gray-500">Você ainda não possui consultas agendadas.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                Data/Hora
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                @if($user->isMedico()) Paciente @else Médico @endif
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                Ações
                            </th>
                        </tr>
                    </thead>

                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($appointments as $a)
                            <tr>
                                <td class="px-3 py-4 text-sm font-medium text-gray-900 dark:text-gray-200">
                                    {{ \Carbon\Carbon::parse($a->scheduled_at)->format("d/m/Y H:i") }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                    {{ $user->isMedico() ? $a->patient->name : $a->doctor->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span @class([
                                        'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                                        'bg-green-100 text-green-800' => $a->status === 'done',
                                        'bg-yellow-100 text-yellow-800' => $a->status === 'scheduled',
                                        'bg-red-100 text-red-800' => $a->status === 'canceled',
                                    ])>
                                        {{ ucfirst($a->status) }}
                                    </span>
                                </td>
                                <td class="px-3 py-4 text-sm font-medium">
                                    @if($user->isMedico())
                                        <form method="POST" action="{{ route('gestor.appointments.update', $a) }}" class="inline-flex items-center space-x-2">
                                            @csrf @method('PATCH')
                                            <select name="status" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-1.5 transition duration-150 ease-in-out">
                                                <option value="scheduled" @selected($a->status === 'scheduled')>Agendada</option>
                                                <option value="done" @selected($a->status === 'done')>Concluída</option>
                                                <option value="canceled" @selected($a->status === 'canceled')>Cancelada</option>
                                            </select>
                                            <input type="hidden" name="notes" value="{{ $a->notes }}">
                                            <button type="submit"
                                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                Salvar
                                            </button>
                                        </form>

                                        <div class="mt-2 flex space-x-4">
                                            @if(!$a->diagnosis && $a->status !== 'canceled')
                                                <a href="{{ route('diagnoses.create', $a) }}" class="text-indigo-600 hover:text-indigo-900 text-xs">Lançar diagnóstico</a>
                                            @elseif($a->diagnosis)
                                                <a href="#" class="text-green-600 hover:text-green-900 text-xs">Ver diagnóstico</a>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-gray-500 dark:text-gray-400 text-xs">Nenhuma ação disponível</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <div class="mt-6">
            {{ $appointments->links() }}
        </div>
    </div>
</div>
@endsection
