<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Panel de Monitoreo') }}
            </h2>
            {{-- Mostramos el botón solo si el usuario es administrador --}}
            @if (auth()->user()->isAdmin())
                <a href="{{ route('devices.register') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Registrar Dispositivo
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="overflow-x-auto">
                        <table class="min-w-full leading-normal">
                            <thead>
                                <tr>
                                    <th
                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Nombre del Equipo
                                    </th>
                                    <th
                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        CPU (%)
                                    </th>
                                    <th
                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        RAM (%)
                                    </th>
                                    <th
                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Disco (%)
                                    </th>
                                    <th
                                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Último Reporte
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pcs as $pc)
                                    <tr>
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            {{-- Esta ruta sigue apuntando al controlador original, lo cual es correcto por ahora --}}
                                            <a href="{{ route('pcs.show', $pc->id) }}"
                                                class="text-blue-600 hover:text-blue-800 font-bold">
                                                {{ $pc->name }}
                                            </a>
                                            <p class="text-gray-600 whitespace-no-wrap text-xs">{{ $pc->identifier }}
                                            </p>
                                        </td>
                                        @if ($pc->metrics->isNotEmpty())
                                            @php $latestMetric = $pc->metrics->first(); @endphp
                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                <p class="text-gray-900 whitespace-no-wrap">
                                                    {{ $latestMetric->cpu_usage }}%</p>
                                            </td>
                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                <p class="text-gray-900 whitespace-no-wrap">
                                                    {{ $latestMetric->ram_usage }}%</p>
                                            </td>
                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                <p class="text-gray-900 whitespace-no-wrap">
                                                    {{ $latestMetric->disk_usage }}%</p>
                                            </td>
                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                <p class="text-gray-900 whitespace-no-wrap">
                                                    {{ $latestMetric->created_at->diffForHumans() }}</p>
                                            </td>
                                        @else
                                            <td colspan="4"
                                                class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center text-gray-500">
                                                Esperando el primer reporte...
                                            </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-5 py-5 text-center text-gray-500">No hay equipos
                                            monitoreados todavía.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
