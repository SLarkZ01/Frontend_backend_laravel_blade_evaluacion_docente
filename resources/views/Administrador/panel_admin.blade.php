@extends('layouts.app')
@section('titulo', 'Panel de Administrador')
@section('contenido')
<!-- Incluir Chart.js y nuestro script personalizado -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
<script src="{{ asset('js/LogicaAdministrador/Admin_Dashboard.js') }}"></script>
<div class="row g-0">
    <!-- Sidebar / Menú lateral -->
    <div class="col-md-2 sidebar">
        <div class="text-center py-4">
            <div class="avatar-circle mx-auto">
                <i class="fas fa-user-shield fa-3x text-white"></i>
            </div>
            <p class="text-white mt-2">Administrador</p>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="{{route('Admin.Dashboard')}}">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.roles_permisos')}}">
                    <i class="fas fa-users-cog"></i> Gestión de Roles y Permisos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.periodo_evaluacion')}}">
                    <i class="fas fa-calendar-alt"></i> Configuración de Periodos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.reportes_admin')}}">
                    <i class="fas fa-chart-bar"></i> Reportes y Estadísticas
                </a>
            </li>
            <li class="nav-item mt-5">
                <a class="nav-link" href="{{route('user.login')}}">
                    <i class="fas fa-sign-out-alt"></i> Salir
                </a>
            </li>
        </ul>
    </div>

    <!-- Contenido principal -->
    <div class="col-md-10 main-content">
        <div class="container py-4">
            <!-- Encabezado y bienvenida -->
            <div class="header-card animated-card">
                <h1>Panel de Administrador</h1>
                <p class="text-muted">Bienvenido al sistema de Evaluación Docente - Panel de Control</p>
            </div>

            <!-- Tarjetas de estadísticas principales -->
            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <div class="card dashboard-card">
                        <div class="card-body d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-users card-icon"></i>
                            </div>
                            <div>
                                <h6 class="card-title text-muted mb-1">Total Usuarios</h6>
                                <h2 class="display-5 fw-bold mb-0">58</h2>
                                <p class="card-text text-muted small mb-0">Usuarios registrados</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card dashboard-card">
                        <div class="card-body d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-user-tie card-icon"></i>
                            </div>
                            <div>
                                <h6 class="card-title text-muted mb-1">Docentes</h6>
                                <h2 class="display-5 fw-bold mb-0">45</h2>
                                <p class="card-text text-muted small mb-0">Docentes activos</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card dashboard-card">
                        <div class="card-body d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-user-graduate card-icon"></i>
                            </div>
                            <div>
                                <h6 class="card-title text-muted mb-1">Decanos</h6>
                                <h2 class="display-5 fw-bold mb-0">8</h2>
                                <p class="card-text text-muted small mb-0">Decanos/Coordinadores</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card dashboard-card">
                        <div class="card-body d-flex align-items-center">
                            <div class="me-3">
                                <i class="fas fa-user-shield card-icon"></i>
                            </div>
                            <div>
                                <h6 class="card-title text-muted mb-1">Administradores</h6>
                                <h2 class="display-5 fw-bold mb-0">5</h2>
                                <p class="card-text text-muted small mb-0">Administradores del sistema</p>
                            </div>
                        </div>
                    </div>
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

            <!-- Sección de acceso rápido -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Acceso Rápido</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="d-flex align-items-center p-3 quick-access-card">
                                        <div class="admin-icon me-3">
                                            <i class="fas fa-users-cog"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">Gestión de Usuarios</h6>
                                            <p class="mb-0 text-muted">Administrar usuarios y roles</p>
                                        </div>
                                        <a href="roles-permisos.html"
                                            class="ms-auto btn btn-sm btn-outline-primary">Ir</a>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="d-flex align-items-center p-3 quick-access-card">
                                        <div class="admin-icon me-3">
                                            <i class="fas fa-calendar-alt"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">Periodos de Evaluación</h6>
                                            <p class="mb-0 text-muted">Configurar fechas y parámetros</p>
                                        </div>
                                        <a href="periodos-evaluacion.html"
                                            class="ms-auto btn btn-sm btn-outline-primary">Ir</a>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="d-flex align-items-center p-3 quick-access-card">
                                        <div class="admin-icon me-3">
                                            <i class="fas fa-chart-bar"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">Reportes Generales</h6>
                                            <p class="mb-0 text-muted">Ver estadísticas del sistema</p>
                                        </div>
                                        <a href="reportes-admin.html"
                                            class="ms-auto btn btn-sm btn-outline-primary">Ir</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gráficos y Estadísticas -->
            <div class="row mb-4">
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Distribución de Usuarios por Rol</h5>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="initializeCharts"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Evaluaciones por Departamento</h5>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="departamentosChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actividad Reciente y Evaluaciones Pendientes -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Actividad Reciente</h5>
                            <button class="btn btn-sm btn-outline-primary">Ver todo</button>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0 table-admin">
                                    <thead>
                                        <tr>
                                            <th>Usuario</th>
                                            <th>Acción</th>
                                            <th>Fecha</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <p class="mb-0 fw-medium">Carlos Rodríguez</p>
                                                        <small class="text-muted">Docente</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>Completó evaluación</td>
                                            <td>Hoy, 10:45 AM</td>
                                            <td><span class="badge bg-success">Completado</span></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <p class="mb-0 fw-medium">Ana Martínez</p>
                                                        <small class="text-muted">Decano</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>Generó reporte</td>
                                            <td>Hoy, 09:30 AM</td>
                                            <td><span class="badge bg-primary">Procesado</span></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <p class="mb-0 fw-medium">Juan Pérez</p>
                                                        <small class="text-muted">Administrador</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>Modificó periodo</td>
                                            <td>Ayer, 15:20 PM</td>
                                            <td><span class="badge bg-warning text-dark">Pendiente</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
