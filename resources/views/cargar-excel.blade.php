<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cargar Excel - Sistema de Evaluación Docente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, 
                #1e3c72 0%, 
                #2a5298 50%, 
                #274584 75%, 
                #1e3c72 100%
            );
            background-size: 400% 400%;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
            animation: gradientBG 15s ease infinite;
        }

        @keyframes gradientBG {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        .floating-shapes {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 0;
            pointer-events: none;
        }

        .shape {
            position: absolute;
            color: rgba(255, 255, 255, 0.08);
            animation: float 6s ease-in-out infinite;
            font-size: 4rem;
            transition: all 0.3s ease;
        }

        .shape i {
            filter: drop-shadow(0 0 10px rgba(255, 255, 255, 0.05));
        }

        .shape:nth-child(1) {
            left: 5%;
            top: 15%;
            font-size: 6rem;
            animation-delay: 0s;
        }

        .shape:nth-child(2) {
            right: 10%;
            top: 25%;
            font-size: 4.5rem;
            animation-delay: 1s;
        }

        .shape:nth-child(3) {
            left: 15%;
            bottom: 20%;
            font-size: 5rem;
            animation-delay: 2s;
        }

        .shape:nth-child(4) {
            right: 20%;
            bottom: 25%;
            font-size: 4rem;
            animation-delay: 1.5s;
        }

        .shape:nth-child(5) {
            left: 40%;
            top: 60%;
            font-size: 5.5rem;
            animation-delay: 0.5s;
        }

        @keyframes float {
            0%, 100% { 
                transform: translateY(0);
            }
            50% { 
                transform: translateY(-15px);
            }
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: none;
            border-radius: 15px;
        }

        .card-header {
            background: #1e3c72 !important;
            border-radius: 15px 15px 0 0 !important;
            padding: 1.5rem;
        }

        .btn-primary {
            background: linear-gradient(45deg, #1e3c72, #2a5298);
            border: none;
            padding: 0.8rem 1.5rem;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(30, 60, 114, 0.4);
        }

        .form-control, .form-select {
            border-radius: 8px;
            padding: 0.8rem;
            border: 1px solid rgba(30, 60, 114, 0.2);
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: #1e3c72;
            box-shadow: 0 0 0 0.2rem rgba(30, 60, 114, 0.25);
        }

        .container {
            position: relative;
            z-index: 1;
        }
    </style>
</head>
<body>
    <div class="floating-shapes">
        <div class="shape">
            <i class="fas fa-file-excel"></i>
        </div>
        <div class="shape">
            <i class="fas fa-table"></i>
        </div>
        <div class="shape">
            <i class="fas fa-chart-bar"></i>
        </div>
        <div class="shape">
            <i class="fas fa-chart-line"></i>
        </div>
        <div class="shape">
            <i class="fas fa-chart-pie"></i>
        </div>
    </div>
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
