@extends('layouts.principal')
@section('titulo', 'Acta de Compromiso')
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
        <a href="{{ route('user.login') }}">
            <i class="fas fa-sign-out-alt"></i>
            <p>Cerrar Sesión</p>
        </a>
    </li>
@endsection
@section('name-perfil')
<span>
    Jose Jimenez
<span class="user-level">Decano</span>
<span class="caret"></span>
</span>
@endsection
@section('contenido')

    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- Sidebar / Menú lateral -->
            
            <!-- Contenido principal -->

                    <div class="header-sancion mb-4">
                        <h1 class="mb-0">Proceso de Sanción o Retiro Docente</h1>
                    </div>

                    <!-- Sistema de búsqueda mejorado -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><i class="fas fa-search me-2"></i>Buscar Docente</h5>
                                    <div class="mb-3">
                                        <select class="form-select select2-docentes" id="docenteSelect">
                                            <option value="">Seleccione un docente</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><i class="fas fa-filter me-2"></i>Filtros</h5>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <select class="form-select" id="departamentoSelect">
                                                <option value="">Todos los departamentos</option>
                                                <option value="1">Ciencias Exactas</option>
                                                <option value="2">Ingeniería</option>
                                                <option value="3">Humanidades</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <select class="form-select" id="calificacionSelect">
                                                <option value="">Todas las calificaciones</option>
                                                <option value="1">Menor a 2.5</option>
                                                <option value="2">Entre 2.5 y 2.7</option>
                                                <option value="3">Entre 2.7 y 3.0</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de Procesos de Sanción Existentes -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-list me-2"></i>Procesos de Sanción Registrados</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Resolución</th>
                                            <th>Fecha</th>
                                            <th>Docente</th>
                                            <th>Asignatura</th>
                                            <th>Calificación</th>
                                            <th>Tipo Sanción</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabla-procesos">
                                        @if(isset($procesos) && count($procesos) > 0)
                                            @foreach($procesos as $proceso)
                                            <tr>
                                                <td>{{ $proceso->numero_resolucion }}</td>
                                                <td>{{ date('d/m/Y', strtotime($proceso->fecha_emision)) }}</td>
                                                <td>{{ $proceso->nombre_docente }} {{ $proceso->apellido_docente }}</td>
                                                <td>{{ $proceso->asignatura }}</td>
                                                <td class="{{ $proceso->calificacion_final < 3.0 ? 'text-danger' : '' }}">{{ $proceso->calificacion_final }}</td>
                                                <td>
                                                    @if($proceso->tipo_sancion == 'leve')
                                                        <span class="badge bg-warning">Leve</span>
                                                    @elseif($proceso->tipo_sancion == 'grave')
                                                        <span class="badge bg-danger">Grave</span>
                                                    @elseif($proceso->tipo_sancion == 'retiro')
                                                        <span class="badge bg-dark">Retiro</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($proceso->enviado)
                                                        <span class="badge bg-success">Enviado</span>
                                                    @else
                                                        <span class="badge bg-secondary">Borrador</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button class="btn btn-sm btn-info" onclick="editarProceso({{ $proceso->id_sancion }})">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger" onclick="eliminarProceso({{ $proceso->id_sancion }})">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                        @if(!$proceso->enviado)
                                                        <button class="btn btn-sm btn-success" onclick="enviarProceso({{ $proceso->id_sancion }})">
                                                            <i class="fas fa-paper-plane"></i>
                                                        </button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="8" class="text-center">No hay procesos de sanción registrados</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3">
                                <button class="btn btn-primary" id="btn-nuevo-proceso">
                                    <i class="fas fa-plus me-2"></i>Nuevo Proceso de Sanción
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Formulario de Sanción o Retiro -->
                    <div class="form-sancion p-0 mb-4" id="formulario-sancion" style="display: none;">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0" id="form-title">Nuevo Proceso de Sanción</h5>
                            </div>
                            <div class="card-body p-4">
                                <form id="form-proceso-sancion">
                                    <input type="hidden" id="id_sancion" name="id_sancion">
                                    <div class="row">
                                        <div class="col-md-3 text-center">
                                            <div class="avatar-preview mb-3">
                                                <i class="fas fa-user fa-5x text-secondary"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Número de Resolución:</label>
                                                    <input type="text" class="form-control" id="numeroResolucion" name="numero_resolucion" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Fecha de Emisión:</label>
                                                    <input type="date" class="form-control" id="fechaEmision" name="fecha_emision" value="{{ date('Y-m-d') }}" required>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Nombre:</label>
                                                    <input type="text" class="form-control" id="nombreDocente" name="nombre_docente" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Apellido:</label>
                                                    <input type="text" class="form-control" id="apellidoDocente" name="apellido_docente" required>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Identificación:</label>
                                                    <input type="text" class="form-control" id="identificacionDocente" name="identificacion_docente" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Asignatura:</label>
                                                    <input type="text" class="form-control" id="asignaturaDocente" name="asignatura" required>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Calificación Final:</label>
                                                    <input type="number" step="0.01" min="0" max="5" class="form-control calificacion-baja" id="calificacionDocente" name="calificacion_final" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Tipo de Sanción:</label>
                                                    <select class="form-select" id="tipoSancionSelect" name="tipo_sancion" required>
                                                        <option value="">Seleccione tipo de sanción</option>
                                                        <option value="leve">Sanción Leve</option>
                                                        <option value="grave">Sanción Grave</option>
                                                        <option value="retiro">Retiro Definitivo</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>
                                    
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <h5>Antecedentes y Justificación:</h5>
                                            <div class="mb-3">
                                                <textarea id="antecedentes" name="antecedentes" class="form-control summernote">Describa aquí los antecedentes y el historial de evaluaciones del docente que justifican esta sanción...</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <h5>Fundamentos Normativos:</h5>
                                            <div class="mb-3">
                                                <textarea id="fundamentos" name="fundamentos" class="form-control summernote">Especifique aquí los reglamentos, estatutos y normativas institucionales que fundamentan esta decisión...</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <h5>Resolución y Medidas Adoptadas:</h5>
                                            <div class="mb-3">
                                                <textarea id="resolucion" name="resolucion" class="form-control summernote">Detalle aquí la resolución específica y las medidas disciplinarias adoptadas...</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <div class="col-md-6 offset-md-3">
                                            <h5 class="text-center mb-3">Firma de Decano/ Coordinador</h5>
                                            <div class="firma-box">
                                                <div id="firma-preview" class="mb-3 d-none">
                                                    <img id="firma-imagen" src="#" alt="Vista previa de la firma"
                                                        class="img-fluid" style="max-height: 100px;">
                                                </div>
                                                <div id="firma-placeholder" class="text-center text-muted mb-3">
                                                    <i class="fas fa-signature fa-3x"></i>
                                                    <p class="mt-2">Seleccione una imagen de firma</p>
                                                </div>
                                                <input type="file" id="firma-input" name="firma" class="form-control"
                                                    accept=".png,.jpg,.jpeg" style="display: none;">
                                                <button type="button" id="seleccionar-firma"
                                                    class="btn btn-outline-primary mb-2">
                                                    <i class="fas fa-upload me-2"></i>Cargar Firma
                                                </button>
                                                <button type="button" id="eliminar-firma" class="btn btn-outline-danger d-none">
                                                    <i class="fas fa-trash me-2"></i>Eliminar Firma
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-12 text-center">
                                            <button type="button" class="btn btn-secondary me-2" id="btn-cancelar">
                                                <i class="fas fa-times me-2"></i>Cancelar
                                            </button>
                                            <button type="submit" class="btn btn-primary me-2" id="btn-guardar">
                                                <i class="fas fa-save me-2"></i>Guardar Proceso
                                            </button>
                                            <button type="button" class="btn btn-danger me-2" id="btn-generar-pdf">
                                                <i class="fas fa-file-pdf me-2"></i>Generar PDF
                                            </button>
                                            <button type="button" class="btn btn-dark" id="btn-enviar">
                                                <i class="fas fa-paper-plane me-2"></i>Enviar al Docente
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</body>

</html>

    <!-- Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
    <!-- html2pdf JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <!-- Script específico para proceso de sanción -->
    <script src="{{asset('js/LogicaDecanoCoordinador/sancion_script.js')}}"></script>
    <!-- Script para generación profesional de PDF -->
    <script src="{{asset('js/LogicaDecanoCoordinador/pdf_generator.js')}}"></script>
    <!-- Script para generación profesional de PDF de sanción -->
    <script src="{{asset('js/LogicaDecanoCoordinador/sancion_pdf_generator.js')}}"></script>

    <script>
        $(document).ready(function () {
            // Inicializar Summernote para los editores de texto enriquecido
            $('#antecedentes, #fundamentos, #resolucion').summernote({
                placeholder: 'Escriba aquí...',
                tabsize: 2,
                height: 150,
                dialogsInBody: true,
                dialogsFade: true,
                container: 'body',
                focus: false,
                popover: {
                    image: [
                        ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
                        ['float', ['floatLeft', 'floatRight', 'floatNone']],
                        ['remove', ['removeMedia']]
                    ],
                    link: [
                        ['link', ['linkDialogShow', 'unlink']]
                    ],
                    air: []
                },
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['picture', 'link', 'video']],
                    ['view', ['codeview', 'help']]
                ]
            });

            // Manejar carga de firma
            $('#seleccionar-firma').click(function() {
                $('#firma-input').click();
            });

            $('#firma-input').change(function(e) {
                if (e.target.files && e.target.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#firma-imagen').attr('src', e.target.result);
                        $('#firma-preview').removeClass('d-none');
                        $('#firma-placeholder').addClass('d-none');
                        $('#eliminar-firma').removeClass('d-none');
                    }
                    reader.readAsDataURL(e.target.files[0]);
                }
            });

            $('#eliminar-firma').click(function() {
                $('#firma-input').val('');
                $('#firma-preview').addClass('d-none');
                $('#firma-placeholder').removeClass('d-none');
                $(this).addClass('d-none');
            });
        });



        // Función para simular el envío de la resolución
        function enviarResolucion() {
            // Verificar si se ha seleccionado un docente
            if (!$('#nombreDocente').val()) {
                alert('Por favor, seleccione un docente antes de enviar la resolución.');
                return;
            }

            // Verificar si se ha seleccionado un tipo de sanción
            if (!$('#tipoSancionSelect').val()) {
                alert('Por favor, seleccione un tipo de sanción antes de enviar la resolución.');
                return;
            }

            // Mostrar mensaje de confirmación
            if (confirm('¿Está seguro que desea enviar esta resolución al docente?')) {
                // Simular envío
                setTimeout(function() {
                    alert('Resolución enviada correctamente al docente ' + $('#nombreDocente').val() + ' ' + $('#apellidoDocente').val());
                }, 1000);
            }
        }
    </script>
@endsection