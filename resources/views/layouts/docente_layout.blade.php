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