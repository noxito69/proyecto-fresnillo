<?php

use App\Http\Controllers\RoleController;
use App\Mail\ValidatorEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\AccesorioController;
use App\Http\Controllers\AnexoController;
use App\Http\Controllers\UsuarioPenmontController;
use App\Http\Controllers\EtiquetasEmpleadosController;
use App\Http\Controllers\HistorialController;
use App\Http\Controllers\TonnerController;
use App\Http\Controllers\ImpresoraController;
use App\Http\Controllers\HistorialTonnerController;
;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CentroCostoController;
use App\Http\Controllers\EmpresaContratistaController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\EtiquetaContratistaController;
use App\Http\Controllers\historial_prestamo_controller;
use App\Http\Controllers\UsuariosPenmontController;
use GuzzleHttp\Middleware;
use App\Http\Controllers\HistorialImpresorasController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ModeloController;
use App\Http\Controllers\ModeloEmpleadoController;
use App\Http\Controllers\TipoEquipoController;
use App\Models\ModeloEmpleado;

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {


    //user
    Route::post('login', [AuthController::class,'login'])->middleware('auth.active');
    Route::post('logout', 'App\Http\Controllers\AuthController@logout');
    Route::post('refresh', 'App\Http\Controllers\AuthController@refresh');
    Route::post('me', 'App\Http\Controllers\AuthController@me');
    Route::post('register', 'App\Http\Controllers\AuthController@register');
    Route::get('activate/{user}', 'App\Http\Controllers\AuthController@activate')->name('activate')->middleware('signed');

    Route::get('get',[UserController::class,'index']);
    Route::post('post',[UserController::class,'store']);
    Route::delete('delete/{id}',[UserController::class,'destroy'])->middleware('authrole')->where('id','[0-9]+');
    Route::put('put/{id}',[UserController::class,'update'])->middleware('authrole2')->where('id','[0-9]+');
    Route::post("login/user", [UserController::class,"login"]);

    //centro de costos
    Route::get('centro_costos/index', [CentroCostoController::class, 'index']);
    Route::post('centro_costos/post', [CentroCostoController::class, 'store']);
    Route::get('centro_costos/get/{id}', [CentroCostoController::class, 'show']);
    Route::put('centro_costos/put/{id}', [CentroCostoController::class, 'update']);
    Route::delete('centro_costos/delete/{id}', [CentroCostoController::class, 'destroy']);
    Route::get('centro_costos/search', [CentroCostoController::class, 'search']);
    Route::get('centro_costos/indexPg', [CentroCostoController::class, 'indexPg']);


    //departamentos
    
    Route::get('departamentos/indexPg', [DepartamentoController::class, 'indexPg']);
    Route::get('departamentos/index', [DepartamentoController::class, 'index']);
    Route::post('departamentos/post', [DepartamentoController::class, 'store']);
    Route::get('departamentos/get/{id}', [DepartamentoController::class, 'show']);
    Route::put('departamentos/put/{id}', [DepartamentoController::class, 'update']);
    Route::patch('departamentos/delete/{id}', [DepartamentoController::class, 'delete']);
    Route::get('departamentos/search', [DepartamentoController::class, 'search']);
    Route::get('departamentos/indexAlfa', [DepartamentoController::class, 'indexAlfa']);



    //accesorios
    Route::get('accesorios/index', [AccesorioController::class, 'index']);
    Route::post('accesorios/post', [AccesorioController::class, 'store']);
    Route::get('accesorios/get/{id}', [AccesorioController::class, 'show']);
    Route::put('accesorios/put/{id}', [AccesorioController::class, 'update']);
    Route::delete('accesorios/delete/{id}', [AccesorioController::class, 'destroy']);
    Route::get('accesorios/getByBarCode/{codigo_barras}', [AccesorioController::class, 'getByBarCode']);
    Route::put('accesorios/updateQuantity/{codigo_barras}', [AccesorioController::class, 'updateQuantity']);
    Route::put('accesorios/updateQuantityMinus/{id}', [AccesorioController::class, 'updateQuantityMinus']);
    Route::get('accesorios/getTotal', [AccesorioController::class, 'getTotal']);
    Route::get('accesorios/search', [AccesorioController::class, 'search']);
    Route::get('accesorios/indexPg', [AccesorioController::class, 'indexPg']);



    //anexos
    Route::get('anexos/index',[AnexoController::class,'index']);
    Route::post('anexos/post',[AnexoController::class,'store']);
    Route::get('anexos/get/{id}',[AnexoController::class,'show']);
    Route::put('anexos/put/{id}',[AnexoController::class,'update']);
    Route::delete('anexos/delete/{id}',[AnexoController::class,'destroy']);
    Route::get('anexos/search', [AnexoController::class, 'search']);
    Route::get('anexos/indexPg', [AnexoController::class, 'indexPg']);



    //tipo de equipo
    Route::get('tipo_equipo/index',[TipoEquipoController::class,'index']);
    Route::post('tipo_equipo/post',[TipoEquipoController::class,'store']);
    Route::get('tipo_equipo/get/{id}',[TipoEquipoController::class,'show']);
    Route::put('tipo_equipo/put/{id}',[TipoEquipoController::class,'update']);
    Route::delete('tipo_equipo/delete/{id}',[TipoEquipoController::class,'destroy']);
    Route::get('tipo_equipo/search', [TipoEquipoController::class, 'search']);
    Route::get('tipo_equipo/paginatedIndex', [TipoEquipoController::class, 'paginatedIndex']);


    //Marca

    Route::get('marca/getMarcas',[MarcaController::class,'getMarcas']);
    Route::get('marca/index',[MarcaController::class,'index']);
    Route::post('marca/post',[MarcaController::class,'store']);
    Route::get('marca/get/{id}',[MarcaController::class,'show']);
    Route::put('marca/put/{id}',[MarcaController::class,'update']);
    Route::delete('marca/delete/{id}',[MarcaController::class,'destroy']);
    Route::get("marca/search", [MarcaController::class, "search"]);

    //Modelos

    Route::get('modelo/index',[ModeloController::class,'index']);
    Route::post('modelo/post',[ModeloController::class,'store']);
    Route::get('modelo/get/{id}',[ModeloController::class,'show']);
    Route::put('modelo/put/{id}',[ModeloController::class,'update']);
    Route::delete('modelo/delete/{id}',[ModeloController::class,'destroy']);


    //ModeloEmpleado

    Route::get('modelo_empleado/index',[ModeloEmpleadoController::class,'index']);
    Route::post('modelo_empleado/post',[ModeloEmpleadoController::class,'store']);
    Route::get('modelo_empleado/get/{id}',[ModeloEmpleadoController::class,'show']);
    Route::put('modelo_empleado/put/{id}',[ModeloEmpleadoController::class,'update']);
    Route::delete('modelo_empleado/delete/{id}',[ModeloEmpleadoController::class,'destroy']);
    Route::get('modelo_empleado/search', [ModeloEmpleadoController::class, 'search']);
    Route::get('modelo_empleado/indexPg', [ModeloEmpleadoController::class, 'indexPg']);



    //EmpresaContratista
    Route::get('empresa_contratista/index',[EmpresaContratistaController::class,'index']);
    Route::post('empresa_contratista/post',[EmpresaContratistaController::class,'store']);
    Route::get('empresa_contratista/get/{id}',[EmpresaContratistaController::class,'show']);
    Route::put('empresa_contratista/put/{id}',[EmpresaContratistaController::class,'update']);
    Route::delete('empresa_contratista/delete/{id}',[EmpresaContratistaController::class,'destroy']);
    Route::get('empresa_contratista/indexPg',[EmpresaContratistaController::class,'indexPg']);
    Route::get('empresa_contratista/search',[EmpresaContratistaController::class,'search']);



    //Etiquetas Contratistas
    Route::get('etiquetas_contratistas/index',[EtiquetaContratistaController::class,'index']);
    Route::get('etiquetas_contratistas/last',[EtiquetaContratistaController::class,'getLastEtiqueta']);
    Route::post('etiquetas_contratistas/post',[EtiquetaContratistaController::class,'store']);
    Route::get('etiquetas_contratistas/get/{id}',[EtiquetaContratistaController::class,'show']);
    Route::put('etiquetas_contratistas/put/{id}',[EtiquetaContratistaController::class,'update']);
    Route::delete('etiquetas_contratistas/delete/{id}',[EtiquetaContratistaController::class,'destroy']);
    Route::get('etiquetas_contratistas/equipos',[EtiquetaContratistaController::class,'empresa_equipos']);
    Route::get('etiquetas_contratistas/equipos_general', [EtiquetaContratistaController::class, 'grafica_grande']);
    Route::get('etiquetas_contratistas/getByNumber/{num_etiqueta}', [EtiquetaContratistaController::class, 'getbynumer']);
    Route::get('etiquetas_contratistas/export', [EtiquetaContratistaController::class, 'export']);
    Route::get("etiquetas_contratistas/search", [EtiquetaContratistaController::class, "search"]);


    //Usuarios Penmont
    Route::get('usuarios_penmont/index',[UsuariosPenmontController::class,'index']);
    Route::post('usuarios_penmont/post',[UsuariosPenmontController::class,'store']);
    Route::get('usuarios_penmont/get/{id}',[UsuariosPenmontController::class,'show']);
    Route::put('usuarios_penmont/put/{id}',[UsuariosPenmontController::class,'update']);
    Route::delete('usuarios_penmont/delete/{id}',[UsuariosPenmontController::class,'destroy']);
    Route::get('usuarios_penmont/getByEmployeeNumber/{num_empleado}', [UsuariosPenmontController::class, 'getByEmployeeNumber']);


    //etiquetas empleados
    Route::get('etiquetas_empleados/index',[EtiquetasEmpleadosController::class,'index']);
    Route::get('etiquetas_empleados/last',[EtiquetasEmpleadosController::class,'getLastEtiqueta']);
    Route::post('etiquetas_empleados/post',[EtiquetasEmpleadosController::class,'store']);
    Route::get('etiquetas_empleados/get/{id}',[EtiquetasEmpleadosController::class,'show']);
    Route::put('etiquetas_empleados/put/{id}',[EtiquetasEmpleadosController::class,'update']);
    Route::delete('etiquetas_empleados/delete/{id}',[EtiquetasEmpleadosController::class,'destroy']);
    Route::get('etiquetas_empleados/getByNumeroEtiqueta/{numero_etiqueta}',[EtiquetasEmpleadosController::class,'getByNumeroEtiqueta']);
    Route::get('etiquetas_empleados/search',[EtiquetasEmpleadosController::class,'search']);


    //Historial
    Route::get('historial/index',[HistorialController::class,'index']);
    Route::post('historial/post',[HistorialController::class,'store']);
    Route::get('historial/get/{id}',[HistorialController::class,'show']);
    Route::put('historial/put/{id}',[HistorialController::class,'update']);
    Route::delete('historial/delete/{id}',[HistorialController::class,'destroy']);
    Route::get('historial/search',[HistorialController::class,'search']);


    //Tonner
    Route::get('tonner/index',[TonnerController::class,'index']);
    Route::post('tonner/post',[TonnerController::class,'store']);
    Route::get('tonner/get/{id}',[TonnerController::class,'show']);
    Route::put('tonner/put/{id}',[TonnerController::class,'update']);
    Route::delete('tonner/delete/{id}',[TonnerController::class,'destroy']);


    //Impresoras
    Route::get('impresoras/index',[ImpresoraController::class,'index']);
    Route::post('impresoras/post',[ImpresoraController::class,'store']);
    Route::get('impresoras/get/{id}',[ImpresoraController::class,'show']);
    Route::put('impresoras/put/{id}',[ImpresoraController::class,'update']);
    Route::delete('impresoras/delete/{id}',[ImpresoraController::class,'destroy']);


    //HistorialTonner
    Route::get('historial_tonner/index',[HistorialTonnerController::class,'index']);
    Route::post('historial_tonner/post',[HistorialTonnerController::class,'store']);
    Route::get('historial_tonner/get/{id}',[HistorialTonnerController::class,'show']);
    Route::put('historial_tonner/put/{id}',[HistorialTonnerController::class,'update']);
    Route::delete('historial_tonner/delete/{id}',[HistorialTonnerController::class,'destroy']);


    //Historial impresora
    Route::get('historial_impresoras/index',[HistorialImpresorasController::class,'index']);
    Route::post('historial_impresoras/post',[HistorialImpresorasController::class,'store']);
    Route::get('historial_impresoras/get/{id}',[HistorialImpresorasController::class,'show']);
    Route::put('historial_impresoras/put/{id}',[HistorialImpresorasController::class,'update']);
    Route::delete('historial_impresoras/delete/{id}',[HistorialImpresorasController::class,'destroy']);


    //Historial prestamo

    Route::get('historial_prestamo/index',[historial_prestamo_controller::class,'index']);
    Route::post('historial_prestamo/post',[historial_prestamo_controller::class,'store']);
    Route::get('historial_prestamo/search',[historial_prestamo_controller::class,'search']);

    //Roles
    Route::get('roles/index',[RoleController::class, 'index']);

});



