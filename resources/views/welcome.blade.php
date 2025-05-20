<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Evaluación Docente</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Estilos personalizados -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        .hero-section {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            color: white;
            padding: 4rem 0;
            margin-bottom: 2rem;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
            padding: 10px 20px;
            font-weight: 600;
        }
        .btn-outline-primary {
            border-color: #0d6efd;
            color: #0d6efd;
            padding: 10px 20px;
            font-weight: 600;
        }
        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #0d6efd;
        }
        .footer {
            background-color: #343a40;
            color: white;
            padding: 2rem 0;
            margin-top: 3rem;
        }
    </style>
</head>
<body>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">EvalDocente</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Iniciar Sesión</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Registrarse</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sección Hero -->
    <section class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 fw-bold mb-4">Sistema de Evaluación Docente</h1>
            <p class="lead mb-5">Una plataforma integral para mejorar la calidad educativa a través de evaluaciones efectivas y seguimiento del desempeño docente.</p>
            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                <a href="{{ route('login') }}" class="btn btn-light btn-lg px-4 gap-3">Iniciar Sesión</a>
                <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-4">Registrarse</a>
            </div>
        </div>
    </section>

    <!-- Sección de características -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Características Principales</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 p-4 text-center">
                        <div class="feature-icon">📊</div>
                        <h3>Evaluación Integral</h3>
                        <p class="text-muted">Evaluaciones completas que consideran múltiples aspectos del desempeño docente para un análisis más preciso.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 p-4 text-center">
                        <div class="feature-icon">📈</div>
                        <h3>Seguimiento Continuo</h3>
                        <p class="text-muted">Monitoreo constante del progreso y mejoras en el desempeño docente a lo largo del tiempo.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 p-4 text-center">
                        <div class="feature-icon">📝</div>
                        <h3>Planes de Mejora</h3>
                        <p class="text-muted">Generación automática de planes de mejora basados en los resultados de las evaluaciones.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección de acceso -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2>Accede a tu cuenta</h2>
                    <p class="lead">Si ya tienes una cuenta, inicia sesión para acceder a todas las funcionalidades del sistema según tu rol.</p>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-4 me-md-2">Iniciar Sesión</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h2>¿Eres nuevo?</h2>
                    <p class="lead">Regístrate para formar parte del sistema de evaluación docente y contribuir a la mejora continua de la calidad educativa.</p>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                        <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg px-4">Registrarse</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección de beneficios -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Beneficios del Sistema</h2>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <span class="text-primary">✓</span>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5>Mejora Continua</h5>
                            <p>Identificación de áreas de oportunidad para el desarrollo profesional docente.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <span class="text-primary">✓</span>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5>Transparencia</h5>
                            <p>Procesos claros y objetivos para la evaluación del desempeño docente.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <span class="text-primary">✓</span>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5>Toma de Decisiones</h5>
                            <p>Información valiosa para la toma de decisiones administrativas y académicas.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <span class="text-primary">✓</span>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5>Calidad Educativa</h5>
                            <p>Contribución directa a la mejora de la calidad de la enseñanza y el aprendizaje.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>Sistema de Evaluación Docente</h5>
                    <p>Una herramienta para la mejora continua de la calidad educativa.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p>&copy; {{ date('Y') }} Todos los derechos reservados.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>