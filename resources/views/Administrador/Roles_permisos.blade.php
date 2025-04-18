@extends('layouts.principal')
@section('titulo', 'Panel de Administrador')
@section('menu-sidebar')

    <li class="nav-item active">
        <a href="{{ route('Admin.Dashboard') }}">
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
        <a href="{{ route('admin.roles_permisos') }}">
            <i class="fas fa-file-signature"></i>
            <p>Gestion de Roles y Permisos</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('admin.periodo_evaluacion') }}">
            <i class="fas fa-exclamation-triangle"></i>
            <p>Configuracion de Periodo</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('admin.reportes_admin') }}">
            <i class="fas fa-chart-line"></i>
            <p>Reportes y Estadisticas</p>
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
            


                    <!-- Encabezado -->
                    <div class="header-card animated-card">
                        <h1>Gestión de Roles y Permisos</h1>
                        <p class="text-muted">Administra los usuarios del sistema y sus niveles de acceso</p>
                    </div>

                    <!-- Pestañas de navegación -->
                    <ul class="nav nav-tabs mb-0" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="usuarios-tab" data-bs-toggle="tab"
                                data-bs-target="#usuarios" type="button" role="tab" aria-controls="usuarios"
                                aria-selected="true">
                                <i class="fas fa-users me-2"></i>Usuarios
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="roles-tab" data-bs-toggle="tab" data-bs-target="#roles"
                                type="button" role="tab" aria-controls="roles" aria-selected="false">
                                <i class="fas fa-user-tag me-2"></i>Roles
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="permisos-tab" data-bs-toggle="tab" data-bs-target="#permisos"
                                type="button" role="tab" aria-controls="permisos" aria-selected="false">
                                <i class="fas fa-key me-2"></i>Permisos
                            </button>
                        </li>
                    </ul>

                    <!-- Contenido de las pestañas -->
                    <div class="tab-content" id="myTabContent">
                        <!-- Pestaña de Usuarios -->
                        <div class="tab-pane fade show active" id="usuarios" role="tabpanel"
                            aria-labelledby="usuarios-tab">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="mb-0">Lista de Usuarios</h5>
                                <button class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#nuevoUsuarioModal">
                                    <i class="fas fa-plus me-2"></i>Nuevo Usuario
                                </button>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover datatable table-admin">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Usuario</th>
                                            <th>Email</th>
                                            <th>Rol</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Juan Pérez</td>
                                            <td>admin</td>
                                            <td>admin@uniautonoma.edu.co</td>
                                            <td><span class="badge role-badge role-admin">Administrador</span></td>
                                            <td><span class="badge bg-success">Activo</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary btn-action"
                                                    data-bs-toggle="tooltip" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger btn-action"
                                                    data-bs-toggle="tooltip" title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Ana Martínez</td>
                                            <td>decano</td>
                                            <td>decano@uniautonoma.edu.co</td>
                                            <td><span class="badge role-badge role-decano">Decano</span></td>
                                            <td><span class="badge bg-success">Activo</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary btn-action"
                                                    data-bs-toggle="tooltip" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger btn-action"
                                                    data-bs-toggle="tooltip" title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Carlos Rodríguez</td>
                                            <td>docente</td>
                                            <td>docente@uniautonoma.edu.co</td>
                                            <td><span class="badge role-badge role-docente">Docente</span></td>
                                            <td><span class="badge bg-success">Activo</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary btn-action"
                                                    data-bs-toggle="tooltip" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger btn-action"
                                                    data-bs-toggle="tooltip" title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>María López</td>
                                            <td>docente2</td>
                                            <td>docente2@uniautonoma.edu.co</td>
                                            <td><span class="badge role-badge role-docente">Docente</span></td>
                                            <td><span class="badge bg-secondary">Inactivo</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary btn-action"
                                                    data-bs-toggle="tooltip" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger btn-action"
                                                    data-bs-toggle="tooltip" title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Pestaña de Roles -->
                        <div class="tab-pane fade" id="roles" role="tabpanel" aria-labelledby="roles-tab">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="mb-0">Roles del Sistema</h5>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevoRolModal">
                                    <i class="fas fa-plus me-2"></i>Nuevo Rol
                                </button>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover datatable table-admin">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Descripción</th>
                                            <th>Usuarios</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td><span class="badge role-badge role-admin">Administrador</span></td>
                                            <td>Control total del sistema</td>
                                            <td>5</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary btn-action"
                                                    data-bs-toggle="tooltip" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-info btn-action"
                                                    data-bs-toggle="tooltip" title="Ver permisos">
                                                    <i class="fas fa-key"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td><span class="badge role-badge role-decano">Decano</span></td>
                                            <td>Gestión de departamentos y docentes</td>
                                            <td>8</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary btn-action"
                                                    data-bs-toggle="tooltip" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-info btn-action"
                                                    data-bs-toggle="tooltip" title="Ver permisos">
                                                    <i class="fas fa-key"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td><span class="badge role-badge role-docente">Docente</span></td>
                                            <td>Acceso a evaluaciones y resultados</td>
                                            <td>45</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary btn-action"
                                                    data-bs-toggle="tooltip" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-info btn-action"
                                                    data-bs-toggle="tooltip" title="Ver permisos">
                                                    <i class="fas fa-key"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Pestaña de Permisos -->
                        <div class="tab-pane fade" id="permisos" role="tabpanel" aria-labelledby="permisos-tab">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="mb-0">Permisos del Sistema</h5>
                                <button class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#nuevoPermisoModal">
                                    <i class="fas fa-plus me-2"></i>Nuevo Permiso
                                </button>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover datatable table-admin">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Descripción</th>
                                            <th>Módulo</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>ver_dashboard</td>
                                            <td>Ver panel de control</td>
                                            <td>Dashboard</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary btn-action"
                                                    data-bs-toggle="tooltip" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger btn-action"
                                                    data-bs-toggle="tooltip" title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>gestionar_usuarios</td>
                                            <td>Crear, editar y eliminar usuarios</td>
                                            <td>Usuarios</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary btn-action"
                                                    data-bs-toggle="tooltip" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger btn-action"
                                                    data-bs-toggle="tooltip" title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>gestionar_roles</td>
                                            <td>Crear, editar y eliminar roles</td>
                                            <td>Roles</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary btn-action"
                                                    data-bs-toggle="tooltip" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger btn-action"
                                                    data-bs-toggle="tooltip" title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>gestionar_periodos</td>
                                            <td>Configurar periodos de evaluación</td>
                                            <td>Periodos</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary btn-action"
                                                    data-bs-toggle="tooltip" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger btn-action"
                                                    data-bs-toggle="tooltip" title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    <!-- Modal para Nuevo Usuario -->
    <div class="modal fade" id="nuevoUsuarioModal" tabindex="-1" aria-labelledby="nuevoUsuarioModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nuevoUsuarioModalLabel">Crear Nuevo Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="nuevoUsuarioForm">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nombre" class="form-label">Nombre Completo</label>
                                <input type="text" class="form-control" id="nombre" required>
                            </div>
                            <div class="col-md-6">
                                <label for="usuario" class="form-label">Nombre de Usuario</label>
                                <input type="text" class="form-control" id="usuario" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="email" required>
                            </div>
                            <div class="col-md-6">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="rol" class="form-label">Rol</label>
                                <select class="form-select" id="rol" required>
                                    <option value="">Seleccionar rol</option>
                                    <option value="admin">Administrador</option>
                                    <option value="decano">Decano/Coordinador</option>
                                    <option value="docente">Docente</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="estado" class="form-label">Estado</label>
                                <select class="form-select" id="estado" required>
                                    <option value="activo">Activo</option>
                                    <option value="inactivo">Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Nuevo Rol -->
    <div class="modal fade" id="nuevoRolModal" tabindex="-1" aria-labelledby="nuevoRolModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nuevoRolModalLabel">Crear Nuevo Rol</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="nuevoRolForm">
                        <div class="mb-3">
                            <label for="nombreRol" class="form-label">Nombre del Rol</label>
                            <input type="text" class="form-control" id="nombreRol" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcionRol" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcionRol" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Permisos</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="permiso1">
                                <label class="form-check-label" for="permiso1">Ver dashboard</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="permiso2">
                                <label class="form-check-label" for="permiso2">Gestionar usuarios</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="permiso3">
                                <label class="form-check-label" for="permiso3">Gestionar roles</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="permiso4">
                                <label class="form-check-label" for="permiso4">Gestionar periodos</label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Nuevo Permiso -->
    <div class="modal fade" id="nuevoPermisoModal" tabindex="-1" aria-labelledby="nuevoPermisoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nuevoPermisoModalLabel">Crear Nuevo Permiso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="nuevoPermisoForm">
                        <div class="mb-3">
                            <label for="nombrePermiso" class="form-label">Nombre del Permiso</label>
                            <input type="text" class="form-control" id="nombrePermiso" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcionPermiso" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcionPermiso" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="moduloPermiso" class="form-label">Módulo</label>
                            <select class="form-select" id="moduloPermiso" required>
                                <option value="">Seleccionar módulo</option>
                                <option value="Dashboard">Dashboard</option>
                                <option value="Usuarios">Usuarios</option>
                                <option value="Roles">Roles</option>
                                <option value="Periodos">Periodos</option>
                                <option value="Reportes">Reportes</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <!-- Script personalizado -->
    <script src="js/LogicaAdministrador/Admin-script.js"></script>

    <script>
        // Script específico para la página de roles y permisos
        document.addEventListener('DOMContentLoaded', function () {
            // La inicialización de DataTables ahora se maneja en admin-script.js
            // para evitar reinicializaciones

            // Manejar eventos de botones de acción
            const editButtons = document.querySelectorAll('.btn-outline-primary.btn-action');
            editButtons.forEach(button => {
                button.addEventListener('click', function () {
                    // En una implementación real, esto abriría el modal con los datos del elemento
                    alert('Función de edición en desarrollo');
                });
            });

            const deleteButtons = document.querySelectorAll('.btn-outline-danger.btn-action');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function () {
                    if (confirm('¿Está seguro que desea eliminar este elemento?')) {
                        // En una implementación real, esto eliminaría el elemento
                        alert('Elemento eliminado correctamente');
                    }
                });
            });

            // Manejar envío de formularios
            const saveButtons = document.querySelectorAll('.modal-footer .btn-primary');
            saveButtons.forEach(button => {
                button.addEventListener('click', function () {
                    // En una implementación real, esto guardaría los datos del formulario
                    alert('Datos guardados correctamente');
                    // Cerrar el modal
                    const modal = bootstrap.Modal.getInstance(this.closest('.modal'));
                    modal.hide();
                });
            });
        });
    </script>
@endsection