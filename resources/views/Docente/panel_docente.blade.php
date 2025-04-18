@extends('layouts.principal')
@section('titulo', 'Panel de Administrador')
@section('menu-sidebar')

    <li class="nav-item active">
        <a href="{{ route('docente.p_docente') }}">
            <i class="fas fa-home"></i>
            <p>Inicio</p>
        </a>
    </li>
    <li class="nav-section">
        <span class="sidebar-mini-icon">
            <i class="fa fa-ellipsis-h"></i>
        </span>
        <h4 class="text-section">Gestión Docente</h4>
    </li>
    <li class="nav-item">
        <a href="{{ route('docente.result') }}">
            <i class="fas fa-file-signature"></i>
            <p>Resultados</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('docente.confi') }}">
            <i class="fas fa-exclamation-triangle"></i>
            <p>Configuracion</p>
        </a>
    </li>
    <li class="nav-section">
        <span class="sidebar-mini-icon">
            <i class="fa fa-ellipsis-h"></i>
        </span>
        <h4 class="text-section">Configuración</h4>
    </li>
    <li class="nav-item">
        <a href="#profile">
            <i class="fas fa-user"></i>
            <p>Mi Perfil</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('user.login') }}">
            <i class="fas fa-sign-out-alt"></i>
            <p>Cerrar Sesión</p>
        </a>
    </li>
@endsection
@section('contenido')

<div class="row g-0">
    <!-- Sidebar / Menú lateral -->

            <!-- Encabezado mejorado -->
            <div class="header-card animated-card">
                <h1>Panel de Docente</h1>
                <p class="text-muted">Bienvenido al sistema de evaluación docente</p>
            </div>

            <!-- Alerta de periodo activo -->
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <div>
                    <strong>Periodo de evaluación activo</strong>
                    <p class="mb-0">El periodo de evaluación docente está activo hasta 2025-06-30. Te quedan 15
                        días para completar la autoevaluación</p>
                </div>
            </div>

            <!-- Tarjetas de evaluaciones -->
            <div class="row mt-4">
                <div class="col-md-3 mb-3">
                    <div class="card dashboard-card">
                        <div class="card-body d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-users card-icon"></i>
                            </div>
                            <div>
                                <h6 class="card-title text-muted mb-1">Evaluación Estudiantil</h6>
                                <h2 class="display-5 fw-bold mb-0">3.8</h2>
                                <p class="card-text text-muted small mb-0 fs-8">Promedio de 45 evaluaciones</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card dashboard-card">
                        <div class="card-body d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-clipboard-check card-icon"></i>
                            </div>
                            <div>
                                <h6 class="card-title text-muted mb-1">Evaluación Administrativa</h6>
                                <h2 class="display-5 fw-bold mb-0">4.5</h2>
                                <p class="card-text text-muted small mb-0 fs-8">Calificación de coordinación</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card dashboard-card">
                        <div class="card-body d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-user-check card-icon"></i>
                            </div>
                            <div>
                                <h6 class="card-title text-muted mb-1">Autoevaluación</h6>
                                <h2 class="display-8 fw-bold mb-0 text-warning">Pendiente</h2>
                                <p class="card-text text-muted small mb-0 fs-8">No has completado tu autoevaluación</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card dashboard-card">
                        <div class="card-body d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-chart-line card-icon"></i>
                            </div>
                            <div>
                                <h6 class="card-title text-muted mb-1">Promedio Evaluación </h6>
                                <h2 class="display-5 fw-bold mb-0">4.1</h2>
                                <p class="card-text text-muted small mb-0 fs-8">Promedio general de evaluaciones</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filtros y gráfico principal -->
            <div class="row mt-4 animated-card" style="animation-delay: 0.2s;">
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
                                    <button class="chart-type-btn active" data-type="bar"><i
                                            class="fas fa-chart-bar me-1"></i> Barras</button>
                                    <button class="chart-type-btn" data-type="line"><i
                                            class="fas fa-chart-line me-1"></i> Líneas</button>
                                    <button class="chart-type-btn" data-type="radar"><i
                                            class="fas fa-spider me-1"></i> Radar</button>
                                    <button class="chart-type-btn" data-type="pie"><i
                                            class="fas fa-chart-pie me-1"></i> Circular</button>
                                </div>
                            </div>

                            <div class="chart-container">
                                <canvas id="mainChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mis Cursos y Resumen de Evaluaciones -->
            <div class="row mt-4">
                <div class="col-md-6 mb-3 animated-card" style="animation-delay: 0.4s;">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Mis Cursos</h5>
                            <p class="card-text text-muted">Cursos asignados y estado de evaluaciones</p>

                            <div class="curso-card p-3 bg-light rounded">
                                <div class="d-flex justify-content-between mb-1">
                                    <h6 class="mb-0">Matemáticas Avanzadas</h6>
                                    <span>28/32 evaluaciones</span>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 87%"
                                        aria-valuenow="87" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>

                            <div class="curso-card p-3 bg-light rounded">
                                <div class="d-flex justify-content-between mb-1">
                                    <h6 class="mb-0">Cálculo Diferencial</h6>
                                    <span>45/50 evaluaciones</span>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 90%"
                                        aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>

                            <div class="curso-card p-3 bg-light rounded">
                                <div class="d-flex justify-content-between mb-1">
                                    <h6 class="mb-0">Álgebra Lineal</h6>
                                    <span>35/38 evaluaciones</span>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 92%"
                                        aria-valuenow="92" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3 animated-card" style="animation-delay: 0.6s;">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Resumen de Evaluaciones</h5>
                            <p class="card-text text-muted">Distribución de calificaciones por criterio</p>

                            <div class="resumen-criterio">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Métodos de enseñanza</span>
                                    <span>4.6/5.0</span>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 92%"
                                        aria-valuenow="92" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>

                            <div class="resumen-criterio">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Conocimiento de contenido</span>
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
            </div>
        </div>

@endsection