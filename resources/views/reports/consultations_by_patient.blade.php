@php
    // Define automaticamente o layout conforme o tipo de usuário logado
    $layout = Auth::user()?->role === 'cliente' ? 'app-cliente' : 'app';
@endphp

@extends('layouts.' . $layout)

@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

        <!-- Título do Relatório -->
        <h2 class="text-3xl font-extrabold text-gray-900 mb-6 border-b pb-4">
            Relatório: Consultas por Paciente
        </h2>

        <!-- Formulário de Filtro -->
        <form method="GET" action="{{ route('reports.consultations_by_patient') }}"
              class="mb-8 p-4 bg-gray-50 rounded-lg shadow-inner flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-4">

            <div class="flex-grow w-full sm:w-auto">
                <label for="patient_id" class="block text-sm font-medium text-gray-700 mb-1">
                    Selecione o Paciente
                </label>
                <select name="patient_id" id="patient_id"
                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md p-2 transition duration-150 ease-in-out">
                    <option value="">-- Selecione um paciente --</option>
                    @foreach($patients as $p)
                        <option value="{{ $p->id }}" @selected(($patientId ?? null) == $p->id)>{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="pt-5 sm:pt-0">
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out w-full sm:w-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                    Filtrar
                </button>
            </div>
        </form>

        <!-- Área do Relatório -->
        @if(($patientId ?? null) && $appointments->count())
            <div class="mt-8">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">
                    Histórico de Consultas
                </h3>

                <div class="overflow-x-auto shadow border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data/Hora</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Médico</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diagnóstico</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($appointments as $a)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ \Carbon\Carbon::parse($a->scheduled_at)->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $a->doctor->name }}
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
                                    <td class="px-6 py-4 text-sm text-gray-500 max-w-lg truncate">
                                        {{ $a->diagnosis?->description ?? '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        @elseif(($patientId ?? null))
            <!-- Empty State para paciente selecionado sem consultas -->
            <div class="text-center py-12 border-2 border-dashed border-gray-200 rounded-lg mt-8">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Nenhuma consulta encontrada</h3>
                <p class="mt-1 text-sm text-gray-500">O paciente selecionado não possui histórico de consultas.</p>
            </div>

        @else
            <!-- Empty State inicial -->
            <div class="text-center py-12 border-2 border-dashed border-gray-200 rounded-lg mt-8">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897m-3.34 3.34l-2.898-.777m0 0a2.001 2.001 0 104.872 4.872l.777-2.898m2.898-.777l-2.897-.777m0 0a2.001 2.001 0 114.872 4.872L10.5 14.5m6.001-12.001a2 2 0 10-4.242 0 2 2 0 004.242 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Selecione um Paciente</h3>
                <p class="mt-1 text-sm text-gray-500">Utilize o filtro acima para gerar o histórico de consultas.</p>
            </div>
        @endif
    </div>
</div>
@endsection
