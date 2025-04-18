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

    <div class="header-acta mb-4">
        <h1 class="mb-0">Generar Acta de Compromiso para docentes con desempeño < 4</h1>
    </div>

    <!-- Sistema de búsqueda mejorado -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-search me-2"></i>Buscar Docente</h5>
                    <div class="mb-3">
                        <select class="form-select select2-docentes" id="docenteSelect">
                            
                            @if($docentesbusqueda)
                          @foreach($docentesbusqueda as $docente)
                          <option value="">{{ $docente->nombre }}</option>
                         <div class="card mb-2">
                         
                        @endforeach
                         @else
                        <p>No hay docentes disponibles.</p>
                         @endif
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
                                <option value="1">Menor a 3.0</option>
                                <option value="2">Entre 3.0 y 3.5</option>
                                <option value="3">Entre 3.5 y 4.0</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulario de Acta de Compromiso -->
    <div class="form-acta p-0 mb-4">
        <div class="card-body p-4">
            <div class="row">
                <div class="col-md-3 text-center">
                    <div class="avatar-preview mb-3">
                        <i class="fas fa-user fa-5x text-secondary"></i>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Numero de Acta:</label>
                            <input type="text" class="form-control" value="" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Fecha de Generación:</label>
                            <input type="text" class="form-control" value="" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nombre:</label>
                            <input type="text" class="form-control" value="" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Apellido:</label>
                            <input type="text" class="form-control" value="" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Identificación:</label>
                            <input type="text" class="form-control" value="" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Asignatura:</label>
                            <input type="text" class="form-control" value="" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Calificacion Final del Docente:</label>
                            <input type="text" class="form-control calificacion-baja" value="" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row mb-4">
                <div class="col-12">
                    <h5>Resumen de Retroalimentación:</h5>
                    <div id="summernote">Aquí el decano hará sus comentarios hacia el respectivo
                        docente...</div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6 offset-md-3">
                    <h5 class="text-center mb-3">Firma de Decano/ Coordinador</h5>
                    <div class="firma-box">
                        <div id="firma-preview" class="mb-3 d-none">
                            <img id="firma-imagen" src="#" alt="Vista previa de la firma" class="img-fluid"
                                style="max-height: 100px;">
                        </div>
                        <div id="firma-placeholder" class="text-center text-muted mb-3">
                            <i class="fas fa-signature fa-3x"></i>
                            <p class="mt-2">Seleccione una imagen de firma</p>
                        </div>
                        <input type="file" id="firma-input" class="form-control" accept=".png,.jpg,.jpeg"
                            style="display: none;">
                        <button type="button" id="seleccionar-firma" class="btn btn-outline-primary mb-2">
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
                    <button class="btn btn-primary me-2" onclick="generarPDF()">
                        <i class="fas fa-file-pdf me-2"></i>Generar PDF
                    </button>
                    <button class="btn btn-success" onclick="enviarReporte()">
                        <i class="fas fa-paper-plane me-2"></i>Enviar reporte al Docente
                    </button>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

    <!-- html2pdf JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    
    <!-- Scripts específicos del acta -->
    <script src="{{ asset('js/LogicaDecanoCoordinador/acta_script.js') }}"></script>
    <script src="{{ asset('js/LogicaDecanoCoordinador/pdf_generator.js') }}?v={{ time() }}"></script>

    <script>
        $(document).ready(function() {
            // La inicialización de Select2 se maneja en acta-script.js

            // Inicializar Summernote
            $('#summernote').summernote({
                placeholder: 'Escriba aquí sus comentarios y retroalimentación...',
                height: 200,
                dialogsInBody: true,
                dialogsFade: true,
                container: 'body',
                focus: false,
                callbacks: {
                    onImageUpload: function(files) {
                        for (let i = 0; i < files.length; i++) {
                            let reader = new FileReader();
                            reader.onloadend = function() {
                                let img = document.createElement('img');
                                img.src = reader.result;
                                img.style.maxWidth = '100%';
                                $('#summernote').summernote('insertNode', img);
                            }
                            reader.readAsDataURL(files[i]);
                        }
                    }
                },
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
        });

        // Función para generar PDF
        function generarPDF() {
            // Usar la función profesional de generación de PDF que incluye validación de firma
            if (typeof generarPDFProfesional === 'function') {
                generarPDFProfesional();
            } else {
                alert('Error: No se pudo cargar el generador de PDF profesional.');
            }
        }

        // Función para enviar reporte
        function enviarReporte() {
            // Aquí iría la lógica para enviar el reporte por correo electrónico
            alert('El reporte ha sido enviado al docente exitosamente.');
        }
    </script>
@endsection
