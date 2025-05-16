<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ActaCompromisoController;
use App\Http\Controllers\API\AlertaBajoDesempenoController;
use App\Http\Controllers\API\CoordinacionController;
use App\Http\Controllers\API\DocenteController;
use App\Http\Controllers\API\EvaluacionController;
use App\Http\Controllers\API\FacultadController;
use App\Http\Controllers\API\EstudianteController;
use App\Http\Controllers\API\PlanMejoraController;
use App\Http\Controllers\API\ProgramaController;
use App\Http\Controllers\API\UsuarioController;
use App\Http\Controllers\API\RolController;
use App\Http\Controllers\API\ProcesoSancionController;
use App\Http\Controllers\API\ProgramaController as APIProgramaController;
use App\Http\Controllers\API\RolController as APIRolController;
use App\Http\Controllers\API\ExcelImportController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/importar', [ExcelImportController::class, 'importar']);
// Acta de Compromiso API Routes
Route::prefix('actas-compromiso')->group(function () {
    Route::get('/', [ActaCompromisoController::class, 'index']);
    Route::get('/{id}', [ActaCompromisoController::class, 'show']);
    Route::post('/', [ActaCompromisoController::class, 'store']);
    Route::put('/{id}', [ActaCompromisoController::class, 'update']);
    Route::delete('/{id}', [ActaCompromisoController::class, 'destroy']);
});

// Docentes API Routes
Route::prefix('docentes')->group(function () {
    Route::get('/', [DocenteController::class, 'index']);
    Route::get('/{correo}', [DocenteController::class, 'show']);
    Route::get('/{correo}/evaluaciones', [DocenteController::class, 'evaluaciones']);
    Route::put('/{id}/profile', [DocenteController::class, 'updateProfile']);
});

// Evaluaciones API Routes
Route::prefix('evaluaciones')->group(function () {
    Route::get('/', [EvaluacionController::class, 'index']);
    Route::get('/{id}', [EvaluacionController::class, 'show']);
    Route::get('/periodo/{periodo}', [EvaluacionController::class, 'byPeriodo']);
    Route::get('/facultad/{facultad}', [EvaluacionController::class, 'byFacultad']);
    Route::get('/estadisticas', [EvaluacionController::class, 'estadisticas']);
});

// Facultades API Routes
Route::prefix('facultades')->group(function () {
    Route::get('/', [FacultadController::class, 'index']);
    Route::get('/{id}', [FacultadController::class, 'show']);
    Route::post('/', [FacultadController::class, 'store']);
    Route::put('/{id}', [FacultadController::class, 'update']);
    Route::delete('/{id}', [FacultadController::class, 'destroy']);
    Route::get('/{id}/programas', [FacultadController::class, 'programas']);
});

// Estudiantes API Routes
Route::prefix('estudiantes')->group(function () {
    Route::get('/', [EstudianteController::class, 'index']);
    Route::get('/{id}', [EstudianteController::class, 'show']);
    Route::post('/', [EstudianteController::class, 'store']);
    Route::put('/{id}', [EstudianteController::class, 'update']);
    Route::delete('/{id}', [EstudianteController::class, 'destroy']);
    Route::get('/programa/{id_programa}', [EstudianteController::class, 'byPrograma']);
});

// Usuarios API Routes
Route::prefix('usuarios')->group(function () {
    Route::get('/', [UsuarioController::class, 'index']);
    Route::get('/{id}', [UsuarioController::class, 'show']);
    Route::post('/', [UsuarioController::class, 'store']);
    Route::put('/{id}', [UsuarioController::class, 'update']);
    Route::delete('/{id}', [UsuarioController::class, 'destroy']);
});

// Roles API Routes
Route::prefix('roles')->group(function () {
    Route::get('/', [RolController::class, 'index']);
    Route::get('/{id}', [RolController::class, 'show']);
    Route::post('/', [RolController::class, 'store']);
    Route::put('/{id}', [RolController::class, 'update']);
    Route::delete('/{id}', [RolController::class, 'destroy']);
});

// Programas API Routes
Route::prefix('programas')->group(function () {
    Route::get('/', [ProgramaController::class, 'index']);
    Route::get('/{id}', [ProgramaController::class, 'show']);
    Route::post('/', [ProgramaController::class, 'store']);
    Route::put('/{id}', [ProgramaController::class, 'update']);
    Route::delete('/{id}', [ProgramaController::class, 'destroy']);
    Route::get('/{id}/estudiantes', [ProgramaController::class, 'estudiantes']);
    Route::get('/{id}/cursos', [ProgramaController::class, 'cursos']);
});

// Coordinaciones API Routes
Route::prefix('coordinaciones')->group(function () {
    Route::get('/', [CoordinacionController::class, 'index']);
    Route::get('/{id}', [CoordinacionController::class, 'show']);
    Route::post('/', [CoordinacionController::class, 'store']);
    Route::put('/{id}', [CoordinacionController::class, 'update']);
    Route::delete('/{id}', [CoordinacionController::class, 'destroy']);
    Route::get('/{id}/facultades', [CoordinacionController::class, 'facultades']);
});

// Alertas de Bajo Desempeño API Routes
Route::prefix('alertas-bajo-desempeno')->group(function () {
    Route::get('/', [AlertaBajoDesempenoController::class, 'index']);
    Route::get('/{id}', [AlertaBajoDesempenoController::class, 'show']);
    Route::post('/', [AlertaBajoDesempenoController::class, 'store']);
    Route::put('/{id}', [AlertaBajoDesempenoController::class, 'update']);
    Route::delete('/{id}', [AlertaBajoDesempenoController::class, 'destroy']);
    Route::get('/docente/{id_docente}', [AlertaBajoDesempenoController::class, 'getAlertasByDocente']);
    Route::get('/facultad/{id_facultad}', [AlertaBajoDesempenoController::class, 'getAlertasByFacultad']);
});

// Plan de Mejora API Routes
Route::prefix('planes-mejora')->group(function () {
    Route::get('/', [PlanMejoraController::class, 'index']);
    Route::get('/{id}', [PlanMejoraController::class, 'show']);
    Route::post('/', [PlanMejoraController::class, 'store']);
    Route::put('/{id}', [PlanMejoraController::class, 'update']);
    Route::delete('/{id}', [PlanMejoraController::class, 'destroy']);
    Route::post('/{id}/notas', [PlanMejoraController::class, 'addNota']);
    Route::put('/{id}/progreso', [PlanMejoraController::class, 'updateProgress']);
    Route::get('/docente/{id_docente}', [PlanMejoraController::class, 'getPlansByDocente']);
    Route::get('/facultad/{id_facultad}', [PlanMejoraController::class, 'getPlansByFacultad']);
});

// Proceso Sanción API Routes
Route::prefix('procesos-sancion')->group(function () {
    Route::get('/', [ProcesoSancionController::class, 'index']);
    Route::get('/{id}', [ProcesoSancionController::class, 'show']);
    Route::post('/', [ProcesoSancionController::class, 'store']);
    Route::put('/{id}', [ProcesoSancionController::class, 'update']);
    Route::delete('/{id}', [ProcesoSancionController::class, 'destroy']);
    Route::put('/{id}/enviar', [ProcesoSancionController::class, 'enviar']);
    Route::get('/buscar/docente', [ProcesoSancionController::class, 'buscarPorDocente']);
    Route::get('/filtrar/tipo', [ProcesoSancionController::class, 'filtrarPorTipo']);
    Route::get('/filtrar/calificacion', [ProcesoSancionController::class, 'filtrarPorCalificacion']);
    Route::get('/docentes/bajo-desempeno', [ProcesoSancionController::class, 'docentesBajoDesempeno']);
});

