<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Evaluación Docente - UNIAUTÓNOMA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="{{ asset('images/LogoUniautonoma.png') }}">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><polygon fill="%23ffffff08" points="0,1000 1000,0 1000,1000"/></svg>');
            background-size: cover;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
        }
        
        .logo-container {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .logo-container img {
            max-width: 120px;
            height: auto;
            filter: drop-shadow(0 4px 8px rgba(0,0,0,0.2));
        }
        
        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            color: #ffffff;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            margin-bottom: 1rem;
        }
        
        .hero-subtitle {
            font-size: 1.4rem;
            color: #f8f9fa;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        
        .hero-description {
            font-size: 1.1rem;
            color: #e9ecef;
            line-height: 1.7;
            margin-bottom: 3rem;
        }
        
        .btn-login {
            background: linear-gradient(45deg, #1e3c72, #2a5298);
            border: none;
            padding: 15px 40px;
            font-size: 1.2rem;
            font-weight: 600;
            border-radius: 50px;
            color: white;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(30, 60, 114, 0.3);
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(30, 60, 114, 0.4);
            color: white;
        }

        .btn-upload {
            background: linear-gradient(45deg, #2C5364, #203A43);
            border: none;
            padding: 15px 40px;
            font-size: 1.2rem;
            font-weight: 600;
            border-radius: 50px;
            color: white;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(44, 83, 100, 0.3);
        }
        
        .btn-upload:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(44, 83, 100, 0.4);
            color: white;
        }

        .alert {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            border-radius: 15px;
            padding: 1rem;
            margin: 0 auto;
            max-width: 800px;
        }
        
        .features-section {
            padding: 5rem 0;
            background: #f8f9fa;
        }
        
        .feature-card {
            background: white;
            padding: 2.5rem;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            text-align: center;
            height: 100%;
            transition: transform 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
        }
        
        .feature-icon {
            font-size: 3rem;
            color: #667eea;
            margin-bottom: 1.5rem;
        }
        
        .feature-title {
            font-size: 1.4rem;
            font-weight: 600;
            color: #343a40;
            margin-bottom: 1rem;
        }
        
        .feature-description {
            color: #6c757d;
            line-height: 1.6;
        }
        
        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }
        
        .shape {
            position: absolute;
            opacity: 0.1;
            animation: float 6s ease-in-out infinite;
        }
        
        .shape:nth-child(1) {
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }
        
        .shape:nth-child(2) {
            top: 60%;
            right: 10%;
            animation-delay: 2s;
        }
        
        .shape:nth-child(3) {
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.2rem;
            }
            
            .hero-description {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="floating-shapes">
            <div class="shape">
                <i class="fas fa-graduation-cap fa-3x"></i>
            </div>
            <div class="shape">
                <i class="fas fa-book fa-3x"></i>
            </div>
            <div class="shape">
                <i class="fas fa-chart-line fa-3x"></i>
            </div>
        </div>
        
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-8">
                    <div class="hero-content text-center">
                        <div class="logo-container">
                            <img src="{{ asset('images/mascota.png') }}" alt="Logo UNIAUTÓNOMA" class="img-fluid">
                        </div>
                        
                        <h1 class="hero-title">Sistema de Evaluación Docente</h1>
                        <h2 class="hero-subtitle">Universidad Autónoma del Cauca</h2>
                        
                        <p class="hero-description">
                            Bienvenido al sistema integral de evaluación docente de UNIAUTÓNOMA. 
                            Una plataforma moderna y eficiente que permite gestionar de manera 
                            transparente y objetiva el proceso de evaluación del desempeño académico, 
                            promoviendo la excelencia educativa y el mejoramiento continuo de nuestros 
                            docentes.
                        </p>

                        <div class="alert alert-info mb-4" role="alert">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Importante:</strong> Antes de iniciar sesión, es necesario cargar el archivo Excel con los datos correspondientes.
                        </div>
                        
                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('cargar.excel') }}" class="btn btn-upload">
                                <i class="fas fa-file-excel"></i>
                                Cargar Excel
                            </a>
                            <a href="{{ route('login.process') }}" class="btn btn-login">
                                <i class="fas fa-sign-in-alt"></i>
                                Iniciar Sesión
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-lg-8 text-center">
                    <h2 class="display-5 fw-bold mb-3">Características del Sistema</h2>
                    <p class="lead text-muted">
                        Descubre las funcionalidades que hacen de nuestro sistema una herramienta 
                        completa para la gestión de evaluaciones docentes.
                    </p>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <h3 class="feature-title">Reportes y Analytics</h3>
                        <p class="feature-description">
                            Genera reportes detallados y visualiza métricas de desempeño 
                            con gráficos interactivos y análisis estadísticos avanzados.
                        </p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-users-cog"></i>
                        </div>
                        <h3 class="feature-title">Gestión de Roles</h3>
                        <p class="feature-description">
                            Sistema de roles diferenciados para administradores, decanos, 
                            coordinadores y docentes con permisos específicos.
                        </p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-file-contract"></i>
                        </div>
                        <h3 class="feature-title">Actas de Compromiso</h3>
                        <p class="feature-description">
                            Gestiona actas de compromiso, planes de mejora y seguimiento 
                            del desempeño docente de manera automatizada.
                        </p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-bell"></i>
                        </div>
                        <h3 class="feature-title">Alertas Inteligentes</h3>
                        <p class="feature-description">
                            Sistema de alertas automáticas para casos de bajo desempeño 
                            y notificaciones importantes del proceso evaluativo.
                        </p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3 class="feature-title">Seguridad y Privacidad</h3>
                        <p class="feature-description">
                            Protección de datos con estándares de seguridad avanzados 
                            y acceso controlado según perfiles de usuario.
                        </p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h3 class="feature-title">Acceso Multi-dispositivo</h3>
                        <p class="feature-description">
                            Interfaz responsive que se adapta perfectamente a computadores, 
                            tablets y dispositivos móviles.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <footer class="bg-dark text-light py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0">
                        <i class="fas fa-university me-2"></i>
                        © {{ date('Y') }} Universidad Autónoma del Cauca - UNIAUTÓNOMA
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">
                        <i class="fas fa-code me-2"></i>
                        Sistema de Evaluación Docente v1.0
                    </p>
                </div>
            </div>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

