@extends('layouts.app')

@section('title', 'Panel AirConnect - Calidad del Aire')
@section('content')

<!-- Header con título y descripción -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="text-primary">
            <i class="fas fa-wind me-2"></i>Panel de Monitoreo Ambiental
        </h2>
        <p class="text-muted">Monitoreo inteligente de la calidad del aire en tiempo real</p>
    </div>
    <div class="d-flex gap-2">
        <span class="badge bg-success p-3">
            <i class="fas fa-circle me-1"></i>Sistema Activo
        </span>
        <span class="badge bg-info p-3">
            <i class="fas fa-clock me-1"></i>{{ now()->format('d/m/Y H:i') }}
        </span>
    </div>
</div>

<!-- Filtro por ubicación (opcional - puedes mantenerlo o eliminarlo) -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <form method="GET" action="{{ route('dashboard') }}">
                    <div class="row align-items-end">
                        <div class="col-md-4">
                            <label for="ubicacion" class="form-label fw-bold">
                                <i class="fas fa-map-marker-alt me-1"></i>Seleccionar Ubicación
                            </label>
                            <select class="form-select" id="ubicacion" name="ubicacion" onchange="this.form.submit()">
                                <option value="">Todas las ubicaciones</option>
                                <option value="cocina_1">Cocina Principal</option>
                                <option value="cocina_2">Cocina Secundaria</option>
                                <option value="comedor">Comedor</option>
                                <option value="almacen">Almacén</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <div class="d-grid">
                                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-eraser me-1"></i>Limpiar Filtro
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Tarjetas de monitoreo en tiempo real -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Calidad Aire (MQ135)</p>
                        <h2 class="mb-0" id="mq135-value">{{ $ultima['aire_mq135'] ?? '--' }}</h2>
                        <small class="text-success"><i class="fas fa-arrow-down"></i> Estable</small>
                    </div>
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                        <i class="fas fa-wind fa-2x text-primary"></i>
                    </div>
                </div>
                <div class="mt-2">
                    @php
                        $mq135 = $ultima['aire_mq135'] ?? 0;
                        $badgeClass = $mq135 < 100 ? 'success' : ($mq135 < 200 ? 'warning' : 'danger');
                        $statusText = $mq135 < 100 ? 'Bueno' : ($mq135 < 200 ? 'Moderado' : 'Peligroso');
                    @endphp
                    <span class="badge bg-{{ $badgeClass }}">{{ $statusText }}</span>
                    <small class="text-muted ms-2">Límite: 200</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">CO (MQ7)</p>
                        <h2 class="mb-0" id="co-value">{{ $ultima['co_mq7'] ?? '--' }}</h2>
                        <small class="text-warning"><i class="fas fa-chart-line"></i> Monitoreado</small>
                    </div>
                    <div class="rounded-circle bg-danger bg-opacity-10 p-3">
                        <i class="fas fa-smog fa-2x text-danger"></i>
                    </div>
                </div>
                <div class="mt-2">
                    @php
                        $co = $ultima['co_mq7'] ?? 0;
                        $badgeClass = $co < 50 ? 'success' : ($co < 100 ? 'warning' : 'danger');
                        $statusText = $co < 50 ? 'Seguro' : ($co < 100 ? 'Moderado' : 'Peligroso');
                    @endphp
                    <span class="badge bg-{{ $badgeClass }}">{{ $statusText }}</span>
                    <small class="text-muted ms-2">Límite: 100</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Gas (MQ2)</p>
                        <h2 class="mb-0" id="gas-value">{{ $ultima['gas_mq2'] ?? '--' }}</h2>
                        <small class="text-success"><i class="fas fa-arrow-down"></i> Normal</small>
                    </div>
                    <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                        <i class="fas fa-industry fa-2x text-warning"></i>
                    </div>
                </div>
                <div class="mt-2">
                    @php
                        $gas = $ultima['gas_mq2'] ?? 0;
                        $badgeClass = $gas < 150 ? 'success' : ($gas < 300 ? 'warning' : 'danger');
                        $statusText = $gas < 150 ? 'Normal' : ($gas < 300 ? 'Atención' : 'Peligroso');
                    @endphp
                    <span class="badge bg-{{ $badgeClass }}">{{ $statusText }}</span>
                    <small class="text-muted ms-2">Límite: 300</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Humedad</p>
                        <h2 class="mb-0" id="humedad-value">{{ $ultima['humedad'] ?? '--' }}%</h2>
                        <small class="text-info"><i class="fas fa-tint"></i> Ambiente</small>
                    </div>
                    <div class="rounded-circle bg-info bg-opacity-10 p-3">
                        <i class="fas fa-tint fa-2x text-info"></i>
                    </div>
                </div>
                <div class="mt-2">
                    @php
                        $humedad = $ultima['humedad'] ?? 0;
                        $badgeClass = $humedad >= 30 && $humedad <= 60 ? 'success' : 'warning';
                        $statusText = $humedad >= 30 && $humedad <= 60 ? 'Óptima' : 'Ajustar';
                    @endphp
                    <span class="badge bg-{{ $badgeClass }}">{{ $statusText }}</span>
                    <small class="text-muted ms-2">Ideal: 30-60%</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Segunda fila de tarjetas: Temperatura y gráfico -->
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Temperatura</p>
                        <h2 class="mb-0" id="temperatura-value">{{ $ultima['temperatura'] ?? '--' }} °C</h2>
                        <small class="text-danger"><i class="fas fa-thermometer-half"></i> Ambiente</small>
                    </div>
                    <div class="rounded-circle bg-success bg-opacity-10 p-3">
                        <i class="fas fa-thermometer-half fa-2x text-success"></i>
                    </div>
                </div>
                <div class="mt-2">
                    @php
                        $temp = $ultima['temperatura'] ?? 0;
                        $badgeClass = $temp >= 18 && $temp <= 25 ? 'success' : ($temp > 25 ? 'warning' : 'info');
                        $statusText = $temp >= 18 && $temp <= 25 ? 'Confortable' : ($temp > 25 ? 'Caluroso' : 'Frío');
                    @endphp
                    <span class="badge bg-{{ $badgeClass }}">{{ $statusText }}</span>
                    <small class="text-muted ms-2">Ideal: 18-25°C</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3">
                <h6 class="m-0 fw-bold text-primary">
                    <i class="fas fa-chart-line me-2"></i>Evolución de Sensores - Últimas 10 Lecturas
                </h6>
            </div>
            <div class="card-body">
                <canvas id="evolutionChart" height="80"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Alertas y notificaciones en tiempo real -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="m-0 fw-bold text-primary">
                    <i class="fas fa-bell me-2"></i>Alertas Activas
                </h6>
            </div>
            <div class="card-body">
                @php
                    $hasAlerts = false;
                    $mq135 = $ultima['aire_mq135'] ?? 0;
                    $co = $ultima['co_mq7'] ?? 0;
                    $gas = $ultima['gas_mq2'] ?? 0;
                @endphp

                @if($mq135 > 200)
                    @php $hasAlerts = true; @endphp
                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                        <i class="fas fa-exclamation-triangle me-3 fa-2x"></i>
                        <div>
                            <strong>Niveles elevados de partículas (MQ135)</strong><br>
                            Se recomienda aumentar la ventilación. Valor actual: {{ $mq135 }}
                        </div>
                        <button class="btn btn-sm btn-warning ms-auto">Verificar</button>
                    </div>
                @endif

                @if($co > 100)
                    @php $hasAlerts = true; @endphp
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                        <i class="fas fa-skull-crosswind me-3 fa-2x"></i>
                        <div>
                            <strong>¡Peligro! Niveles tóxicos de CO (MQ7)</strong><br>
                            Evacuar el área inmediatamente. Valor actual: {{ $co }}
                        </div>
                        <button class="btn btn-sm btn-danger ms-auto">Emergencia</button>
                    </div>
                @elseif($co > 50)
                    @php $hasAlerts = true; @endphp
                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                        <i class="fas fa-exclamation-circle me-3 fa-2x"></i>
                        <div>
                            <strong>Niveles elevados de CO (MQ7)</strong><br>
                            Ventilar el área. Valor actual: {{ $co }}
                        </div>
                        <button class="btn btn-sm btn-warning ms-auto">Verificar</button>
                    </div>
                @endif

                @if(!$hasAlerts)
                    <div class="alert alert-success d-flex align-items-center" role="alert">
                        <i class="fas fa-check-circle me-3 fa-2x"></i>
                        <div>
                            <strong>Todos los parámetros dentro de rangos normales</strong><br>
                            El ambiente se encuentra en condiciones óptimas.
                        </div>
                    </div>
                @endif

                <div class="alert alert-info d-flex align-items-center" role="alert">
                    <i class="fas fa-info-circle me-3 fa-2x"></i>
                    <div>
                        <strong>Monitoreo continuo</strong><br>
                        Los sensores actualizan datos cada {{ $ultimasLecturas ? '5-10' : '--' }} segundos
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabla de lecturas recientes -->
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 fw-bold text-primary">
                    <i class="fas fa-history me-2"></i>Lecturas Recientes por Sensor
                </h6>
                <button class="btn btn-sm btn-outline-primary" onclick="location.reload()">
                    <i class="fas fa-sync-alt me-1"></i>Actualizar
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th><i class="fas fa-wind me-1"></i>MQ135</th>
                                <th><i class="fas fa-smog me-1"></i>MQ7</th>
                                <th><i class="fas fa-industry me-1"></i>MQ2</th>
                                <th><i class="fas fa-tint me-1"></i>Humedad</th>
                                <th><i class="fas fa-thermometer-half me-1"></i>Temperatura</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ultimasLecturas as $index => $lectura)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    {{ $lectura['aire_mq135'] ?? '--' }}
                                    @php $val = $lectura['aire_mq135'] ?? 0; @endphp
                                    <span class="badge {{ $val < 100 ? 'bg-success' : ($val < 200 ? 'bg-warning' : 'bg-danger') }} ms-1">
                                        {{ $val < 100 ? 'B' : ($val < 200 ? 'M' : 'P') }}
                                    </span>
                                </td>
                                <td>
                                    {{ $lectura['co_mq7'] ?? '--' }}
                                    @php $val = $lectura['co_mq7'] ?? 0; @endphp
                                    <span class="badge {{ $val < 50 ? 'bg-success' : ($val < 100 ? 'bg-warning' : 'bg-danger') }} ms-1">
                                        {{ $val < 50 ? 'B' : ($val < 100 ? 'M' : 'P') }}
                                    </span>
                                </td>
                                <td>
                                    {{ $lectura['gas_mq2'] ?? '--' }}
                                    @php $val = $lectura['gas_mq2'] ?? 0; @endphp
                                    <span class="badge {{ $val < 150 ? 'bg-success' : ($val < 300 ? 'bg-warning' : 'bg-danger') }} ms-1">
                                        {{ $val < 150 ? 'B' : ($val < 300 ? 'M' : 'P') }}
                                    </span>
                                </td>
                                <td>{{ $lectura['humedad'] ?? '--' }}%</td>
                                <td>{{ $lectura['temperatura'] ?? '--' }} °C</td>
                                <td>
                                    @php
                                        $allGood = ($lectura['aire_mq135'] ?? 0) < 100 && 
                                                   ($lectura['co_mq7'] ?? 0) < 50 && 
                                                   ($lectura['gas_mq2'] ?? 0) < 150;
                                        $badgeClass = $allGood ? 'bg-success' : 'bg-warning';
                                        $statusText = $allGood ? 'Normal' : 'Atención';
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">{{ $statusText }}</span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary" onclick="verDetalle({{ $index }})">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary" onclick="verGrafico({{ $index }})">
                                        <i class="fas fa-chart-bar"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="fas fa-database fa-2x text-muted mb-2 d-block"></i>
                                    No hay lecturas disponibles. Esperando datos de Firebase...
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts para gráficos y actualización en tiempo real -->
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Datos del gráfico desde PHP
    const chartLabels = @json($chartLabels);
    const pm25Data = @json($pm25Data);
    const co2Data = @json($co2Data);
    
    let evolutionChart;

    // Inicializar gráfico
    function initChart() {
        const ctxEvolution = document.getElementById('evolutionChart').getContext('2d');
        
        if (evolutionChart) {
            evolutionChart.destroy();
        }
        
        evolutionChart = new Chart(ctxEvolution, {
            type: 'line',
            data: {
                labels: chartLabels.length ? chartLabels : ['Sin datos'],
                datasets: [
                    {
                        label: 'MQ135 (Calidad Aire)',
                        data: pm25Data.length ? pm25Data : [0],
                        borderColor: '#4e73df',
                        backgroundColor: 'rgba(78, 115, 223, 0.05)',
                        tension: 0.3,
                        fill: true
                    },
                    {
                        label: 'MQ7 (CO)',
                        data: co2Data.length ? co2Data : [0],
                        borderColor: '#e74a3b',
                        backgroundColor: 'rgba(231, 74, 59, 0.05)',
                        tension: 0.3,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Valor del Sensor'
                        }
                    }
                }
            }
        });
    }

    // Función para actualizar datos en tiempo real
    async function actualizarDatos() {
        try {
            const response = await fetch('/api/ultimas-lecturas');
            const data = await response.json();
            
            if (data.success && data.ultima) {
                // Actualizar tarjetas
                document.getElementById('mq135-value').textContent = data.ultima.aire_mq135 ?? '--';
                document.getElementById('co-value').textContent = data.ultima.co_mq7 ?? '--';
                document.getElementById('gas-value').textContent = data.ultima.gas_mq2 ?? '--';
                document.getElementById('humedad-value').textContent = (data.ultima.humedad ?? '--') + '%';
                document.getElementById('temperatura-value').textContent = (data.ultima.temperatura ?? '--') + ' °C';
                
                // Actualizar gráfico si hay nuevos datos
                if (data.ultimasLecturas && data.chartLabels) {
                    evolutionChart.data.labels = data.chartLabels;
                    evolutionChart.data.datasets[0].data = data.pm25Data;
                    evolutionChart.data.datasets[1].data = data.co2Data;
                    evolutionChart.update();
                }
            }
        } catch (error) {
            console.error('Error actualizando datos:', error);
        }
    }

    // Funciones auxiliares
    function verDetalle(index) {
        alert('Ver detalle de lectura #' + (index + 1));
    }
    
    function verGrafico(index) {
        alert('Ver gráfico de lectura #' + (index + 1));
    }

    // Inicializar gráfico al cargar
    document.addEventListener('DOMContentLoaded', function() {
        initChart();
        
        // Actualizar cada 10 segundos si hay datos
        @if(count($ultimasLecturas) > 0)
            setInterval(actualizarDatos, 10000);
        @endif
    });
</script>
@endpush

@push('styles')
<style>
    .card {
        transition: transform 0.2s, box-shadow 0.2s;
        border-radius: 15px !important;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1.5rem rgba(0,0,0,0.1) !important;
    }
    .badge {
        font-size: 0.8rem;
        padding: 0.5rem 1rem;
    }
    .table th {
        font-weight: 600;
        color: #5a5c69;
    }
    .progress {
        border-radius: 10px;
    }
    .bg-opacity-10 {
        --bs-bg-opacity: 0.1;
    }
    .table-responsive {
        border-radius: 10px;
    }
    .alert {
        border-radius: 12px;
    }
</style>
@endpush

@endsection