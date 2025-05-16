<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cargar Excel - Sistema de Evaluación Docente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-file-excel me-2"></i>Importar datos desde Excel</h4>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="/importar" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf
                            <div class="mb-4">
                                <label for="tipo_datos" class="form-label">Tipo de datos a importar</label>
                                <select class="form-select" id="tipo_datos" name="tipo_datos" required>
                                    <option value="" selected disabled>Seleccione el tipo de datos</option>
                                    <option value="evaluaciones">Evaluaciones de docentes</option>
                                    <option value="programas">Programas académicos</option>
                                    <option value="estudiantes">Datos de estudiantes</option>
                                </select>
                                <div class="invalid-feedback">
                                    Por favor seleccione el tipo de datos a importar.
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="archivo" class="form-label">Archivo Excel</label>
                                <input type="file" class="form-control" id="archivo" name="archivo" accept=".xlsx,.xls,.csv" required>
                                <div class="form-text text-muted">
                                    Formatos permitidos: .xlsx, .xls, .csv
                                </div>
                                <div class="invalid-feedback">
                                    Por favor seleccione un archivo Excel válido.
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="/" class="btn btn-outline-secondary me-md-2">
                                    <i class="fas fa-arrow-left me-1"></i> Volver
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-upload me-1"></i> Importar datos
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Validación de formulario con Bootstrap
        (function() {
            'use strict';
            var forms = document.querySelectorAll('.needs-validation');
            Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>
</body>
</html>
