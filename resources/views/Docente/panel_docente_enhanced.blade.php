@extends('layouts.principal')   
@section('titulo', 'Panel del Docente')
@section('contenido')

<body>
    <div class="container-fluid p-0">
        <div class="row g-0">

            <!-- Contenido principal -->
                    <!-- Encabezado mejorado -->
                    <div class="header-card">
                        <h1>Panel de Docente</h1>
                        <p>Bienvenido al sistema de evaluación docente</p>


                        
                    </div>

                    <!-- Alerta de periodo activo -->
                    <div class="alert alert-success d-flex align-items-center" role="alert">
                        <i class="fas fa-check-circle me-2 fa-lg"></i>
                        <div>
                            <strong>Periodo de evaluación activo</strong>
                            <p class="mb-0">El periodo de evaluación docente está activo hasta 2025-06-30. Te quedan 15
                                días para completar la autoevaluación sadf</p>
                        </div>
                    </div>

                    <!-- Tarjetas de evaluaciones -->
                    <div class="row mt-4">
                        <div class="col-md-3 mb-3">
                            <div class="card card-evaluacion">
                                <div class="card-body">
                                    <h5 class="card-title">Evaluación Estudiantil</h5>
                                    <h2 class="display-4 text-primary"> /5.0</h2>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: 88%"
                                            aria-valuenow="88" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="card-text text-muted mt-2">Promedio de 45 evaluaciones</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card card-evaluacion">
                                <div class="card-body">
                                    <h5 class="card-title">Evaluación fasd Administrativa</h5>
                                    <h2 class="display-4 text-primary">/1</h2>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: 92%"
                                            aria-valuenow="92" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="card-text text-muted mt-2">Calificación de coordinación</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card card-evaluacion">
                                <div class="card-body">
                                    <h5 class="card-title">Autoevaluación</h5>
                                    <div class="text-center">
                                        <span class="pendiente-badge">/5.0</span>
                                        <p class="card-text text-muted mt-3">No has completado tu autoevaluación</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card card-evaluacion">
                                <div class="card-body">
                                    <h5 class="card-title">Promedio Evaluación</h5>
                                    <h2 class="display-4 text-primary">/5.0</h2>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: 89%"
                                            aria-valuenow="89" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="card-text text-muted mt-2">Promedio general de evaluaciones</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filtros y gráfico principal -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Evolución de Evaluaciones</h5>
                                    <p class="card-text text-muted">Visualiza tu progreso a lo largo del tiempo</p>

                                    <div class="filter-container">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="yearFilter" class="form-label">Año:</label>
                                                <select class="form-select" id="yearFilter">
                                                    <option value="2022">2022</option>
                                                    <option value="2023">2023</option>
                                                    <option value="2024">2024</option>
                                                    <option value="2025" selected>2025</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="semesterFilter" class="form-label">Semestre:</label>
                                                <select class="form-select" id="semesterFilter">
                                                    <option value="1" selected>Semestre 1</option>
                                                    <option value="2">Semestre 2</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 d-flex align-items-end">
                                                <button id="updateChartBtn" class="btn btn-primary">Actualizar</button>
                                            </div>
                                        </div>

                                        <div class="chart-type-selector mt-3">
                                            <button class="chart-type-btn active" data-type="bar">Barras</button>
                                            <button class="chart-type-btn" data-type="line">Líneas</button>
                                            <button class="chart-type-btn" data-type="radar">Radar</button>
                                            <button class="chart-type-btn" data-type="pie">Circular</button>
                                        </div>
                                    </div>

                                    <div class="chart-container">
                                        <canvas id="mainChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Resumen de criterios -->
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Resumen de Evaluaciones</h5>
                                    <p class="card-text text-muted">Distribución de calificaciones por criterio</p>

                                    <div class="resumen-criterio">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span>Métodos de enseñanza</span>
                                            <span>4.6/5.0</span>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: 90%"
                                                aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>

                                    <div class="resumen-criterio">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span>Puntualidad y asistencia</span>
                                            <span>4.8/5.0</span>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: 96%"
                                                aria-valuenow="96" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>

                                    <div class="resumen-criterio">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span>Comunicación</span>
                                            <span>4.3/5.0</span>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: 86%"
                                                aria-valuenow="86" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <!-- Bootstrap JS y scripts personalizados -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/LogicaDocente/script.js')}}"></script>
    <script>
        // Inicializar el gráfico principal
        document.addEventListener('DOMContentLoaded', function () {
            // Configuración del gráfico principal
            const ctx = document.getElementById('mainChart').getContext('2d');

            const data = {
                labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
                datasets: [{
                    label: 'Evaluación Estudiantil',
                    data: [4.2, 4.3, 4.1, 4.4, 4.5, 4.4],
                    backgroundColor: 'rgba(13, 110, 253, 0.5)',
                    borderColor: '#0d6efd',
                    borderWidth: 1
                }, {
                    label: 'Evaluación Administrativa',
                    data: [4.3, 4.4, 4.3, 4.5, 4.6, 4.5],
                    backgroundColor: 'rgba(25, 135, 84, 0.5)',
                    borderColor: '#198754',
                    borderWidth: 1
                }]
            };

            currentChart = new Chart(ctx, {
                type: 'bar',
                data: data,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: false,
                            min: 3,
                            max: 5,
                            ticks: {
                                stepSize: 0.5
                            }
                        }
                    }
                }
            });

            // Cambiar tipo de gráfico
            document.querySelectorAll('.chart-type-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    const type = this.getAttribute('data-type');
                    document.querySelectorAll('.chart-type-btn').forEach(b => b.classList.remove('active'));
                    this.classList.add('active');

                    // Actualizar tipo de gráfico
                    currentChart.destroy();
                    currentChart = new Chart(ctx, {
                        type: type,
                        data: data,
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: false,
                                    min: 3,
                                    max: 5,
                                    ticks: {
                                        stepSize: 0.5
                                    }
                                }
                            }
                        }
                    });
                });
            });


            // Fin de la inicialización de gráficos
        });
    </script>
@endsection