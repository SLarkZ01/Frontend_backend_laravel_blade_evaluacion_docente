@extends('layouts.principal')
@section('titulo', 'Panel del Decano/Coordinador')
@section('menu-sidebar')

    <li class="nav-item active">
        <a href="{{ route('user.index') }}">
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
        <a href="{{ route('decano.acta_compromiso') }}">
            <i class="fas fa-file-signature"></i>
            <p>Actas de Compromiso</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('decano.abd') }}">
            <i class="fas fa-exclamation-triangle"></i>
            <p>Alertas Bajo Desempeño</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('decano.spm') }}">
            <i class="fas fa-chart-line"></i>
            <p>Seguimiento Plan de Mejora</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('decano.psr') }}">
            <i class="fas fa-user-times"></i>
            <p>Proceso de Sanción</p>
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
    <!-- Encabezado y bienvenida -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="mb-1">Dashboard del Panel Decano/Coordinador</h1>
            <p class="text-muted">Bienvenido al sistema de Evaluación Docente</p>
        </div>
        <div class="d-flex align-items-center">
            <div class="dropdown me-3">
                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="periodoDropdown"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-calendar-alt me-2"></i> Periodo 2025-1
                </button>
                <ul class="dropdown-menu" aria-labelledby="periodoDropdown">
                    <li><a class="dropdown-item" href="#">Periodo 2025-1</a></li>
                    <li><a class="dropdown-item" href="#">Periodo 2024-2</a></li>
                    <li><a class="dropdown-item" href="#">Periodo 2024-1</a></li>
                </ul>
            </div>
            <button class="btn btn-primary">
                <i class="fas fa-download me-2"></i> Exportar Informe
            </button>
        </div>
    </div>

    <!-- Alerta de periodo activo -->
    <div class="alert alert-success d-flex align-items-center mb-4" role="alert">
        <i class="fas fa-check-circle me-2 fa-lg"></i>
        <div>
            <strong>Periodo de evaluación activo</strong>
            <p class="mb-0">El periodo de evaluación docente está activo hasta 2025-06-30. Quedan 15
                días para completar todas las evaluaciones pendientes.</p>
        </div>
    </div>

    <!-- Tarjetas de estadísticas principales -->
    <div class="row mb-4">
        <div class="col-md-3 mb-1">
            <div class="card dashboard-card">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-users fa-3x card-icon"></i>
                    </div>
                    <div>
                        <h6 class="card-title text-muted mb-1">Total de Docentes</h6>
                        <h2 class="display-5 fw-bold mb-0"> {{ $total_docentes }} </h2>
                        <p class="card-text text-muted small mb-0">Docentes en el departamento</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-1">
            <div class="card dashboard-card">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-clipboard-check fa-3x card-icon"></i>
                    </div>
                    <div>
                        <h6 class="card-title text-muted mb-1">Docentes no evaluados</h6>
                        <h2 class="display-5 fw-bold mb-0">{{ $totalNoEvaluados }}</h2>
                        <p class="card-text text-muted small mb-0">Revisa la lista</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-1">
            <div class="card dashboard-card">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-hourglass-half fa-3x card-icon text-warning"></i>
                    </div>
                    <div>
                        <h6 class="card-title text-muted mb-1">Estudiantes no evaluaron</h6>
                        <h2 class="display-5 fw-bold mb-0">{{ $totalEstudiantesNoEvaluaron }}</h2>
                        <p class="card-text text-muted small mb-0">Revisa la lista</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-1">
            <div class="card dashboard-card">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-chart-line fa-3x card-icon text-success"></i>
                    </div>
                    <div>
                        <h6 class="card-title text-muted mb-1">Promedio facultades</h6>
                        <h2 class="display-5 fw-bold mb-0">{{ $promedio_global_p }}</h2>
                        <p class="card-text text-muted small mb-0">De 5.0 puntos posibles</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos de rendimiento -->

    <div class="row mb-4">
        <div class="col-md-6 mb-1">
            <div class="card dashboard-card">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Rendimiento por Facultad</h5>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="dropdownPeriodo"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Último periodo
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownPeriodo">
                            <li><a class="dropdown-item" href="#">Último periodo</a></li>
                            <li><a class="dropdown-item" href="#">Últimos 3 periodos</a></li>
                            <li><a class="dropdown-item" href="#">Último año</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="departamentosChart"></canvas>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-6 mb-1">
            <div class="card dashboard-card">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Distribución de Calificaciones</h5>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                            id="dropdownCalificaciones" data-bs-toggle="dropdown" aria-expanded="false">
                            Periodo actual
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownCalificaciones">
                            <li><a class="dropdown-item" href="{{ url('/promedio-facultad') }}">Periodo actual</a></li>
                            <li><a class="dropdown-item" href="#">Periodo anterior</a></li>
                            <li><a class="dropdown-item" href="#">Comparativa</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="calificacionesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Accesos rápidos y alertas -->
    <div class="row mb-1">
        <!-- Accesos rápidos -->
        <div class="col-md-4 mb-5">
            <div class="card dashboard-card">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">Accesos Rápidos</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <a href="{{ route('decano.acta_compromiso') }}"
                            class="list-group-item list-group-item-action quick-access-card p-3">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-file-signature fa-lg quick-access-icon"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Generar Acta de Compromiso</h6>
                                    <p class="mb-0 text-muted small">Crear actas para docentes con bajo desempeño</p>
                                </div>
                            </div>
                        </a>
                        <a href="{{ route('decano.spm') }}"
                            class="list-group-item list-group-item-action quick-access-card p-3">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-tasks fa-lg quick-access-icon"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Seguimiento a Plan de Mejora</h6>
                                    <p class="mb-0 text-muted small">Monitorear planes de mejora activos</p>
                                </div>
                            </div>
                        </a>
                        <a href="{{ route('decano.abd') }}"
                            class="list-group-item list-group-item-action quick-access-card p-3">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-exclamation-triangle fa-lg quick-access-icon"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Alertas de Bajo Desempeño</h6>
                                    <p class="mb-0 text-muted small">Ver docentes con calificaciones críticas</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alertas y notificaciones -->
        <div class="col-md-8 mb-3">
            <div class="card dashboard-card">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Alertas y Notificaciones</h5>
                    <a href="{{ route('decano.abd') }}" class="btn btn-sm btn-outline-primary">Ver todas</a>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item p-3 alert-docente">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Carlos Rodríguez - Calificación crítica</h6>
                                    <p class="mb-0 text-muted small">Calificación: <span
                                            class="text-danger fw-bold">2.4/5.0</span> en Cálculo
                                        Diferencial</p>
                                </div>
                                <div>
                                    <span class="badge dept-ingenieria">Ingeniería</span>
                                    <a href="{{ route('decano.acta_compromiso') }}"
                                        class="btn btn-sm btn-outline-danger ms-2">Generar Acta</a>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item p-3 alert-docente">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">María Gómez - Calificación crítica</h6>
                                    <p class="mb-0 text-muted small">Calificación: <span
                                            class="text-danger fw-bold">2.7/5.0</span> en Física
                                        Mecánica</p>
                                </div>
                                <div>
                                    <span class="badge dept-ciencias">Ciencias</span>
                                    <a href="{{ route('decano.acta_compromiso') }}"
                                        class="btn btn-sm btn-outline-danger ms-2">Generar Acta</a>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item p-3 alert-warning-custom">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Plan de mejora pendiente</h6>
                                    <p class="mb-0 text-muted small">El plan de mejora de Juan Pérez
                                        está pendiente de seguimiento desde hace 7 días</p>
                                </div>
                                <div>
                                    <a href="{{ route('decano.spm') }}" class="btn btn-sm btn-warning">Revisar</a>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item p-3 alert-success-custom">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">Plan de mejora completado</h6>
                                    <p class="mb-0 text-muted small">Ana Martínez ha completado su plan
                                        de mejora con éxito</p>
                                </div>
                                <div>
                                    <a href="{{ route('decano.spm') }}" class="btn btn-sm btn-success">Ver detalles</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Planes de mejora activos y docentes destacados -->
    <div class="row mb-1">
        <!-- Planes de mejora activos -->
        <div class="col-md-6 mb-2">
            <div class="card dashboard-card">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Planes de Mejora Activos</h5>
                    <a href="{{ route('decano.spm') }}" class="btn btn-sm btn-outline-primary">Ver todos</a>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <h6 class="mb-0">Juan Pérez - Física Cuántica</h6>
                                <small class="text-muted">Inicio: 15/05/2025 - Fin: 15/08/2025</small>
                            </div>
                            <span class="badge badge-estado badge-activo">Activo</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 65%"
                                aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex justify-content-between mt-1">
                            <small class="text-muted">Progreso</small>
                            <small class="text-muted">65%</small>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <h6 class="mb-0">María Gómez - Física Mecánica</h6>
                                <small class="text-muted">Inicio: 01/06/2025 - Fin: 01/09/2025</small>
                            </div>
                            <span class="badge badge-estado badge-activo">Activo</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 30%"
                                aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex justify-content-between mt-1">
                            <small class="text-muted">Progreso</small>
                            <small class="text-muted">30%</small>
                        </div>
                    </div>
                    <div class="mb-0">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <h6 class="mb-0">Carlos Rodríguez - Cálculo Diferencial</h6>
                                <small class="text-muted">Inicio: 10/06/2025 - Fin: 10/09/2025</small>
                            </div>
                            <span class="badge badge-estado badge-pendiente">Pendiente</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 10%"
                                aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex justify-content-between mt-1">
                            <small class="text-muted">Progreso</small>
                            <small class="text-muted">10%</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Docentes destacados -->
        <div class="col-md-6 mb-2">
            <div class="card dashboard-card">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">Docentes Destacados</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item p-3">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <div class="avatar-circle"
                                        style="width: 50px; height: 50px; background-color: #0d6efd;">
                                        <i class="fas fa-user fa-lg text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    @if ($docentesUnicos && $docentesUnicos->isNotEmpty())
                                        <!-- Verificamos si hay docentes -->
                                        @foreach ($docentesUnicos as $docente)
                                            <!-- Iteramos a través de los docentes -->
                                            <div class="list-group-item p-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="me-3">
                                                        <div class="avatar-circle"
                                                            style="width: 50px; height: 50px; background-color: #0d6efd;">
                                                            <i class="fas fa-user fa-lg text-white"></i>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <!-- Mostramos el nombre del docente, el curso y la calificación -->
                                                        <h4>{{ $docente->docente }}</h4>
                                                        <p><strong>Curso:</strong> {{ $docente->curso }}</p>
                                                        <p><strong>Calificación:</strong> {{ $docente->calificacion }}/5.0
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <p>No hay docentes destacados disponibles.</p> <!-- Mensaje si no hay docentes -->
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item p-3">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <div class="avatar-circle" style="width: 50px; height: 50px; background-color: #6f42c1;">
                                    <i class="fas fa-user fa-lg text-white"></i>
                                </div>
                            </div>
                            <div>
                                <h6 class="mb-1">Patricia Mendoza</h6>
                                <p class="mb-0 text-muted small">Calificación: <span
                                        class="text-success fw-bold">4.7/5.0</span></p>
                                <div class="d-flex align-items-center">
                                    <span class="badge dept-ciencias me-2">Ciencias</span>
                                    <small class="text-muted">Biología Molecular</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>


    <!-- Bootstrap JS y scripts personalizados -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Script para dashboard interactivo -->
    <script src="{{ asset('js/LogicaDecanoCoordinador/dashboard_interactivo.js') }}"></script>
@endsection
