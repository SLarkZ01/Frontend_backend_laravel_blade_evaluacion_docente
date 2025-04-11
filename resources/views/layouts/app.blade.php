<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{-- Sistema de Evaluación Docentes - Panel Administrador --}}
        @yield('titulo')
    </title>
    <link rel="icon" href="{{asset('images/LogoUniautonoma.png')}}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js para gráficos -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="{{asset('css/styles.css')}}">
    <style>
        /* Estilos específicos para el panel administrador */
        .dashboard-card {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: all 0.3s;
            height: 100%;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        .card-icon {
            font-size: 2.5rem;
            color: #0d6efd;
            opacity: 0.8;
        }

        .admin-icon {
            font-size: 1.8rem;
            color: #0d6efd;
            background-color: rgba(13, 110, 253, 0.1);
            padding: 15px;
            border-radius: 12px;
        }

        .header-card {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            border-left: 5px solid #0d6efd;
        }

        .header-card h1 {
            margin-bottom: 5px;
            color: #0d6efd;
        }

        .table-admin {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
        }

        .table-admin thead {
            background-color: #0d6efd;
            color: white;
        }

        /* Mejorando el espaciado en las celdas de la tabla */
        .table-admin tbody td {
            padding: 16px 15px;
            vertical-align: middle;
            line-height: 1.5;
        }
        
        /* Mejorando el espaciado entre el avatar y el texto */
        .table-admin .d-flex.align-items-center .me-2 {
            margin-right: 12px !important;
        }
        
        /* Añadiendo más espacio entre el nombre y el rol */
        .table-admin .d-flex.align-items-center div p.mb-0 {
            margin-bottom: 4px !important;
        }

        .btn-action {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            border-radius: 0.2rem;
            margin-right: 5px;
        }

        .config-section {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .config-section:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .config-icon {
            font-size: 2rem;
            color: #0d6efd;
            margin-bottom: 15px;
        }

        /* Animaciones para elementos */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animated-card {
            animation: fadeIn 0.5s ease-out forwards;
        }

        .animated-visible {
            opacity: 1;
            transform: translateY(0);
        }

        .tab-content {
            padding: 20px;
            background-color: white;
            border-radius: 0 0 10px 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .nav-tabs .nav-link {
            border: none;
            color: #6c757d;
            font-weight: 500;
            padding: 10px 20px;
        }

        .nav-tabs .nav-link.active {
            color: #0d6efd;
            border-bottom: 3px solid #0d6efd;
            background-color: transparent;
        }
    </style>
</head>

<body>
    <div class="container-fluid p-0">
        @yield('contenido')
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
        <!-- Incluir Chart.js y nuestro script personalizado -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
    <!-- Script personalizado -->
    <script src="{{ asset('js/LogicaAdministrador/Admin_graficos.js') }}"></script>
</body>

</html>