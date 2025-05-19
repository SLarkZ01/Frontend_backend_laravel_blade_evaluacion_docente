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

    <div class="header-acta mb-4">
        <h1 class="mb-0">Generar Acta de Compromiso para docentes con desempeño < 4</h1>
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

    <!-- Sistema de búsqueda mejorado -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-search me-2"></i>Buscar Docente</h5>
                    <div class="mb-3">
                        <select class="form-select select2-docentes" id="docenteSelect">
                            <option value="">Seleccione un docente</option>
                            @if ($docentesbusqueda)
                                @foreach ($docentesbusqueda as $docente)
                                    <option value="{{ $docente->id ?? '' }}" 
                                        data-nombre="{{ $docente->nombre ?? '' }}" 
                                        data-apellido="{{ $docente->apellido ?? '' }}" 
                                        data-identificacion="{{ $docente->identificacion ?? '' }}" 
                                        data-asignatura="{{ $docente->asignatura ?? '' }}" 
                                        data-calificacion="{{ $docente->calificacion ?? '' }}">
                                        {{ $docente->nombre ?? '' }} {{ $docente->apellido ?? '' }} - {{ $docente->asignatura ?? '' }}
                                    </option>
                                @endforeach
                            @else
                                <option value="">No hay docentes disponibles.</option>
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

    <!-- Lista de Actas de Compromiso -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"><i class="fas fa-list me-2"></i>Actas de Compromiso Existentes</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Número de Acta</th>
                                    <th>Docente</th>
                                    <th>Fecha</th>
                                    <th>Calificación</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($actas) && count($actas) > 0)
                                    @foreach($actas as $acta)
                                    <tr>
                                        <td>{{ $acta->numero_acta ?? 'N/A' }}</td>
                                        <td>{{ $acta->nombre_docente ?? 'N/A' }}</td>
                                        <td>{{ $acta->fecha_generacion ?? 'N/A' }}</td>
                                        <td><span class="badge bg-danger">{{ $acta->calificacion ?? 'N/A' }}</span></td>
                                        <td>
                                            <a href="{{ route('decano.editar_acta', ['id' => $acta->id_acta]) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i> Editar
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center">No hay actas de compromiso registradas</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulario de Acta de Compromiso -->
    <form action="{{ route('decano.guardar_acta') }}" method="POST" enctype="multipart/form-data" class="mb-5">
        @csrf
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Formulario de Acta de Compromiso</h5>
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
                                <input type="text" name="numero_acta" class="form-control" value="{{ old('numero_acta') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Fecha de Generación:</label>
                                <input type="date" name="fecha_generacion" class="form-control" value="{{ old('fecha_generacion', date('Y-m-d')) }}" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Nombre:</label>
                                <input type="text" name="nombre_docente" id="nombre_docente" class="form-control" value="{{ old('nombre_docente') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Apellido:</label>
                                <input type="text" name="apellido_docente" id="apellido_docente" class="form-control" value="{{ old('apellido_docente') }}" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Identificación:</label>
                                <input type="text" name="identificacion_docente" id="identificacion_docente" class="form-control" value="{{ old('identificacion_docente') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Asignatura:</label>
                                <input type="text" name="asignatura" id="asignatura" class="form-control" value="{{ old('asignatura') }}" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Calificacion Final del Docente:</label>
                                <input type="number" name="calificacion_final" id="calificacion_final" class="form-control calificacion-baja" value="{{ old('calificacion_final') }}" step="0.01" min="0" max="5" required>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row mb-4">
                    <div class="col-12">
                        <h5>Resumen de Retroalimentación:</h5>
                        <textarea name="retroalimentacion" id="summernote" class="form-control">{{ old('retroalimentacion', 'Aquí el decano hará sus comentarios hacia el respectivo docente...') }}</textarea>
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
                            <input type="file" name="firma" id="firma-input" class="form-control" accept=".png,.jpg,.jpeg">
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-save me-2"></i>Guardar Acta
                        </button>
                        <button type="reset" class="btn btn-secondary">
                            <i class="fas fa-undo me-2"></i>Limpiar Formulario
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Listado de Actas de Compromiso -->
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Actas de Compromiso Registradas</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Número</th>
                            <th>Fecha</th>
                            <th>Docente</th>
                            <th>Asignatura</th>
                            <th>Calificación</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($actas) && count($actas) > 0)
                            @foreach($actas as $acta)
                                <tr>
                                    <td>{{ $acta->numero_acta }}</td>
                                    <td>{{ $acta->fecha_generacion->format('d/m/Y') }}</td>
                                    <td>{{ $acta->nombre_docente }} {{ $acta->apellido_docente }}</td>
                                    <td>{{ $acta->asignatura }}</td>
                                    <td>
                                        <span class="badge {{ $acta->calificacion_final < 3.0 ? 'bg-danger' : ($acta->calificacion_final < 3.5 ? 'bg-warning' : 'bg-info') }}">
                                            {{ number_format($acta->calificacion_final, 2) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $acta->enviado ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $acta->enviado ? 'Enviada' : 'Pendiente' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('decano.editar_acta', $acta->id_acta) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @if(!$acta->enviado)
                                                <form action="{{ route('decano.enviar_acta', $acta->id_acta) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-sm btn-success">
                                                        <i class="fas fa-paper-plane"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            <form action="{{ route('decano.eliminar_acta', $acta->id_acta) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Está seguro de eliminar esta acta?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center">No hay actas de compromiso registradas</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Scripts específicos del acta -->
    <script>
        $(document).ready(function() {
            // Inicializar Select2
            $('.select2-docentes').select2({
                placeholder: "Buscar docente...",
                allowClear: true
            });

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

            // Manejar la selección de docente
            $('#docenteSelect').on('change', function() {
                var option = $(this).find('option:selected');
                $('#nombre_docente').val(option.data('nombre'));
                $('#apellido_docente').val(option.data('apellido'));
                $('#identificacion_docente').val(option.data('identificacion'));
                $('#asignatura').val(option.data('asignatura'));
                $('#calificacion_final').val(option.data('calificacion'));
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
        });
    </script>
@endsection