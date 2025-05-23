<?php

use App\Http\Controllers\API\ActaCompromisoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\DecanoCordinadorController;
use App\Http\Controllers\ExcelImportController;
use App\Http\Controllers\AuthController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImportarController;
use App\Http\Controllers\ImportarExcelController;
use App\Http\Controllers\ImportarEvaluacionController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//principio docente
Route::get("/docente", [DocenteController::class, 'p_docente'])->name('docente.p_docente');
//configuracion docente
Route::get("/docente/configuracion", [DocenteController::class, 'confi'])->name('docente.confi');
//panel docente mejorado
Route::get("/docente/PDmejorado", [DocenteController::class, 'pde'])->name('docente.pde');
//resultados
Route::get("/docente/resultados", [DocenteController::class, 'result'])->name('docente.result');

//Login
Route::post('/login', [loginController::class, 'validation'])->name('login.process');



Route::get("/decano", [HomeController::class, 'index'])->name('user.index');

Route::get('/', [loginController::class, 'Login'])->name('user.login');

// Rutas para actas de compromiso
Route::prefix('decano/acta-compromiso')->name('decano.')->group(function () {
    Route::get('/', [DecanoCordinadorController::class, 'acta_compromiso'])->name('acta_compromiso');

    // Route::post('/', [DecanoCordinadorController::class, 'guardar_acta'])->name('guardar_acta');

    Route::get('/{id}/editar', [DecanoCordinadorController::class, 'editar_acta'])->name('editar_acta');

    Route::put('/{id}', [DecanoCordinadorController::class, 'actualizar_acta'])->name('actualizar_acta');

    Route::delete('/{id}', [DecanoCordinadorController::class, 'eliminar_acta'])->name('eliminar_acta');

    Route::put('/{id}/enviar', [DecanoCordinadorController::class, 'enviar_acta'])->name('enviar_acta');
});

// rutas para el administrador
Route::get('/Admin', [AdminController::class, 'Dashboard'])->name('Admin.Dashboard');
// rutas para el periodo de evaluacion
Route::get('/Admin/periodo_evaluacion', [AdminController::class, 'periodo_evaluacion'])
->name('admin.periodo_evaluacion');
// rutas para los reportes
Route::get('/Admin/reportes', [AdminController::class, 'reportes'])->name('admin.reportes_admin');
// rutas para los roles y permisos
Route::get('/Admin/roles_permisos', [AdminController::class, 'roles_permisos'])
->name('admin.roles_permisos');


// rutas de decano coordinador//
// acta de compromisoS
Route::get('/decano/actaCompromiso', [DecanoCordinadorController::class, 'acta_compromiso'])->name('decano.acta_compromiso');
// alertas bajo desempeño
Route::get('/decano/alertasBajoDesempeno', [DecanoCordinadorController::class, 'abd'])->name('decano.abd');
// modales seguimiento
Route::get('/decano/modalesSeguimiento', [DecanoCordinadorController::class, 'seguimiento'])->name('decano.seguimiento');
// proceso sancion retiro
Route::get('/decano/procesoSancionRetiro', [DecanoCordinadorController::class, 'psr'])->name('decano.psr');
// seguimiento plan de mejora
Route::get('/decano/seguimientoPlanMejora', [DecanoCordinadorController::class, 'spm'])->name('decano.spm');
//total de docentes
Route::get('/decanato/total_docente', [DecanoCordinadorController::class, 'total_Docentes'])->name('decanato.total_docentes');


//docentes no evaluados
Route::get('/decano/totalNoEvaluados', [DecanoCordinadorController::class, 'totalNoEvaluados'])->name('decano.totalNoEvaluados');
//esrtudiantes no evaluados
Route::get('/decano/totalEstudiantesNoEvaluaron', [DecanoCordinadorController::class, 'totalEstudiantesNoEvaluaron'])->name('decano.totalEstudiantesNoEvaluaron');
// editar acta de compromiso
Route::get('/decano/editar-acta/{id_acta}', [DecanoCordinadorController::class, 'editarActa'])->name('decano.editar_acta');
// actualizar acta de compromiso
Route::put('/decano/actualizar-acta/{id_acta}', [DecanoCordinadorController::class, 'actualizarActa'])->name('decano.actualizar_acta');
//promedio por facultad
Route::get('/decano/promedio_global', [DecanoCordinadorController::class, 'promedio_global'])->name('decano.promedio_global');
 //promedio por facultad graficado
Route::get('/decano/promedio-facultad-ultimo-periodo', [DecanoCordinadorController::class, 'obtenerPromedioPorFacultad']);
Route::get('/decano/promedio-facultad', [DecanoCordinadorController::class, 'mostrarGraficoFacultades'])->name('decano.mostrarGraficoFacultades');


Route::get('/decano/docentesDestacados', [DecanoCordinadorController::class, 'obtenerDocentesDestacados'])->name('decano.docentesdestacados');

Route::get('/decano/buscar-docente', [DecanoCordinadorController::class, 'buscarDocente'])->name('decano.buscarDocente');

Route::get('/decano/grafica-promedios', [DecanoCordinadorController::class, 'mostrarGrafica']);
Route::get('/decano/alertas', [DecanoCordinadorController::class, 'index']);


Route::get('/importar', function () {
    return view('importar');
});

// Route::post('/importar-excel', [ExcelImportController::class, 'importar']);
Route::get('/cargar-excel', function () {
    return view('cargar-excel');
});

Route::post('/importar', [ExcelImportController::class, 'importar']);
Route::get('/cargar-excel', function () {
    return view('cargar-excel');
});

Route::post('/importar', [ExcelImportController::class, 'importar']);
Route::get('/buscar-docente', [DecanoCordinadorController::class, 'buscarDocente'])->name('buscar.docente');
Route::get('/docente/{id_docente}', [DecanoCordinadorController::class, 'getDocente']);
Route::get('/decano/acta-compromiso', [DecanoCordinadorController::class, 'mostrar_formulario_acta'])->name('actas.formulario');
// Route::post('/decano/guardar-acta', [DecanoCordinadorController::class, 'guardar_acta'])->name('guardar.acta');
Route::get('/decano/actas', [DecanoCordinadorController::class, 'listar_actas'])->name('actas.index');
Route::get('/decano/editar-acta/{id_acta}', [DecanoCordinadorController::class, 'editarActa'])->name('decano.editar_acta');
// Add this to your routes/web.php file

Route::get('/decano/descargar', [DecanoCordinadorController::class, 'descargar'])
    ->name('descargar.acta_compromiso');
Route::prefix('actas-compromisos')->group(function () {
    // Vista principal para crear actas
    Route::get('/', [ActaCompromisoController::class, 'index'])->name('actas.compromiso.index');
    // Guardar nueva acta
    Route::post('/guardar', [DecanoCordinadorController::class, 'store'])->name('actas.compromiso.store');

    // Filtrado de docentes para AJAX
    Route::get('/filtrar-docentes', [DecanoCordinadorController::class, 'filtrarDocentes'])->name('actas.compromiso.filtrar');

    // Obtener datos de un docente específico
    Route::get('/docente/{id}', [DecanoCordinadorController::class, 'obtenerDocente'])->name('actas.compromiso.docente');

    // Listar todas las actas
    Route::get('/listar', [DecanoCordinadorController::class, 'listar'])->name('actas.compromiso.listar');

    // Ver detalles de un acta específica'
    Route::get('/ver/{id}', [DecanoCordinadorController::class, 'ver'])->name('actas.compromiso.ver');
});
// // Rutas para el sistema de Actas de Compromiso
// Route::prefix('actas-compromiso')->group(function () {
//     // Vista principal
//     Route::get('/', [App\Http\Controllers\API\ActaCompromisoController::class, 'index'])
//         ->name('decano.acta_compromiso');

//     // Obtener datos de un docente específico para autocompletado
//     Route::get('/obtener-docente/{id}', [App\Http\Controllers\API\ActaCompromisoController::class, 'obtenerDocente']);

//     // Filtrar docentes según criterios seleccionados
//     Route::get('/filtrar-docentes', [App\Http\Controllers\API\ActaCompromisoController::class, 'filtrarDocentes'])
//         ->name('actas.compromiso.filtrar');

    // Guardar nueva acta
    // Route::post('/guardar', [App\Http\Controllers\API\ActaCompromisoController::class, 'store'])
    //     ->name('actas.compromiso.store');
    // Route::post('/actas-compromiso/guardar', [App\Http\Controllers\API\ActaCompromisoController::class, 'store'])
    // ->name('decano.guardar_acta');
    // Route::post('/guardar', [ActaCompromisoController::class, 'store'])->name('guardar.acta_compromiso');

    //     Route::post('/guardar', [App\Http\Controllers\API\ActaCompromisoController::class, 'guardar'])
    // ->name('decano.guardar_acta');
    

    // Ver acta específica
//   Route::get('/ver/{id}', [App\Http\Controllers\API\ActaCompromisoController::class, 'ver'])
//     ->name('actas.compromiso.ver');


//     // Descargar PDF
//     Route::get('/descargar/{id}', [App\Http\Controllers\API\ActaCompromisoController::class, 'descargarPDF'])
//         ->name('descargar.acta_compromiso');

//     // Eliminar acta
//     Route::delete('/eliminar/{id}', [App\Http\Controllers\API\ActaCompromisoController::class, 'destroy'])
//         ->name('actas.compromiso.destroy');
// });

// // Rutas para la funcionalidad de Sanciones
Route::middleware(['auth', 'role:decano,coordinador'])->prefix('decano')->name('decano.')->group(function () {
    // Mostrar formulario de sanción
    Route::get('/sanciones/formulario', [DecanoCordinadorController::class, 'mostrarFormularioSancion'])->name('formulario_sancion');

    // Guardar sanción
    Route::post('/sanciones/guardar', [DecanoCordinadorController::class, 'guardarSancion'])->name('guardar_sancion');

    // Listar sanciones
    Route::get('/sanciones', [DecanoCordinadorController::class, 'listarSanciones'])->name('sanciones');

    // Ver detalle de sanción
    Route::get('/sanciones/{id}', [DecanoCordinadorController::class, 'verDetalleSancion'])->name('ver_sancion');

    // Generar PDF de sanción
    Route::get('/sanciones/{id}/pdf', [DecanoCordinadorController::class, 'generarPdfSancion'])->name('generar_pdf_sancion');

    // Enviar resolución al docente
    Route::post('/sanciones/{id}/enviar', [DecanoCordinadorController::class, 'enviarResolucionDocente'])->name('enviar_resolucion');

    // Endpoint AJAX para enviar resolución
    Route::post('/sanciones/enviar-ajax', [DecanoCordinadorController::class, 'enviarResolucionAjax'])->name('enviar_resolucion_ajax');
});
