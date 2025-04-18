<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\DecanoCordinadorController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


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


//lista los docentes
Route::get('/decano/total_docentes', [DecanoCordinadorController::class, 'total_docentes']);

Route::get("/decano", [HomeController::class, 'index'])->name('user.index');

Route::get('/', [loginController::class, 'Login'])->name('user.login');




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
