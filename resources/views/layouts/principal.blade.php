<!DOCTYPE html>
<html lang="es">

<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('titulo')</title>
    <link rel="icon" href="{{ asset('images/LogoUniautonoma.png') }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Select2 para mejorar los selectores -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Summernote para editor de texto enriquecido -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">

    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>

<body>
    
    <main>
        <x-sidebar>
            {{-- Slot para el menú personalizado --}}
            <x-slot name="menu">
                @yield('menu-sidebar')
            </x-slot>

            <x-slot name="perfil">
                @yield('name-perfil')
            </x-slot>
        
            {{-- Contenido principal de cada vista --}}
            @yield('contenido')
        </x-sidebar>
        
    </main>
    

    
    <!-- Scripts de plugins -->
    <script src="{{ asset('js/sidebar/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/sidebar/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>



    <!-- Scripts de lógica de docentes -->
    <script src="{{ asset('js/LogicaDocente/configuracion.js') }}"></script>
    <script src="{{ asset('js/LogicaDocente/script.js') }}"></script>

    <!-- Scripts de lógica de administrador -->
    <script src="{{ asset('js/LogicaAdministrador/Admin_graficos.js') }}"></script>

    <!-- Scripts de lógica de decano/coordinador -->
    <script src="{{ asset('js/LogicaDecanoCoordinador/navigation.js') }}"></script>
    <script src="{{ asset('js/LogicaDecanoCoordinador/dashboard_interactivo.js') }}"></script>
    <script src="{{ asset('js/LogicaDecanoCoordinador/pdf_generator.js') }}"></script>
    <script src="{{ asset('js/LogicaDecanoCoordinador/sancion_script.js') }}"></script>
    <script src="{{ asset('js/LogicaDecanoCoordinador/sancion_pdf_generator.js') }}"></script>

    <script src="{{ asset('js/LogicaDecanoCoordinador/script.js') }}"></script>

</body>

</html>
