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

            <!-- Encabezado mejorado -->
            <div class="header-card animated-card">
                <h1>Resultados de Evaluación</h1>
                <p class="text-muted">Visualiza y analiza tus resultados de evaluación docente</p>
            </div>

            <!-- Selector de materia -->
            <div class="card dashboard-card mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <label for="materiaSelect" class="form-label">Elige una materia para visualizar las
                                estadísticas</label>
                            <select class="form-select" id="materiaSelect">
                                <option value="" selected disabled>Selecciona una materia</option>
                                @foreach ($notasCursos as $curso)
                                    <option 
                                        value="{{ $curso->nombre_curso }}" 
                                        data-promEvaluacionDocente="{{ $curso->promedio_ev_docente }}"
                                        data-promNotasCurso="{{ $curso->promedio_notas_curso }}">
                                        {{ $curso->nombre_curso }}
                                    </option>
                                @endforeach
                            </select>

                        </div>
                        <div class="col-md-6 text-end">
                            <button class="btn btn-primary" id="generarDatosBtn">
                                <i class="fas fa-sync-alt me-2"></i>Generar datos aleatorios
                            </button>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Visualización de materia seleccionada -->
            <div id="visualizacionMateria" class="mb-4" style="display: block;">
                <h5 class="text-primary mb-3">Visualizando <span id="nombreMateria">Álgebra Lineal</span></h5>

               

                <!-- Evaluaciones por semestre -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Promedio evaluación docente</h5>
                                <h2 class="display-4 text-primary" id="evaluacionS1"></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Promedio evaluación notas curso</h5>
                                <h2 class="display-4 text-primary" id="evaluacionS2"></h2>
                            </div>
                        </div>
                    </div>
                </div>
            <!-- Gráfico comparativo -->
                <div class="card mb-4">
                 <div class="card-body">
                  <h5 class="card-title">Comparativa de Calificaciones por Curso</h5>
                  <canvas id="comparacionChart" height="120"></canvas>
                </div>
                </div>

            
                <!-- Comentarios de evaluaciones -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Comentarios de Estudiantes</h5>
                        <div id="comentariosContainer">
    <!-- Comentarios de prueba fijos -->
    <div class="comentario">
        <div class="rating-container">
            <span class="rating">4.5</span>
            <span class="star-rating">★★★★☆</span>
        </div>
        <div class="text">Excelente docente, explica con claridad y utiliza ejemplos prácticos.</div>
    </div>
    
    <div class="comentario">
        <div class="rating-container">
            <span class="rating">3.8</span>
            <span class="star-rating">★★★☆☆</span>
        </div>
        <div class="text">Buena clase, aunque a veces se avanza muy rápido en los temas.</div>
    </div>

    <div class="comentario">
        <div class="rating-container">
            <span class="rating">4.9</span>
            <span class="star-rating">★★★★★</span>
        </div>
        <div class="text">Muy comprometido con el aprendizaje de los estudiantes.</div>
    </div>

    <div class="comentario">
        <div class="rating-container">
            <span class="rating">2.5</span>
            <span class="star-rating">★★☆☆☆</span>
        </div>
        <div class="text">Debería mejorar la puntualidad y responder más dudas.</div>
    </div>
</div>

                    </div>
                </div>

                <!-- Fin del contenido de evaluaciones -->
            </div>
        </div>
    </div>


    <!-- Bootstrap JS y scripts personalizados -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/LogicaDocente/script.js') }}"></script>
   <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const cursos = @json($notasCursos);

        const labels = cursos.map(curso => curso.nombre_curso);
        const notasCurso = cursos.map(curso => parseFloat(curso.promedio_notas_curso));
        const evaluacionDocente = cursos.map(curso => parseFloat(curso.promedio_ev_docente));

        const ctx = document.getElementById('comparacionChart').getContext('2d');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Notas del Curso',
                        data: notasCurso,
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Evaluación Docente',
                        data: evaluacionDocente,
                        backgroundColor: 'rgba(255, 99, 132, 0.7)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 6,
                        title: {
                            display: true,
                            text: 'Promedio'
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    title: {
                        display: true,
                        text: 'Comparación de Evaluaciones por Curso'
                    }
                }
            }
        });
    });
</script>

   <script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectMateria = document.getElementById('materiaSelect');
        const nombreMateria = document.getElementById('nombreMateria');
        const evaluacionS1 = document.getElementById('evaluacionS1'); // Docente
        const evaluacionS2 = document.getElementById('evaluacionS2'); // Notas curso

        if (!selectMateria || !nombreMateria || !evaluacionS1 || !evaluacionS2) return;

        selectMateria.addEventListener('change', function () {
            const selectedOption = selectMateria.options[selectMateria.selectedIndex];

            // Obtiene valores desde data-attributes
            const nombre = selectedOption.value;
            const promEvDocente = selectedOption.getAttribute('data-promEvaluacionDocente');
            const promNotasCurso = selectedOption.getAttribute('data-promNotasCurso');

            // Asigna los valores en el DOM
            nombreMateria.textContent = nombre;
            evaluacionS1.textContent = `${parseFloat(promEvDocente).toFixed(1)}/6`;
            evaluacionS2.textContent = `${parseFloat(promNotasCurso).toFixed(1)}/5.0`;
        });

        // Ejecutar cambio por defecto si hay una opción ya seleccionada
        selectMateria.dispatchEvent(new Event('change'));
    });
</script>


@endsection
