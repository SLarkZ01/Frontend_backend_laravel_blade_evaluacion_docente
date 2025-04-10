<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{-- Sistema de Evaluación Docentes - Panel Docente --}}
    @yield('titulo')
    </title>
    <link rel="icon" href="../images/Logo Uniautonoma.png">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js para gráficos -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <style>
        /* Estilos específicos para el panel docente */
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

        .card-evaluacion {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s, box-shadow 0.3s;
            height: 100%;
            border: none;
            overflow: hidden;
        }

        .card-evaluacion:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        .card-evaluacion .card-body {
            padding: 1.5rem;
        }

        .progress {
            height: 10px;
            margin-top: 8px;
            border-radius: 10px;
            background-color: rgba(13, 110, 253, 0.1);
        }

        .pendiente-badge {
            font-size: 1.5rem;
            color: #0d6efd;
            font-weight: bold;
        }

        .curso-card {
            border-left: 4px solid #0d6efd;
            margin-bottom: 15px;
            transition: transform 0.2s;
        }

        .curso-card:hover {
            transform: translateX(5px);
            background-color: #f0f7ff !important;
        }

        .resumen-criterio {
            margin-bottom: 15px;
        }

        /* Estilos para el contenedor de gráficos */
        .chart-container {
            position: relative;
            margin: auto;
            height: 300px;
            width: 100%;
            background-color: #fff;
            border-radius: 10px;
            padding: 15px;
        }

        /* Estilos para los filtros */
        .filter-container {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        /* Estilos para los botones de tipo de gráfico */
        .chart-type-selector {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 15px;
        }

        .chart-type-btn {
            border: 1px solid #dee2e6;
            background-color: white;
            border-radius: 5px;
            padding: 8px 15px;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .chart-type-btn:hover {
            background-color: #f0f7ff;
            border-color: #0d6efd;
        }

        .chart-type-btn.active {
            background-color: #0d6efd;
            color: white;
            border-color: #0d6efd;
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
    </style>
</head>

<body>
    <div class="container-fluid p-0">
        @yield('contenido')
    </div>

    <!-- Fin del contenido principal -->

    <!-- Bootstrap JS y scripts personalizados -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/LogicaDocente/script.js') }}"></script>
    <!-- Bootstrap JS y scripts personalizados -->
</body>

</html>