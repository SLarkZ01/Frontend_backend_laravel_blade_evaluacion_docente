<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\DecanoCordinadorController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExcelImportController;
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
Route::get('/decano/acta-compromiso', [DecanoCordinadorController::class, 'acta_compromiso'])->name('decano.acta_compromiso');
Route::post('/decano/acta-compromiso', [DecanoCordinadorController::class, 'guardar_acta'])->name('decano.guardar_acta');
Route::get('/decano/acta-compromiso/{id}/editar', [DecanoCordinadorController::class, 'editar_acta'])->name('decano.editar_acta');
Route::put('/decano/acta-compromiso/{id}', [DecanoCordinadorController::class, 'actualizar_acta'])->name('decano.actualizar_acta');
Route::delete('/decano/acta-compromiso/{id}', [DecanoCordinadorController::class, 'eliminar_acta'])->name('decano.eliminar_acta');
Route::put('/decano/acta-compromiso/{id}/enviar', [DecanoCordinadorController::class, 'enviar_acta'])->name('decano.enviar_acta');

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
Route::get('/docente/{id_docente}', [App\Http\Controllers\DecanoCordinadorController::class, 'getDocente']);
