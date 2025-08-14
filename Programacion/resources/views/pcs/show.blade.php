    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detalles de: {{ $pc->name }}
            </h2>
        </x-slot>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Columna de Specs y Recomendaciones -->
                <div class="md:col-span-1 space-y-6">
                    <!-- Especificaciones -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold mb-4 border-b pb-2">Especificaciones</h3>
                        @if ($pc->hardwareSpec)
                            <ul class="space-y-2 text-sm text-gray-700">
                                <li><strong>CPU:</strong> {{ $pc->hardwareSpec->cpu }}</li>
                                <li><strong>RAM:</strong> {{ $pc->hardwareSpec->ram_total_gb }} GB</li>
                                <li><strong>Placa:</strong> {{ $pc->hardwareSpec->motherboard }}</li>
                                <li><strong>Discos:</strong>
                                    <ul class="list-disc pl-5 mt-1">
                                        @foreach ($pc->hardwareSpec->disks as $disk)
                                            <li>{{ $disk['size_gb'] }}GB {{ $disk['type'] }} ({{ $disk['model'] }})</li>
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                        @else
                            <p class="text-sm text-gray-500">Aún no se han recibido las especificaciones de este equipo.
                            </p>
                        @endif
                    </div>
                    <!-- Recomendaciones -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold mb-4 border-b pb-2">Recomendaciones</h3>
                        <div class="space-y-3 text-sm text-gray-700">
                            @foreach ($recommendations as $rec)
                                <p>{!! Illuminate\Support\Str::markdown($rec) !!}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- Columna de Gráficos -->
                <div class="md:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Rendimiento - Últimas 24 horas</h3>
                    @if ($chartLabels->isEmpty())
                        <div class="p-8 bg-gray-100 rounded-lg text-center text-gray-500">No hay datos de rendimiento.
                        </div>
                    @else
                        <div class="space-y-8">
                            <div><canvas id="cpuChart"></canvas></div>
                            <div><canvas id="ramChart"></canvas></div>
                            <div><canvas id="diskChart"></canvas></div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                @if ($chartLabels->isNotEmpty())
                    const createChart = (ctx, label, data, color) => {
                        new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: @json($chartLabels),
                                datasets: [{
                                    label: `% de Uso de ${label}`,
                                    // --- CORREGIDO ---
                                    // Usamos la variable de JavaScript 'data' en lugar de la de PHP '$data'.
                                    data: data,
                                    borderColor: color,
                                    backgroundColor: `${color}33`,
                                    borderWidth: 2,
                                    fill: true,
                                    tension: 0.3
                                }]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        max: 100,
                                        ticks: {
                                            callback: function(value) {
                                                return value + '%'
                                            }
                                        }
                                    }
                                },
                                plugins: {
                                    legend: {
                                        display: false
                                    },
                                    title: {
                                        display: true,
                                        text: `Uso de ${label}`
                                    }
                                }
                            }
                        });
                    };

                    createChart(document.getElementById('cpuChart'), 'CPU', @json($cpuData), 'rgba(59, 130, 246, 1)');
                    createChart(document.getElementById('ramChart'), 'RAM', @json($ramData), 'rgba(16, 185, 129, 1)');
                    createChart(document.getElementById('diskChart'), 'Disco', @json($diskData),
                        'rgba(239, 68, 68, 1)');
                @endif
            </script>
        @endpush
    </x-app-layout>
