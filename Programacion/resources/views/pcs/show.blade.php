<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detalles de: {{ $pc->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="mb-4"><strong>Identificador:</strong> {{ $pc->identifier }}</p>
                    <p class="mb-4"><strong>Propietario:</strong> {{ $pc->user->name ?? 'No asignado' }}</p>

                    <h3 class="text-lg font-semibold mt-6 mb-4">Gráficos de Rendimiento (Próximamente)</h3>
                    <div class="p-8 bg-gray-100 rounded-lg text-center text-gray-500">
                        Aquí se mostrarán los gráficos del historial de CPU, RAM y Disco.
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
