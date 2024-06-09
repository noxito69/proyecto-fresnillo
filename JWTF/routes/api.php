<?php

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
use App\Http\Controllers\UsuariosPenmontController;
use GuzzleHttp\Middleware;
use App\Http\Controllers\HistorialImpresorasController;

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
    Route::post('post',[UserController::class,'store'])->middleware('authrole2');
    Route::delete('delete/{id}',[UserController::class,'destroy'])->middleware('authrole')->where('id','[0-9]+');
    Route::put('put/{id}',[UserController::class,'update'])->middleware('authrole2')->where('id','[0-9]+');



    //centro de costos
    Route::get('centro_costos/index', [CentroCostoController::class, 'index']);
    Route::post('centro_costos/post', [CentroCostoController::class, 'store']); 
    Route::get('centro_costos/get/{id}', [CentroCostoController::class, 'show']); 
    Route::put('centro_costos/put/{id}', [CentroCostoController::class, 'update']); 
    Route::delete('centro_costos/delete/{id}', [CentroCostoController::class, 'destroy']); 


    //departamentos
    Route::get('departamentos/index', [DepartamentoController::class, 'index']); 
    Route::post('departamentos/post', [DepartamentoController::class, 'store']); 
    Route::get('departamentos/get/{id}', [DepartamentoController::class, 'show']);
    Route::put('departamentos/put/{id}', [DepartamentoController::class, 'update']); 
    Route::delete('departamentos/delete/{id}', [DepartamentoController::class, 'destroy']); 




    //accesorios
    Route::get('accesorios/index', [AccesorioController::class, 'index']); 
    Route::post('accesorios/post', [AccesorioController::class, 'store']); 
    Route::get('accesorios/get/{id}', [AccesorioController::class, 'show']); 
    Route::put('accesorios/put/{id}', [AccesorioController::class, 'update']); 
    Route::delete('accesorios/delete/{id}', [AccesorioController::class, 'destroy']);
    Route::get('accesorios/getByBarCode/{codigo_barras}', [AccesorioController::class, 'getByBarCode']);
    Route::put('accesorios/updateQuantity/{codigo_barras}', [AccesorioController::class, 'updateQuantity']);
    Route::get('accesorios/getTotal', [AccesorioController::class, 'getTotal']);


 
    //anexos
    Route::get('anexos/index',[AnexoController::class,'index']);
    Route::post('anexos/post',[AnexoController::class,'store']);
    Route::get('anexos/get/{id}',[AnexoController::class,'show']);
    Route::put('anexos/put/{id}',[AnexoController::class,'update']);
    Route::delete('anexos/delete/{id}',[AnexoController::class,'destroy']);



    //EmpresaContratista
    Route::get('empresa_contratista/index',[EmpresaContratistaController::class,'index']);
    Route::post('empresa_contratista/post',[EmpresaContratistaController::class,'store']);
    Route::get('empresa_contratista/get/{id}',[EmpresaContratistaController::class,'show']);
    Route::put('empresa_contratista/put/{id}',[EmpresaContratistaController::class,'update']);
    Route::delete('empresa_contratista/delete/{id}',[EmpresaContratistaController::class,'destroy']);



    //Equipos
    Route::get('equipos/index',[EquipoController::class,'index']);
    Route::post('equipos/post',[EquipoController::class,'store']);
    Route::get('equipos/get/{id}',[EquipoController::class,'show']);
    Route::put('equipos/put/{id}',[EquipoController::class,'update']);
    Route::delete('equipos/delete/{id}',[EquipoController::class,'destroy']);
    




    //Etiquetas Contratistas
    Route::get('etiquetas_contratistas/index',[EtiquetaContratistaController::class,'index']);
    Route::post('etiquetas_contratistas/post',[EtiquetaContratistaController::class,'store']);
    Route::get('etiquetas_contratistas/get/{id}',[EtiquetaContratistaController::class,'show']);
    Route::put('etiquetas_contratistas/put/{id}',[EtiquetaContratistaController::class,'update']);
    Route::delete('etiquetas_contratistas/delete/{id}',[EtiquetaContratistaController::class,'destroy']);

    


    //Usuarios Penmont
    Route::get('usuarios_penmont/index',[UsuariosPenmontController::class,'index']);
    Route::post('usuarios_penmont/post',[UsuariosPenmontController::class,'store']);
    Route::get('usuarios_penmont/get/{id}',[UsuariosPenmontController::class,'show']);
    Route::put('usuarios_penmont/put/{id}',[UsuariosPenmontController::class,'update']);
    Route::delete('usuarios_penmont/delete/{id}',[UsuariosPenmontController::class,'destroy']);
    Route::get('usuarios_penmont/getByEmployeeNumber/{num_empleado}', [UsuariosPenmontController::class, 'getByEmployeeNumber']);



    //etiquetas empleados
    Route::get('etiquetas_empleados/index',[EtiquetasEmpleadosController::class,'index']);
    Route::post('etiquetas_empleados/post',[EtiquetasEmpleadosController::class,'store']);
    Route::get('etiquetas_empleados/get/{id}',[EtiquetasEmpleadosController::class,'show']);
    Route::put('etiquetas_empleados/put/{id}',[EtiquetasEmpleadosController::class,'update']);
    Route::delete('etiquetas_empleados/delete/{id}',[EtiquetasEmpleadosController::class,'destroy']);


    
    //Historial
    Route::get('historial/index',[HistorialController::class,'index']);
    Route::post('historial/post',[HistorialController::class,'store']);
    Route::get('historial/get/{id}',[HistorialController::class,'show']);
    Route::put('historial/put/{id}',[HistorialController::class,'update']);
    Route::delete('historial/delete/{id}',[HistorialController::class,'destroy']);



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

    
    

  
});



