<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index, follow">
    <meta name="theme-color" content="#09f">
    <meta name="description" content="Sistema de Evaluacion Docente">
    <link rel="icon" href="{{ asset('images/LogoUniautonoma.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Login - Sistema de Evaluacion Docente</title>
</head>
<style>
    body {
        background-color: #f8f9fa;
        background-image: url("{{ asset('images/FondoUniversidad.png') }}"); /* Ruta de la imagen de fondo */
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    }

    .card {
        max-width: 300px;
        width: 100%;
        backdrop-filter: blur(7px);
        background-color: rgba(255, 255, 255, 0.103);
        border-radius: 15px;
        border: 2px solid rgba(255, 255, 255, 0.568);
        color: rgb(255, 255, 255);
    }

    .form-label {
        color: white;
    }

    .form-control {
        font-size: 0.8rem;
    }

    .btn-primary {
        background-color: #0b67cacc;
        border-color: #044183;
    }
</style>

<body>
    <!-- Contenedor de Login -->
    <div id="loginContainer" class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow-lg">
            <h2 class="card-title text-center mb-4">Iniciar sesión</h2>
            <div id="loginAlert" class="alert alert-danger d-none"></div>
            <form  action="{{ route('login.process') }}" method="POST">
                @csrf <!-- Protección contra ataques CSRF  id="loginForm"  -->
                <div class="mb-3">
                    <label for="username" class="form-label">Correo</label>
                    <input type="email" id="username" name="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Entrar</button>
            </form>
        </div>
    </div>

    <!-- Librerías JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/Login/login.js') }}"></script>
</body>

</html>
