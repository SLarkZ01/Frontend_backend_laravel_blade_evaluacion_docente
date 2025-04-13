@extends('layouts.principal')   
@section('titulo', 'Panel del Docente/Resultados')
@section('contenido')

    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- Sidebar / Menú lateral -->
            

            

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
                                        <option value="algebra">Álgebra Lineal</option>
                                        <option value="calculo">Cálculo Diferencial</option>
                                        <option value="matematicas">Matemáticas Avanzadas</option>
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
                    <div id="visualizacionMateria" class="mb-4" style="display: none;">
                        <h5 class="text-primary mb-3">Visualizando <span id="nombreMateria">Álgebra Lineal</span></h5>

                        <!-- Gráfico de evaluaciones -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Resumen</h5>
                                <div class="chart-container">
                                    <canvas id="evaluacionesChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Evaluaciones por semestre -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Evaluación Estudiantil S1</h5>
                                        <h2 class="display-4 text-primary" id="evaluacionS1">2.4/5.0</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Evaluación Estudiantil S2</h5>
                                        <h2 class="display-4 text-primary" id="evaluacionS2">4.4/5.0</h2>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Filtros y opciones de descarga -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row align-items-center mb-3">
                                    <div class="col-md-3">
                                        <label for="yearSelect" class="form-label">Año:</label>
                                        <select class="form-select" id="yearSelect">
                                            <option value="2023">2023</option>
                                            <option value="2022">2022</option>
                                            <option value="2021">2021</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="semesterSelect" class="form-label">Semestre:</label>
                                        <select class="form-select" id="semesterSelect">
                                            <option value="1">Semestre 1</option>
                                            <option value="2">Semestre 2</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="chartType" class="form-label">Tipo de Gráfica:</label>
                                        <select class="form-select" id="chartType">
                                            <option value="bar">Gráfico de Barras</option>
                                            <option value="line">Gráfico de Líneas</option>
                                            <option value="radar">Gráfico de Radar</option>
                                            <option value="pie">Gráfico Circular</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Descargar Resultados:</label>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-outline-primary" onclick="downloadResults('pdf')"><i
                                                    class="fas fa-file-pdf"></i> PDF</button>
                                            <button class="btn btn-outline-success"
                                                onclick="downloadResults('excel')"><i class="fas fa-file-excel"></i>
                                                Excel</button>
                                            <button class="btn btn-outline-secondary"
                                                onclick="downloadResults('csv')"><i class="fas fa-file-csv"></i>
                                                CSV</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Gráficas -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Visualización de Resultados</h5>
                                <div class="chart-container">
                                    <canvas id="mainChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Tabla de evaluaciones -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Tabla de Evaluaciones</h5>
                                <div class="table-container">
                                    <table class="table table-striped table-hover table-evaluaciones">
                                        <thead>
                                            <tr>
                                                <th>Año</th>
                                                <th>Semestre 1</th>
                                                <th>Semestre 2</th>
                                                <th>Promedio Anual</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tablaEvaluaciones">
                                            <!-- Datos generados dinámicamente -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Comentarios de evaluaciones -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Comentarios de Estudiantes</h5>
                                <div id="comentariosContainer">
                                    <!-- Los comentarios se cargarán dinámicamente aquí -->
                                </div>
                            </div>
                        </div>

                        <!-- Fin del contenido de evaluaciones -->
                    </div>
                </div>
            </div>

    <!-- Bootstrap JS y scripts personalizados -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/LogicaDocente/script.js')}}"></script>

    @endsection
