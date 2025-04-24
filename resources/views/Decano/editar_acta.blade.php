@extends('layouts.principal')
@section('titulo', 'Editar Acta de Compromiso')
@section('menu-sidebar')

    <li class="nav-item">
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
    <li class="nav-item active">
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

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Formulario de Edición de Acta de Compromiso -->
    <form action="{{ route('decano.actualizar_acta', $acta->id) }}" method="POST" enctype="multipart/form-data" class="mb-5">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Formulario de Edición de Acta de Compromiso</h5>
            </div>
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
                                <input type="text" name="numero_acta" class="form-control" value="{{ old('numero_acta', $acta->numero_acta) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Fecha de Generación:</label>
                                <input type="date" name="fecha_generacion" class="form-control" value="{{ old('fecha_generacion', $acta->fecha_generacion->format('Y-m-d')) }}" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Nombre:</label>
                                <input type="text" name="nombre_docente" id="nombre_docente" class="form-control" value="{{ old('nombre_docente', $acta->nombre_docente) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Apellido:</label>
                                <input type="text" name="apellido_docente" id="apellido_docente" class="form-control" value="{{ old('apellido_docente', $acta->apellido_docente) }}" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Identificación:</label>
                                <input type="text" name="identificacion_docente" id="identificacion_docente" class="form-control" value="{{ old('identificacion_docente', $acta->identificacion_docente) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Asignatura:</label>
                                <input type="text" name="asignatura" id="asignatura" class="form-control" value="{{ old('asignatura', $acta->asignatura) }}" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Calificacion Final del Docente:</label>
                                <input type="number" name="calificacion_final" id="calificacion_final" class="form-control calificacion-baja" value="{{ old('calificacion_final', $acta->calificacion_final) }}" step="0.01" min="0" max="5" required>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row mb-4">
                    <div class="col-12">
                        <h5>Resumen de Retroalimentación:</h5>
                        <textarea name="retroalimentacion" id="summernote" class="form-control">{{ old('retroalimentacion', $acta->retroalimentacion) }}</textarea>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6 offset-md-3">
                        <h5 class="text-center mb-3">Firma de Decano/ Coordinador</h5>
                        <div class="firma-box">
                            @if($acta->firma_path)
                            <div id="firma-preview" class="mb-3">
                                <img id="firma-imagen" src="{{ asset('storage/' . $acta->firma_path) }}" alt="Firma actual" class="img-fluid" style="max-height: 100px;">
                            </div>
                            @else
                            <div id="firma-preview" class="mb-3 d-none">
                                <img id="firma-imagen" src="#" alt="Vista previa de la firma" class="img-fluid" style="max-height: 100px;">
                            </div>
                            <div id="firma-placeholder" class="text-center text-muted mb-3">
                                <i class="fas fa-signature fa-3x"></i>
                                <p class="mt-2">No hay firma cargada</p>
                            </div>
                            @endif
                            <input type="file" name="firma" id="firma-input" class="form-control" accept=".png,.jpg,.jpeg">
                            <small class="form-text text-muted">Deje este campo vacío si no desea cambiar la firma actual.</small>
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
            </div>
        </div>
    </form>

    <!-- Scripts específicos del acta -->
    <script>
        $(document).ready(function() {
            // Inicializar Select2 para búsqueda de docentes
            $('.select2-docentes').select2({
                placeholder: "Buscar docente...",
                allowClear: true
            });

            // Inicializar Summernote para el editor de texto enriquecido
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

            // Vista previa de la firma
            $('#firma-input').on('change', function(e) {
                if (e.target.files && e.target.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#firma-imagen').attr('src', e.target.result);
                        $('#firma-preview').removeClass('d-none');
                        $('#firma-placeholder').addClass('d-none');
                    }
                    reader.readAsDataURL(e.target.files[0]);
                }
            });

            // Manejar la selección de docente
            $('#docenteSelect').on('change', function() {
                var option = $(this).find('option:selected');
                $('#nombre_docente').val(option.data('nombre'));
                $('#apellido_docente').val(option.data('apellido'));
                $('#identificacion_docente').val(option.data('identificacion'));
                $('#asignatura').val(option.data('asignatura'));
                $('#calificacion_final').val(option.data('calificacion'));
            });
        });
    </script>
@endsection