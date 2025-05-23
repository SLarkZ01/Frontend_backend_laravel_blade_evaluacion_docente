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
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
<!-- Lista de Actas de Compromiso Existentes -->
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
                                        <td>{{ $acta->nombre_docente ?? 'N/A' }} {{ $acta->apellido_docente ?? '' }}</td>
                                        <td>{{ $acta->fecha_generacion ?? 'N/A' }}</td>
                                        <td><span class="badge bg-danger">{{ $acta->promedio_total ?? 'N/A' }}</span></td>
                                        <td>
                                            <a href="{{ route('decano.acta_compromiso_edit', $acta->id) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i> Editar
                                            </a>
                                            <a href="{{ route('decano.ver_acta', $acta->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> Ver
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
    <!-- CORREGIDO: La ruta debe coincidir con la del controlador -->
    <form action="{{ route('guardar.acta_compromiso') }}" method="POST" enctype="multipart/form-data" class="mb-5" id="actaForm">
     id="actaForm">
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
                            <div class="col-md-12">
                                <label class="form-label">Seleccione un docente: <span class="text-danger">*</span></label>
                                <select class="form-select select2-docentes" id="docenteSelect" name="id_docente" required>
                                    <option value="">Seleccione un docente</option>
                                    @if (isset($docentesbusqueda) && count($docentesbusqueda) > 0)
                                        @foreach ($docentesbusqueda as $docente)
                                        <option value="{{ $docente->id_docente }}"
                                                data-nombre="{{ $docente->nombre_docente }}"
                                                data-apellido="{{ $docente->apellido_docente }}"
                                                data-identificacion="{{ $docente->identificacion_docente }}"
                                                data-curso="{{ $docente->programa ?? $docente->curso }}"
                                                data-promedio="{{ $docente->promedio_total }}"
                                                {{ old('id_docente') == $docente->id_docente ? 'selected' : '' }}>
                                                {{ $docente->nombre_docente }} {{ $docente->apellido_docente }} - {{ $docente->programa ?? $docente->curso }}
                                        </option>
                                        @endforeach
                                    @else
                                        <option value="">No hay docentes disponibles.</option>
                                    @endif
                                </select>
                                @error('id_docente')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Número de Acta: <span class="text-danger">*</span></label>
                                <input type="text" name="numero_acta" class="form-control @error('numero_acta') is-invalid @enderror" 
                                       value="{{ old('numero_acta') }}" required>
                                @error('numero_acta')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Fecha de Generación: <span class="text-danger">*</span></label>
                                <input type="date" name="fecha_generacion" class="form-control @error('fecha_generacion') is-invalid @enderror" 
                                       value="{{ old('fecha_generacion', date('Y-m-d')) }}" required>
                                @error('fecha_generacion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Nombre:</label>
                                <input type="text" name="nombre_docente" id="nombre_docente" 
                                       class="form-control @error('nombre_docente') is-invalid @enderror" 
                                        value="{{ old('nombre_docente') }}">
                                @error('nombre_docente')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Apellido:</label>
                                <input type="text" name="apellido_docente" id="apellido_docente" 
                                       class="form-control @error('apellido_docente') is-invalid @enderror" 
                                        value="{{ old('apellido_docente') }}">
                                @error('apellido_docente')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="identificacion_docente" class="form-label">Identificación:</label>
                                    <input type="text" id="identificacion_docente" name="identificacion_docente" 
                                           class="form-control @error('identificacion_docente') is-invalid @enderror" 
                                           value="{{ old('identificacion_docente') }}">
                                    @error('identificacion_docente')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Curso:</label>
                                <input type="text" name="curso" id="curso" 
                                       class="form-control @error('curso') is-invalid @enderror" 
                                        value="{{ old('curso') }}">
                                @error('curso')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Calificación Final del Docente:</label>
                                <input type="number" name="promedio_total" id="promedio_total" 
                                       class="form-control @error('promedio_total') is-invalid @enderror" 
                                       step="0.01" min="0" max="5" value="{{ old('promedio_total') }}">
                                @error('promedio_total')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row mb-4">
                    <div class="col-12">
                        <h5>Resumen de Retroalimentación: <span class="text-danger">*</span></h5>
                        <textarea name="retroalimentacion" id="summernote" 
                                  class="form-control @error('retroalimentacion') is-invalid @enderror" 
                                  rows="5" required>{{ old('retroalimentacion', 'Aquí el decano hará sus comentarios hacia el respectivo docente...') }}</textarea>
                        @error('retroalimentacion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
                            <input type="file" name="firma" id="firma-input" 
                                   class="form-control @error('firma') is-invalid @enderror" 
                                   accept=".png,.jpg,.jpeg">
                            @error('firma')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary me-2" id="guardarBtn">
                            <i class="fas fa-save me-2"></i>Guardar Acta
                        </button>
                        <button type="reset" class="btn btn-secondary" id="limpiarBtn">
                            <i class="fas fa-undo me-2"></i>Limpiar Formulario
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- Fin del formulario de Acta de Compromiso -->
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


    <!-- Mostrar mensajes de éxito o error -->
    {{-- @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Estilos para las promedio_totales -->
    <style>
    .promedio_total-baja {
        background-color: #ffcccc !important;
    }
    .promedio_total-media {
        background-color: #ffffcc !important;
    }
    .promedio_total-alta {
        background-color: #ccffcc !important;
    }
    </style>

    <!-- Scripts para el manejo del formulario -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Scripts cargados correctamente');
        
        // Configurar CSRF para peticiones AJAX
        if (typeof $ !== 'undefined') {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        }

        // 1. MANEJO DEL SELECT DE DOCENTES
        $('#docenteSelect').on('change', function() {
            console.log('Docente seleccionado:', $(this).val());
            
            var selectedOption = $(this).find('option:selected');
            
            if (selectedOption.val()) {
                $('#nombre_docente').val(selectedOption.data('nombre') || '');
                $('#apellido_docente').val(selectedOption.data('apellido') || '');
                $('#identificacion_docente').val(selectedOption.data('identificacion') || '');
                $('#curso').val(selectedOption.data('curso') || '');
                $('#promedio_total').val(selectedOption.data('promedio') || '');

                // Cambiar el color del campo de calificación según el valor
                const promedio_totalInput = document.getElementById('promedio_total');
                promedio_totalInput.classList.remove('promedio_total-baja', 'promedio_total-media', 'promedio_total-alta');

                const promedio_totalValue = parseFloat(selectedOption.data('promedio'));
                if (promedio_totalValue < 3) {
                    promedio_totalInput.classList.add('promedio_total-baja');
                } else if (promedio_totalValue < 4) {
                    promedio_totalInput.classList.add('promedio_total-media');
                } else {
                    promedio_totalInput.classList.add('promedio_total-alta');
                }
            } else {
                // Limpiar campos si no hay selección
                $('#nombre_docente, #apellido_docente, #identificacion_docente, #curso, #promedio_total').val('');
            }
        });

        // 2. MANEJO DE LA VISTA PREVIA DE LA FIRMA
        $('#firma-input').on('change', function(e) {
            var file = e.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#firma-imagen').attr('src', e.target.result);
                    $('#firma-preview').removeClass('d-none');
                    $('#firma-placeholder').addClass('d-none');
                }
                reader.readAsDataURL(file);
            } else {
                $('#firma-preview').addClass('d-none');
                $('#firma-placeholder').removeClass('d-none');
            }
        });

        // 3. VALIDACIÓN Y MANEJO DEL ENVÍO DEL FORMULARIO
        $('#actaForm').on('submit', function(e) {
            console.log('Formulario enviándose...');
            console.log('Datos del formulario:', new FormData(this));
            
            var isValid = true;
            var errorMessages = [];

            // Validar docente seleccionado
            if (!$('#docenteSelect').val()) {
                isValid = false;
                errorMessages.push('Debe seleccionar un docente');
                $('#docenteSelect').addClass('is-invalid');
            } else {
                $('#docenteSelect').removeClass('is-invalid');
            }

            // Validar número de acta
            if (!$('input[name="numero_acta"]').val().trim()) {
                isValid = false;
                errorMessages.push('El número de acta es requerido');
                $('input[name="numero_acta"]').addClass('is-invalid');
            } else {
                $('input[name="numero_acta"]').removeClass('is-invalid');
            }

            // Validar retroalimentación
            var retroalimentacion = $('textarea[name="retroalimentacion"]').val().trim();
            if (!retroalimentacion || retroalimentacion === 'Aquí el decano hará sus comentarios hacia el respectivo docente...') {
                isValid = false;
                errorMessages.push('Debe proporcionar una retroalimentación válida');
                $('textarea[name="retroalimentacion"]').addClass('is-invalid');
            } else {
                $('textarea[name="retroalimentacion"]').removeClass('is-invalid');
            }

            // Si hay errores, prevenir envío
            if (!isValid) {
                e.preventDefault();
                alert('Por favor corrija los siguientes errores:\n' + errorMessages.join('\n'));
                console.log('Errores de validación:', errorMessages);
                return false;
            }

            // Si todo está bien, cambiar estado del botón
            $('#guardarBtn')
                .prop('disabled', true)
                .html('<i class="fas fa-spinner fa-spin me-2"></i>Guardando...');
            
            console.log('Formulario válido, enviando...');
        });

        // 4. MANEJO DEL BOTÓN DE LIMPIAR
        $('#limpiarBtn').on('click', function() {
            console.log('Limpiando formulario...');
            
            setTimeout(function() {
                // Limpiar vista previa de firma
                $('#firma-preview').addClass('d-none');
                $('#firma-placeholder').removeClass('d-none');
                
                // Limpiar Summernote si está disponible
                if (typeof $.fn.summernote !== 'undefined') {
                    $('#summernote').summernote('code', 'Aquí el decano hará sus comentarios hacia el respectivo docente...');
                } else {
                    $('#summernote').val('Aquí el decano hará sus comentarios hacia el respectivo docente...');
                }
                
                // Remover clases de validación
                $('.is-invalid').removeClass('is-invalid');
                
                // Restablecer botón
                $('#guardarBtn')
                    .prop('disabled', false)
                    .html('<i class="fas fa-save me-2"></i>Guardar Acta');
                    
            }, 100);
        });

        // 5. INICIALIZAR SUMMERNOTE SI ESTÁ DISPONIBLE
        if (typeof $.fn.summernote !== 'undefined') {
            $('#summernote').summernote({
                height: 150,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        }

        // 6. RESTABLECER BOTÓN SI HAY ERRORES DE VALIDACIÓN DEL SERVIDOR
        if ($('.alert-danger').length > 0) {
            $('#guardarBtn')
                .prop('disabled', false)
                .html('<i class="fas fa-save me-2"></i>Guardar Acta');
        }

        console.log('Configuración completa');
    });
    </script> --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Estilos para las promedio_totales -->
    <style>
    .promedio_total-baja {
        background-color: #ffcccc !important;
    }
    .promedio_total-media {
        background-color: #ffffcc !important;
    }
    .promedio_total-alta {
        background-color: #ccffcc !important;
    }
    </style>

    <!-- Scripts para el manejo del formulario -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Scripts cargados correctamente');
        
        // Configurar CSRF para peticiones AJAX
        if (typeof $ !== 'undefined') {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        }

        // Función para mostrar mensajes de alerta
        function showAlert(type, message) {
            // Remover alertas existentes
            $('.alert').remove();
            
            const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            const iconClass = type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-circle';
            
            const alertHtml = `
                <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                    <i class="${iconClass} me-2"></i>${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
            
            // Insertar la alerta al inicio del contenedor principal
            $('#actaForm').prepend(alertHtml);
            
            // Scroll hacia arriba para mostrar la alerta
            $('html, body').animate({scrollTop: 0}, 500);
        }

        // 1. MANEJO DEL SELECT DE DOCENTES
        $('#docenteSelect').on('change', function() {
            console.log('Docente seleccionado:', $(this).val());
            
            var selectedOption = $(this).find('option:selected');
            
            if (selectedOption.val()) {
                $('#nombre_docente').val(selectedOption.data('nombre') || '');
                $('#apellido_docente').val(selectedOption.data('apellido') || '');
                $('#identificacion_docente').val(selectedOption.data('identificacion') || '');
                $('#curso').val(selectedOption.data('curso') || '');
                $('#promedio_total').val(selectedOption.data('promedio') || '');

                // Cambiar el color del campo de calificación según el valor
                const promedio_totalInput = document.getElementById('promedio_total');
                promedio_totalInput.classList.remove('promedio_total-baja', 'promedio_total-media', 'promedio_total-alta');

                const promedio_totalValue = parseFloat(selectedOption.data('promedio'));
                if (promedio_totalValue < 3) {
                    promedio_totalInput.classList.add('promedio_total-baja');
                } else if (promedio_totalValue < 4) {
                    promedio_totalInput.classList.add('promedio_total-media');
                } else {
                    promedio_totalInput.classList.add('promedio_total-alta');
                }
            } else {
                // Limpiar campos si no hay selección
                $('#nombre_docente, #apellido_docente, #identificacion_docente, #curso, #promedio_total').val('');
            }
        });

        // 2. MANEJO DE LA VISTA PREVIA DE LA FIRMA
        $('#firma-input').on('change', function(e) {
            var file = e.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#firma-imagen').attr('src', e.target.result);
                    $('#firma-preview').removeClass('d-none');
                    $('#firma-placeholder').addClass('d-none');
                }
                reader.readAsDataURL(file);
            } else {
                $('#firma-preview').addClass('d-none');
                $('#firma-placeholder').removeClass('d-none');
            }
        });

        // 3. VALIDACIÓN Y MANEJO DEL ENVÍO DEL FORMULARIO (MODIFICADO PARA API)
        $('#actaForm').on('submit', function(e) {
            e.preventDefault(); // Prevenir envío tradicional del formulario
            
            console.log('Formulario enviándose via AJAX...');
            
            var isValid = true;
            var errorMessages = [];

            // Validar docente seleccionado
            if (!$('#docenteSelect').val()) {
                isValid = false;
                errorMessages.push('Debe seleccionar un docente');
                $('#docenteSelect').addClass('is-invalid');
            } else {
                $('#docenteSelect').removeClass('is-invalid');
            }

            // Validar número de acta
            if (!$('input[name="numero_acta"]').val().trim()) {
                isValid = false;
                errorMessages.push('El número de acta es requerido');
                $('input[name="numero_acta"]').addClass('is-invalid');
            } else {
                $('input[name="numero_acta"]').removeClass('is-invalid');
            }

            // Validar retroalimentación
            var retroalimentacion = $('textarea[name="retroalimentacion"]').val().trim();
            if (!retroalimentacion || retroalimentacion === 'Aquí el decano hará sus comentarios hacia el respectivo docente...') {
                isValid = false;
                errorMessages.push('Debe proporcionar una retroalimentación válida');
                $('textarea[name="retroalimentacion"]').addClass('is-invalid');
            } else {
                $('textarea[name="retroalimentacion"]').removeClass('is-invalid');
            }

            // Si hay errores, mostrar alerta y detener
            if (!isValid) {
                showAlert('error', 'Por favor corrija los siguientes errores:\n' + errorMessages.join('\n'));
                console.log('Errores de validación:', errorMessages);
                return false;
            }

            // Cambiar estado del botón
            $('#guardarBtn')
                .prop('disabled', true)
                .html('<i class="fas fa-spinner fa-spin me-2"></i>Guardando...');

            // Preparar FormData para envío
            var formData = new FormData(this);
            
            // Realizar petición AJAX
            $.ajax({
                url: $(this).attr('action') || '/api/actas-compromiso', // URL de la API
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    console.log('Respuesta exitosa:', response);
                    
                    // Mostrar mensaje de éxito
                    if (response.success) {
                        showAlert('success', response.message || 'Acta de compromiso creada correctamente');
                        
                        // Opcional: Limpiar formulario después de éxito
                        setTimeout(function() {
                            $('#limpiarBtn').click();
                        }, 2000);
                        
                    } else {
                        showAlert('error', response.message || 'Error al procesar la solicitud');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error en la petición:', xhr, status, error);
                    
                    let errorMessage = 'Error al guardar el acta de compromiso';
                    
                    if (xhr.responseJSON) {
                        if (xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        } else if (xhr.responseJSON.errors) {
                            // Manejar errores de validación del servidor
                            let errors = xhr.responseJSON.errors;
                            let errorList = [];
                            
                            for (let field in errors) {
                                errorList.push(errors[field][0]);
                            }
                            
                            errorMessage = errorList.join('\n');
                        }
                    } else if (xhr.status === 422) {
                        errorMessage = 'Error de validación. Por favor revise los datos ingresados.';
                    } else if (xhr.status === 500) {
                        errorMessage = 'Error interno del servidor. Por favor intente nuevamente.';
                    }
                    
                    showAlert('error', errorMessage);
                },
                complete: function() {
                    // Restablecer botón siempre
                    $('#guardarBtn')
                        .prop('disabled', false)
                        .html('<i class="fas fa-save me-2"></i>Guardar Acta');
                }
            });
        });

        // 4. MANEJO DEL BOTÓN DE LIMPIAR
        $('#limpiarBtn').on('click', function() {
            console.log('Limpiando formulario...');
            
            setTimeout(function() {
                // Limpiar vista previa de firma
                $('#firma-preview').addClass('d-none');
                $('#firma-placeholder').removeClass('d-none');
                
                // Limpiar Summernote si está disponible
                if (typeof $.fn.summernote !== 'undefined') {
                    $('#summernote').summernote('code', 'Aquí el decano hará sus comentarios hacia el respectivo docente...');
                } else {
                    $('#summernote').val('Aquí el decano hará sus comentarios hacia el respectivo docente...');
                }
                
                // Remover clases de validación
                $('.is-invalid').removeClass('is-invalid');
                
                // Remover alertas
                $('.alert').remove();
                
                // Restablecer botón
                $('#guardarBtn')
                    .prop('disabled', false)
                    .html('<i class="fas fa-save me-2"></i>Guardar Acta');
                    
            }, 100);
        });

        // 5. INICIALIZAR SUMMERNOTE SI ESTÁ DISPONIBLE
        if (typeof $.fn.summernote !== 'undefined') {
            $('#summernote').summernote({
                height: 150,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        }

        // 6. RESTABLECER BOTÓN SI HAY ERRORES DE VALIDACIÓN DEL SERVIDOR
        if ($('.alert-danger').length > 0) {
            $('#guardarBtn')
                .prop('disabled', false)
                .html('<i class="fas fa-save me-2"></i>Guardar Acta');
        }

        console.log('Configuración completa');
    });
    </script>

@endsection