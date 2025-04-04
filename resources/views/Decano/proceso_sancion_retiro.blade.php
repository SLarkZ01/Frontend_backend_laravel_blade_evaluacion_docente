<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Evaluación Docentes - Proceso de Sanción/Retiro</title>
    <link rel="icon" href="images/Logo Uniautonoma.png">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Select2 para mejorar los selectores -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Summernote para editor de texto enriquecido -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="{{asset('resources/css/styles.css')}}">
    <style>
        .header-sancion {
            background-color: #dc3545;
            color: white;
            padding: 15px;
            border-radius: 10px 10px 0 0;
        }

        .form-sancion {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .avatar-preview {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background-color: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
        }

        .firma-box {
            border: 1px dashed #ced4da;
            border-radius: 5px;
            padding: 15px;
            text-align: center;
            margin-top: 10px;
        }

        .select2-container--default .select2-selection--single {
            height: 38px;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            padding: 0.375rem 0.75rem;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }

        .calificacion-baja {
            color: #dc3545;
            font-weight: bold;
        }

        .nota-sancion {
            font-size: 0.9rem;
            color: #6c757d;
            font-style: italic;
        }
        
        .tipo-sancion-badge {
            font-size: 0.9rem;
            padding: 5px 10px;
            border-radius: 15px;
        }
        
        .sancion-leve {
            background-color: #ffc107;
            color: #212529;
        }
        
        .sancion-grave {
            background-color: #fd7e14;
            color: white;
        }
        
        .sancion-retiro {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>

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

                    <!-- Formulario de Sanción o Retiro -->
                    <div class="form-sancion p-0 mb-4">
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
                                            <label class="form-label">Número de Resolución:</label>
                                            <input type="text" class="form-control" id="numeroResolucion" value="" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Fecha de Emisión:</label>
                                            <input type="text" class="form-control" id="fechaEmision" value="" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Nombre:</label>
                                            <input type="text" class="form-control" id="nombreDocente" value="" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Apellido:</label>
                                            <input type="text" class="form-control" id="apellidoDocente" value="" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Identificación:</label>
                                            <input type="text" class="form-control" id="identificacionDocente" value="" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Asignatura:</label>
                                            <input type="text" class="form-control" id="asignaturaDocente" value="" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Calificación Final:</label>
                                            <input type="text" class="form-control calificacion-baja" id="calificacionDocente" value="" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Tipo de Sanción:</label>
                                            <select class="form-select" id="tipoSancionSelect">
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
                                        <div id="antecedentes">Describa aquí los antecedentes y el historial de evaluaciones del docente que justifican esta sanción...</div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5>Fundamentos Normativos:</h5>
                                    <div class="mb-3">
                                        <div id="fundamentos">Especifique aquí los reglamentos, estatutos y normativas institucionales que fundamentan esta decisión...</div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5>Resolución y Medidas Adoptadas:</h5>
                                    <div class="mb-3">
                                        <div id="resolucion">Detalle aquí la resolución específica y las medidas disciplinarias adoptadas...</div>
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
                                        <input type="file" id="firma-input" class="form-control"
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
                                    <button class="btn btn-danger me-2" onclick="window.generarPDFSancion()">
                                        <i class="fas fa-file-pdf me-2"></i>Generar PDF de Resolución
                                    </button>
                                    <button class="btn btn-dark" onclick="enviarResolucion()">
                                        <i class="fas fa-paper-plane me-2"></i>Enviar Resolución al Docente
                                    </button>
                                </div>
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
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Script específico para sanciones -->
    <script src="{{asset('resources/js/LogicaDecanoCoordinador/sancion-script.js')}}"></script>
    <!-- Script para generación de PDF -->
    <script src="{{asset('resources/js/LogicaDecanoCoordinador/sancion-pdf-generator.js')}}"></script>
    <!-- Script para navegación -->
    <script src="{{asset('resources/js/LogicaDecanoCoordinador/navigation.js')}}"></script>
</body>

</html>

    <!-- Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
    <!-- html2pdf JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <!-- Script específico para proceso de sanción -->
    <script src="{{asset('resources/js/LogicaDecanoCoordinador/sancion_script.js')}}"></script>
    <!-- Script para generación profesional de PDF -->
    <script src="{{asset('resources/js/LogicaDecanoCoordinador/pdf_generator.js')}}"></script>
    <!-- Script para generación profesional de PDF de sanción -->
    <script src="{{asset('resources/js/LogicaDecanoCoordinador/sancion_pdf_generator.js')}}"></script>

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
</body>

</html>