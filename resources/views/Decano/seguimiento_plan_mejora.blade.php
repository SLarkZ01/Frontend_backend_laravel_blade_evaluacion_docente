@extends('layouts.app')
@section('titulo','Seguimiento a Planes de Mejora')
@section('contenido')

<body>
    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- Sidebar / Menú lateral -->
            <div class="col-md-2 sidebar">
                <div class="text-center py-4">
                    <div class="avatar-circle mx-auto">
                        <i class="fas fa-user fa-3x text-white"></i>
                    </div>
                    <p class="text-white mt-2">Perfil Decano/<br>Coordinador</p>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.index') }}">
                            <i class="fas fa-home"></i> Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('decano.acta_compromiso') }}">
                            <i class="fas fa-file-signature"></i> Generar Acta de compromiso
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('decano.spm') }}">
                            <i class="fas fa-tasks"></i> Seguimiento a plan de mejora
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('decano.abd') }}">
                            <i class="fas fa-exclamation-triangle"></i> Alertas de bajo desempeño
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('decano.psr') }}">
                            <i class="fas fa-user-minus"></i> Proceso de Sanciones/Retiro
                        </a>
                    </li>
                    <li class="nav-item mt-5">
                        <a class="nav-link" href="#">
                            <i class="fas fa-sign-out-alt"></i> Salir
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Contenido principal -->
            <div class="col-md-10 main-content">
                <div class="container py-4">
                    <div class="header-seguimiento mb-4">
                        <h1 class="mb-0">Seguimiento a Planes de Mejora</h1>
                    </div>

                    <!-- Filtros y búsqueda -->
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><i class="fas fa-search me-2"></i>Buscar Actas de Compromiso
                                    </h5>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <select class="form-select" id="departamentoFilter">
                                                <option value="">Todos los departamentos</option>
                                                <option value="Ciencias Exactas">Ciencias Exactas</option>
                                                <option value="Ingeniería">Ingeniería</option>
                                                <option value="Humanidades">Humanidades</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <select class="form-select" id="estadoFilter">
                                                <option value="">Todos los estados</option>
                                                <option value="activo">Activo</option>
                                                <option value="cerrado">Cerrado</option>
                                                <option value="pendiente">Pendiente</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="searchInput"
                                                    placeholder="Buscar docente...">
                                                <button class="btn btn-outline-secondary" type="button">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><i class="fas fa-chart-pie me-2"></i>Resumen</h5>
                                    <div class="row text-center">
                                        <div class="col-4">
                                            <h3 id="totalActas">8</h3>
                                            <p class="mb-0">Total</p>
                                        </div>
                                        <div class="col-4">
                                            <h3 id="actasActivas">5</h3>
                                            <p class="mb-0">Activas</p>
                                        </div>
                                        <div class="col-4">
                                            <h3 id="actasCerradas">3</h3>
                                            <p class="mb-0">Cerradas</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de seguimiento -->
                    <div class="table-seguimiento p-0 mb-4">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover" id="tablaSeguimiento">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Docente</th>
                                            <th>Departamento</th>
                                            <th>Asignatura</th>
                                            <th>Calificación</th>
                                            <th>Fecha Acta</th>
                                            <th>Progreso</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Los datos se cargarán dinámicamente desde JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <!-- Script específico para seguimiento -->
    <script src="{{asset('js/LogicaDecanoCoordinador/seguimiento_script.js')}}"></script>
    <!-- Script para generación de PDF -->
    <script src="{{asset('js/LogicaDecanoCoordinador/seguimiento_pdf_generator.js')}}"></script>
    <!-- HTML2PDF Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <!-- Modal de Detalles de Seguimiento -->
    <div class="modal fade" id="modalDetallesSeguimiento" tabindex="-1" aria-labelledby="modalDetallesSeguimientoLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header header-seguimiento">
                    <h5 class="modal-title" id="modalDetallesSeguimientoLabel">Detalles de Seguimiento</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6>Información del Docente</h6>
                            <p><strong>Nombre:</strong> <span id="modalNombreDocente"></span></p>
                            <p><strong>Departamento:</strong> <span id="modalDepartamento"></span></p>
                            <p><strong>Asignatura:</strong> <span id="modalAsignatura"></span></p>
                        </div>
                        <div class="col-md-6">
                            <h6>Información del Acta</h6>
                            <p><strong>Número de Acta:</strong> <span id="modalNumeroActa"></span></p>
                            <p><strong>Fecha de Generación:</strong> <span id="modalFechaActa"></span></p>
                            <p><strong>Calificación:</strong> <span id="modalCalificacion"></span></p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <h6>Retroalimentación Original</h6>
                            <div class="p-3 bg-light rounded" id="modalRetroalimentacion">
                                <!-- Contenido de la retroalimentación -->
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0">Historial de Seguimiento</h6>
                                <button class="btn btn-sm btn-success" id="btnAgregarNota">
                                    <i class="fas fa-plus me-1"></i> Agregar Nota
                                </button>
                            </div>
                            <div id="historialNotas">
                                <!-- Las notas se cargarán dinámicamente -->
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <h6>Estado del Plan de Mejora</h6>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="progress w-75">
                                    <div id="modalProgresoBar" class="progress-bar bg-success" role="progressbar"
                                        style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span id="modalProgresoTexto">0%</span>
                                <button class="btn btn-sm btn-outline-primary" id="btnActualizarProgreso">
                                    <i class="fas fa-edit me-1"></i> Actualizar
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Estado Actual</h6>
                                <div>
                                    <span id="modalEstadoBadge" class="badge badge-estado badge-activo">Activo</span>
                                    <button class="btn btn-sm btn-outline-secondary ms-2" id="btnCambiarEstado">
                                        <i class="fas fa-exchange-alt me-1"></i> Cambiar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="btnGenerarInforme">
                        <i class="fas fa-file-pdf me-1"></i> Generar Informe
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Incluir modales de seguimiento -->
    <div id="modales-container"></div>
    <script>
        // Cargar los modales de seguimiento
        $(document).ready(function () {
            $('#modales-container').load('modales-seguimiento.html');

            // Fix para el problema del backdrop que permanece después de cerrar el modal
            $(document).on('hidden.bs.modal', '.modal', function () {
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
                $('body').css('padding-right', '');
            });
        });
    </script>
</body>

@endsection