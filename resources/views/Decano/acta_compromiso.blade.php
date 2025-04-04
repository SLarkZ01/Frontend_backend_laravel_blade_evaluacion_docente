<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Evaluación Docentes - Acta de Compromiso</title>
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
        .header-acta {
            background-color: #0d6efd;
            color: white;
            padding: 15px;
            border-radius: 10px 10px 0 0;
        }

        .form-acta {
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

        .nota-acta {
            font-size: 0.9rem;
            color: #6c757d;
            font-style: italic;
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
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
    <!-- html2pdf JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <!-- Script específico para acta de compromiso -->
    <script src="{{asset('resources/js/LogicaDecanoCoordinador/acta_script.js')}}"></script>
    <!-- Script para generación profesional de PDF -->
    <script src="{{asset('resources/js/LogicaDecanoCoordinador/pdf_generator.js')}}"></script>
    <!-- Script para navegación -->
    <script src="{{asset('resources/js/LogicaDecanoCoordinador/navigation.js}')}}"></script>

    <script>
        $(document).ready(function () {
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
                    onImageUpload: function (files) {
                        for (let i = 0; i < files.length; i++) {
                            let reader = new FileReader();
                            reader.onloadend = function () {
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
</body>

</html>