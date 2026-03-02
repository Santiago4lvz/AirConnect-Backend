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

<!-- Filtro por ubicación (similar al de torres pero adaptado) -->
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
                        <p class="text-muted mb-1">PM2.5 (Partículas finas)</p>
                        <h2 class="mb-0" id="pm25-value">12.3</h2>
                        <small class="text-success"><i class="fas fa-arrow-down"></i> -2.1</small>
                    </div>
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                        <i class="fas fa-wind fa-2x text-primary"></i>
                    </div>
                </div>
                <div class="mt-2">
                    <span class="badge bg-success">Bueno</span>
                    <small class="text-muted ms-2">Límite: 25 µg/m³</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">CO₂ (Dióxido de Carbono)</p>
                        <h2 class="mb-0" id="co2-value">845</h2>
                        <small class="text-warning"><i class="fas fa-arrow-up"></i> +120</small>
                    </div>
                    <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                        <i class="fas fa-smog fa-2x text-warning"></i>
                    </div>
                </div>
                <div class="mt-2">
                    <span class="badge bg-warning">Moderado</span>
                    <small class="text-muted ms-2">Límite: 1000 ppm</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">CO (Monóxido de Carbono)</p>
                        <h2 class="mb-0" id="co-value">3.2</h2>
                        <small class="text-success"><i class="fas fa-arrow-down"></i> -0.5</small>
                    </div>
                    <div class="rounded-circle bg-danger bg-opacity-10 p-3">
                        <i class="fas fa-skull-crosswind fa-2x text-danger"></i>
                    </div>
                </div>
                <div class="mt-2">
                    <span class="badge bg-success">Seguro</span>
                    <small class="text-muted ms-2">Límite: 9 ppm</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">NO₂ (Dióxido de Nitrógeno)</p>
                        <h2 class="mb-0" id="no2-value">0.8</h2>
                        <small class="text-success"><i class="fas fa-arrow-down"></i> -0.3</small>
                    </div>
                    <div class="rounded-circle bg-info bg-opacity-10 p-3">
                        <i class="fas fa-industry fa-2x text-info"></i>
                    </div>
                </div>
                <div class="mt-2">
                    <span class="badge bg-success">Normal</span>
                    <small class="text-muted ms-2">Límite: 1 ppm</small>
                </div>
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
                <div class="alert alert-warning d-flex align-items-center" role="alert">
                    <i class="fas fa-exclamation-triangle me-3 fa-2x"></i>
                    <div>
                        <strong>Niveles elevados de CO₂ en Cocina Principal</strong><br>
                        Se recomienda aumentar la ventilación. Valor actual: 1245 ppm
                    </div>
                    <button class="btn btn-sm btn-warning ms-auto">Verificar</button>
                </div>
                <div class="alert alert-info d-flex align-items-center" role="alert">
                    <i class="fas fa-info-circle me-3 fa-2x"></i>
                    <div>
                        <strong>Mantenimiento preventivo recomendado</strong><br>
                        Los sensores de la Cocina Secundaria requieren calibración en 7 días
                    </div>
                    <button class="btn btn-sm btn-info ms-auto">Programar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Gráficos de evolución -->
<div class="row mb-4">
    <div class="col-md-8 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3">
                <h6 class="m-0 fw-bold text-primary">
                    <i class="fas fa-chart-line me-2"></i>Evolución de Contaminantes - Últimas 24h
                </h6>
            </div>
            <div class="card-body">
                <canvas id="evolutionChart" height="100"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3">
                <h6 class="m-0 fw-bold text-primary">
                    <i class="fas fa-chart-pie me-2"></i>Distribución por Contaminante
                </h6>
            </div>
            <div class="card-body">
                <canvas id="distributionChart" height="200"></canvas>
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
                    <i class="fas fa-history me-2"></i>Lecturas Recientes por Ubicación
                </h6>
                <a href="#" class="btn btn-sm btn-outline-primary">Ver Historial Completo</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Ubicación</th>
                                <th>PM2.5</th>
                                <th>CO₂ (ppm)</th>
                                <th>CO (ppm)</th>
                                <th>NO₂ (ppm)</th>
                                <th>Fecha/Hora</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><i class="fas fa-fire me-2 text-danger"></i>Cocina Principal</td>
                                <td>12.3 <span class="badge bg-success">B</span></td>
                                <td>1245 <span class="badge bg-warning">M</span></td>
                                <td>3.2 <span class="badge bg-success">B</span></td>
                                <td>0.8 <span class="badge bg-success">B</span></td>
                                <td>{{ now()->format('H:i') }}</td>
                                <td><span class="badge bg-warning">Atención</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-sm btn-outline-secondary"><i class="fas fa-chart-bar"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-utensils me-2 text-warning"></i>Cocina Secundaria</td>
                                <td>8.1 <span class="badge bg-success">B</span></td>
                                <td>723 <span class="badge bg-success">B</span></td>
                                <td>1.8 <span class="badge bg-success">B</span></td>
                                <td>0.4 <span class="badge bg-success">B</span></td>
                                <td>{{ now()->subMinutes(5)->format('H:i') }}</td>
                                <td><span class="badge bg-success">Normal</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-sm btn-outline-secondary"><i class="fas fa-chart-bar"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-chair me-2 text-info"></i>Comedor</td>
                                <td>5.6 <span class="badge bg-success">B</span></td>
                                <td>856 <span class="badge bg-success">B</span></td>
                                <td>1.2 <span class="badge bg-success">B</span></td>
                                <td>0.3 <span class="badge bg-success">B</span></td>
                                <td>{{ now()->subMinutes(12)->format('H:i') }}</td>
                                <td><span class="badge bg-success">Normal</span></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-sm btn-outline-secondary"><i class="fas fa-chart-bar"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Estadísticas y cumplimiento normativo -->
<div class="row mt-4">
    <div class="col-md-6 mb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="m-0 fw-bold text-primary">
                    <i class="fas fa-clipboard-check me-2"></i>Cumplimiento Normativo
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="d-flex justify-content-between">
                        <span>PM2.5 (NOM-025-SSA1-2021)</span>
                        <span class="text-success">Cumple</span>
                    </label>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-success" style="width: 45%"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="d-flex justify-content-between">
                        <span>CO₂ (ASHRAE 62.1)</span>
                        <span class="text-warning">Cumple con reservas</span>
                    </label>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-warning" style="width: 85%"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="d-flex justify-content-between">
                        <span>CO (NOM-020-SSA1-2021)</span>
                        <span class="text-success">Cumple</span>
                    </label>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-success" style="width: 35%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="m-0 fw-bold text-primary">
                    <i class="fas fa-file-pdf me-2"></i>Reportes y Análisis
                </h6>
            </div>
            <div class="card-body">
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-file-pdf text-danger me-2"></i>
                            Reporte Mensual - Enero 2026
                        </div>
                        <small class="text-muted">2.5 MB</small>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-file-excel text-success me-2"></i>
                            Datos Históricos - Último Trimestre
                        </div>
                        <small class="text-muted">1.8 MB</small>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-chart-line text-primary me-2"></i>
                            Análisis de Tendencias
                        </div>
                        <small class="text-muted">Actualizado</small>
                    </a>
                </div>
                <button class="btn btn-primary w-100 mt-3">
                    <i class="fas fa-download me-2"></i>Generar Nuevo Reporte
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Scripts para gráficos -->
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Gráfico de evolución
    const ctxEvolution = document.getElementById('evolutionChart').getContext('2d');
    new Chart(ctxEvolution, {
        type: 'line',
        data: {
            labels: ['00:00', '03:00', '06:00', '09:00', '12:00', '15:00', '18:00', '21:00'],
            datasets: [
                {
                    label: 'PM2.5',
                    data: [8, 7, 9, 12, 15, 14, 11, 10],
                    borderColor: '#4e73df',
                    backgroundColor: 'rgba(78, 115, 223, 0.05)',
                    tension: 0.3
                },
                {
                    label: 'CO₂',
                    data: [650, 620, 700, 850, 1100, 950, 800, 720],
                    borderColor: '#f6c23e',
                    backgroundColor: 'rgba(246, 194, 62, 0.05)',
                    tension: 0.3
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Gráfico de distribución
    const ctxDistribution = document.getElementById('distributionChart').getContext('2d');
    new Chart(ctxDistribution, {
        type: 'doughnut',
        data: {
            labels: ['PM2.5', 'CO₂', 'CO', 'NO₂'],
            datasets: [{
                data: [30, 45, 15, 10],
                backgroundColor: ['#4e73df', '#f6c23e', '#e74a3b', '#36b9cc']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Simulación de actualización en tiempo real
    setInterval(() => {
        // Actualizar valores aleatorios para simular cambios
        document.getElementById('pm25-value').textContent = (10 + Math.random() * 5).toFixed(1);
        document.getElementById('co2-value').textContent = Math.floor(800 + Math.random() * 200);
        document.getElementById('co-value').textContent = (2 + Math.random() * 2).toFixed(1);
        document.getElementById('no2-value').textContent = (0.5 + Math.random() * 0.5).toFixed(1);
    }, 5000);
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
    .list-group-item {
        border: none;
        border-radius: 10px !important;
        margin-bottom: 5px;
    }
    .list-group-item:hover {
        background-color: #f8f9fc;
    }
</style>
@endpush
@endsection