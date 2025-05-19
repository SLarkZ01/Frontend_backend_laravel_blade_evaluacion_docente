@extends('layouts.principal')
@section('titulo', 'Panel de Administrador')
@section('menu-sidebar')

    <li class="nav-item active">
        <a href="{{ route('docente.p_docente') }}">
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
        <a href="{{ route('docente.result') }}">
            <i class="fas fa-file-signature"></i>
            <p>Resultados</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('docente.confi') }}">
            <i class="fas fa-exclamation-triangle"></i>
            <p>Configuracion</p>
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
    Mariano Closs
<span class="user-level">Docente</span>
<span class="caret"></span>
</span>
@endsection
@section('contenido')
    <div class="container-fluid p-0">
        <div class="row g-0">

                    <!-- Encabezado -->
                    <div class="header-card animated-card">
                        <h1>Configuración y Ayuda</h1>
                        <p>Gestiona tu cuenta y obtén asistencia cuando la necesites</p>
                    </div>

                    <div class="row">
                        <!-- Configuración de Cuenta -->
                        <div class="col-md-6 mb-4">
                            <div class="config-section animated-card">
                                <div class="config-icon">
                                    <i class="fas fa-user-cog fa-lg"></i>
                                </div>
                                <h4>Configuración de Cuenta</h4>
                                <form>
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="emailInput"
                                            placeholder="nombre@ejemplo.com" value="docente@uniautonoma.edu.co">
                                        <label for="emailInput">Correo Electrónico</label>
                                    </div>
                                    <div class="form-floating">
                                        <input type="password" class="form-control" id="currentPassword"
                                            placeholder="Contraseña actual">
                                        <label for="currentPassword">Contraseña Actual</label>
                                    </div>
                                    <div class="form-floating">
                                        <input type="password" class="form-control" id="newPassword"
                                            placeholder="Nueva contraseña">
                                        <label for="newPassword">Nueva Contraseña</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control" id="confirmPassword"
                                            placeholder="Confirmar contraseña">
                                        <label for="confirmPassword">Confirmar Nueva Contraseña</label>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                </form>
                            </div>
                        </div>

                        <!-- Centro de Ayuda -->
                        <div class="col-md-6 mb-4">
                            <div class="config-section animated-card">
                                <div class="config-icon">
                                    <i class="fas fa-question-circle fa-lg"></i>
                                </div>
                                <h4>Centro de Ayuda</h4>
                                <div class="help-card">
                                    <h6><i class="fas fa-book me-2"></i>Guías y Tutoriales</h6>
                                    <p class="text-muted small mb-0">Aprende a usar todas las funciones del panel</p>
                                </div>
                                <div class="help-card">
                                    <h6><i class="fas fa-question-circle me-2"></i>Preguntas Frecuentes</h6>
                                    <p class="text-muted small mb-0">Encuentra respuestas a dudas comunes</p>
                                </div>
                                <div class="help-card">
                                    <h6><i class="fas fa-video me-2"></i>Videos Tutoriales</h6>
                                    <p class="text-muted small mb-0">Aprende visualmente con nuestros videos</p>
                                </div>
                            </div>
                        </div>

                        <!-- Reportar Problemas -->
                        <div class="col-md-6 mb-4">
                            <div class="config-section animated-card">
                                <div class="config-icon">
                                    <i class="fas fa-bug fa-lg"></i>
                                </div>
                                <h4>Reportar Problemas</h4>
                                <form>
                                    <div class="mb-3">
                                        <label for="issueType" class="form-label">Tipo de Problema</label>
                                        <select class="form-select" id="issueType">
                                            <option>Error técnico</option>
                                            <option>Problema de acceso</option>
                                            <option>Error en datos</option>
                                            <option>Otro</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="issueDescription" class="form-label">Descripción del
                                            Problema</label>
                                        <textarea class="form-control" id="issueDescription" rows="4"
                                            placeholder="Describe el problema que estás experimentando..."></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Enviar Reporte</button>
                                </form>
                            </div>
                        </div>

                        <!-- Sugerencias de Mejora -->
                        <div class="col-md-6 mb-4">
                            <div class="config-section animated-card">
                                <div class="config-icon">
                                    <i class="fas fa-lightbulb fa-lg"></i>
                                </div>
                                <h4>Sugerencias de Mejora</h4>
                                <form id="suggestionForm">
                                    <div class="mb-3">
                                        <label for="improvementArea" class="form-label">Área de Mejora</label>
                                        <select class="form-select" id="improvementArea">
                                            <option>Interfaz de usuario</option>
                                            <option>Funcionalidades</option>
                                            <option>Reportes y estadísticas</option>
                                            <option>Otro</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="suggestionDescription" class="form-label">Descripción de la
                                            Sugerencia</label>
                                        <textarea class="form-control" id="suggestionDescription" rows="4"
                                            placeholder="Comparte tus ideas para mejorar el panel..."></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Enviar Sugerencia</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/LogicaDocente/configuracion.js')}}"></script>

@endsection