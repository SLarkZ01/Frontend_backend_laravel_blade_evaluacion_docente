@extends('layouts.principal')
@section('titulo', 'Editar Acta de Compromiso')
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
        <h1 class="mb-0">Editar Acta de Compromiso</h1>
    </div>

    <!-- Formulario de Edición de Acta de Compromiso -->
    <div class="form-acta p-0 mb-4">
        <div class="card-body p-4">
            <form id="editarActaForm" method="POST" action="{{ route('decano.actualizar_acta', ['id' => $acta->id ?? '']) }}">
                @csrf
                @method('PUT')
                
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
                                <input type="text" name="numero_acta" class="form-control" value="{{ $acta->numero_acta ?? '' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Fecha de Generación:</label>
                                <input type="date" name="fecha_generacion" class="form-control" value="{{ $acta->fecha_generacion ?? date('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Nombre:</label>
                                <input type="text" name="nombre" class="form-control" value="{{ $docente->nombre ?? '' }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Apellido:</label>
                                <input type="text" name="apellido" class="form-control" value="{{ $docente->apellido ?? '' }}" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Identificación:</label>
                                <input type="text" name="identificacion" class="form-control" value="{{ $docente->identificacion ?? '' }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Asignatura:</label>
                                <input type="text" name="asignatura" class="form-control" value="{{ $docente->asignatura ?? '' }}" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Calificacion Final del Docente:</label>
                                <input type="text" name="calificacion" class="form-control calificacion-baja" value="{{ $docente->calificacion ?? '' }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row mb-4">
                    <div class="col-12">
                        <h5>Resumen de Retroalimentación:</h5>
                        <textarea id="summernote" name="retroalimentacion">{{ $acta->retroalimentacion ?? 'Aquí el decano hará sus comentarios hacia el respectivo docente...' }}</textarea>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6 offset-md-3">
                        <h5 class="text-center mb-3">Firma de Decano/ Coordinador</h5>
                        <div class="firma-box">
                            <div id="firma-preview" class="mb-3 {{ isset($acta->firma) ? '' : 'd-none' }}">
                                <img id="firma-imagen" src="{{ $acta->firma ?? '#' }}" alt="Vista previa de la firma" class="img-fluid"
                                    style="max-height: 100px;">
                            </div>
                            <div id="firma-placeholder" class="text-center text-muted mb-3 {{ isset($acta->firma) ? 'd-none' : '' }}">
                                <i class="fas fa-signature fa-3x"></i>
                                <p class="mt-2">Seleccione una imagen de firma</p>
                            </div>
                            <input type="file" id="firma-input" name="firma" class="form-control" accept=".png,.jpg,.jpeg"
                                style="display: none;">
                            <input type="hidden" name="firma_actual" value="{{ $acta->firma ?? '' }}">
                            <button type="button" id="seleccionar-firma" class="btn btn-outline-primary mb-2">
                                <i class="fas fa-upload me-2"></i>Cargar Firma
                            </button>
                            <button type="button" id="eliminar-firma" class="btn btn-outline-danger {{ isset($acta->firma) ? '' : 'd-none' }}">
                                <i class="fas fa-trash me-2"></i>Eliminar Firma
                            </button>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-save me-2"></i>Guardar Cambios
                        </button>
                        <a href="{{ route('decano.acta_compromiso') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Volver
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts específicos del acta -->
    <script src="{{ asset('js/LogicaDecanoCoordinador/acta_script.js') }}"></script>

    <script>
        $(document).ready(function() {
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
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['picture', 'link']],
                    ['view', ['codeview', 'help']]
                ]
            });

            // Manejar la carga de firma
            $('#seleccionar-firma').click(function() {
                $('#firma-input').click();
            });

            $('#firma-input').change(function() {
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#firma-imagen').attr('src', e.target.result);
                        $('#firma-preview').removeClass('d-none');
                        $('#firma-placeholder').addClass('d-none');
                        $('#eliminar-firma').removeClass('d-none');
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });

            $('#eliminar-firma').click(function() {
                $('#firma-input').val('');
                $('#firma-imagen').attr('src', '#');
                $('#firma-preview').addClass('d-none');
                $('#firma-placeholder').removeClass('d-none');
                $(this).addClass('d-none');
                $('input[name="firma_actual"]').val('');
            });
        });
    </script>
@endsection