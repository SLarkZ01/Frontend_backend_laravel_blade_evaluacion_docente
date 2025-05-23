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
<form id="formSancion" action="{{ route('decano.guardar_sancion') }}" method="POST" enctype="multipart/form-data" class="mb-5">
    @csrf
    <div class="card">
        <div class="card-header bg-danger text-white">
            <h5 class="mb-0">Formulario de Sanción o Retiro</h5>
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
                            <label class="form-label">Seleccione un docente:</label>
                            <select class="form-select select2-docentes" id="docenteSelect" name="id_docente">
                                <option value="">Seleccione un docente</option>
                                @if (isset($docentesbusqueda) && count($docentesbusqueda) > 0)
                                    @foreach ($docentesbusqueda as $docente)
                                    <option value="{{ $docente->id_docente }}"
                                            data-nombre="{{ $docente->nombre_docente }}" 
                                            data-apellido="{{ $docente->apellido_docente }}" 
                                            data-identificacion="{{ $docente->identificacion_docente }}" 
                                            data-asignatura="{{ $docente->curso }}" 
                                            data-calificacion="{{ $docente->promedio_total }}">
                                            {{ $docente->nombre_docente }} {{ $docente->apellido_docente }} - {{ $docente->curso }}
                                    </option>
                                    @endforeach
                                @else
                                    <option value="">No hay docentes disponibles.</option>
                                @endif
                            </select>
                        </div>
                    </div>
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
                            <input type="text" class="form-control" id="nombreDocente" name="nombre_docente" readonly required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Apellido:</label>
                            <input type="text" class="form-control" id="apellidoDocente" name="apellido_docente" readonly required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Identificación:</label>
                            <input type="text" class="form-control" id="identificacionDocente" name="identificacion_docente" readonly required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Asignatura:</label>
                            <input type="text" class="form-control" id="asignaturaDocente" name="asignatura" readonly required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Calificación Final:</label>
                            <input type="text" class="form-control" id="calificacionDocente" name="calificacion_final" readonly required>
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
                        <textarea class="form-control" id="antecedentes" name="antecedentes">Describa aquí los antecedentes y el historial de evaluaciones del docente que justifican esta sanción...</textarea>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12">
                    <h5>Fundamentos Normativos:</h5>
                    <div class="mb-3">
                        <textarea class="form-control" id="fundamentos" name="fundamentos">Especifique aquí los reglamentos, estatutos y normativas institucionales que fundamentan esta decisión...</textarea>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-12">
                    <h5>Resolución y Medidas Adoptadas:</h5>
                    <div class="mb-3">
                        <textarea class="form-control" id="resolucion" name="resolucion">Detalle aquí la resolución específica y las medidas disciplinarias adoptadas...</textarea>
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
                    <button type="submit" class="btn btn-danger me-2">
                        <i class="fas fa-save me-2"></i>Guardar Resolución
                    </button>
                    <button type="button" class="btn btn-primary me-2" id="descargarPDF">
                        <i class="fas fa-file-pdf me-2"></i>Descargar PDF
                    </button>
                    <button type="button" class="btn btn-dark" id="enviarResolucion">
                        <i class="fas fa-paper-plane me-2"></i>Enviar Resolución al Docente
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- JavaScript para el formulario de sanción -->
<script>
    $(document).ready(function () {
        // Inicializar Select2 para el selector de docentes
        $('.select2-docentes').select2({
            placeholder: "Seleccione un docente",
            allowClear: true,
            width: '100%'
        });

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

        // Manejar la selección de docente
        $('#docenteSelect').on('change', function() {
            const selectedOption = $(this).find('option:selected');
            
            // Obtener los datos del docente seleccionado
            const nombre = selectedOption.data('nombre') || '';
            const apellido = selectedOption.data('apellido') || '';
            const identificacion = selectedOption.data('identificacion') || '';
            const asignatura = selectedOption.data('asignatura') || '';
            const calificacion = selectedOption.data('calificacion') || '';
            
            // Asignar los valores a los campos correspondientes
            $('#nombreDocente').val(nombre);
            $('#apellidoDocente').val(apellido);
            $('#identificacionDocente').val(identificacion);
            $('#asignaturaDocente').val(asignatura);
            $('#calificacionDocente').val(calificacion);
            
            // Cambiar el color del campo de calificación según el valor
            const calificacionInput = $('#calificacionDocente');
            calificacionInput.removeClass('calificacion-baja calificacion-media calificacion-alta');
            
            const calificacionValue = parseFloat(calificacion);
            if (calificacionValue < 3) {
                calificacionInput.addClass('calificacion-baja');
            } else if (calificacionValue < 4) {
                calificacionInput.addClass('calificacion-media');
            } else {
                calificacionInput.addClass('calificacion-alta');
            }
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

        // Función para descargar el PDF
        $('#descargarPDF').click(function() {
            generarPDF();
        });

        // Función para enviar la resolución
        $('#enviarResolucion').click(function() {
            enviarResolucion();
        });
    });

    // Función para generar PDF
    function generarPDF() {
        // Verificar si se ha seleccionado un docente
        if (!$('#nombreDocente').val()) {
            alert('Por favor, seleccione un docente antes de generar el PDF.');
            return;
        }

        // Verificar si se ha seleccionado un tipo de sanción
        if (!$('#tipoSancionSelect').val()) {
            alert('Por favor, seleccione un tipo de sanción antes de generar el PDF.');
            return;
        }

        // Crear una copia del formulario para el PDF (sin botones)
        const elementoParaPDF = document.createElement('div');
        elementoParaPDF.innerHTML = document.querySelector('.card').outerHTML;
        
        // Eliminar los botones y elementos innecesarios
        const botonesRow = elementoParaPDF.querySelector('.row.mt-4');
        if (botonesRow) botonesRow.remove();
        
        // Agregar encabezado para el PDF
        const encabezado = document.createElement('div');
        encabezado.innerHTML = `
            <div style="text-align: center; margin-bottom: 20px;">
                <h2>RESOLUCIÓN DE SANCIÓN</h2>
                <p>Número: ${$('#numeroResolucion').val()}</p>
                <p>Fecha: ${$('#fechaEmision').val()}</p>
            </div>
        `;
        elementoParaPDF.prepend(encabezado);
        
        // Configurar opciones de html2pdf
        const opt = {
            margin: 10,
            filename: `Resolucion_Sancion_${$('#numeroResolucion').val()}.pdf`,
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
        };
        
        // Generar el PDF
        html2pdf().set(opt).from(elementoParaPDF).save();
    }

    // Función para enviar la resolución
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
            // Aquí implementaríamos el envío real al servidor
            // Por ahora simularemos una respuesta exitosa
            
            // Primero guardar el formulario (simulado)
            const formData = new FormData(document.getElementById('formSancion'));
            
            // Simular envío al servidor
            setTimeout(function() {
                alert('Resolución enviada correctamente al docente ' + $('#nombreDocente').val() + ' ' + $('#apellidoDocente').val());
            }, 1000);
        }
    }
</script>

<!-- Estilos para las calificaciones -->
<style>
.calificacion-baja {
    background-color: #ffcccc !important;
}
.calificacion-media {
    background-color: #ffffcc !important;
}
.calificacion-alta {
    background-color: #ccffcc !important;
}
</style>