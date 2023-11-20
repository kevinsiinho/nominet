<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\TipoIDController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExtrasController;
use App\Http\Controllers\SesionController;

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
Route::middleware('auth:sanctum')->group(function () {
    // Rutas para tipo de id
    // Route::middleware('role:Admin|Creador')->group(function () {
        Route::get('/tipoid', [TipoIDController::class, 'index']);
        Route::post('/tipoid', [TipoIDController::class, 'store']);
        Route::get('/tipoid/{id}', [TipoIDController::class, 'show']);
        Route::put('/tipoid/{id}', [TipoIDController::class, 'update']);


      //  Route::middleware('can:eliminar tipoid')->group(function () {
            Route::delete('/tipoid/{id}', [TipoIDController::class, 'destroy']);
        //});
   // });

    // Rutas para usuario
   // Route::middleware('role:Admin|Creador|Control')->group(function () {
        Route::get('/users', [UserController::class, 'index']);
        Route::post('/usuario', [UserController::class, 'store']);
        Route::get('/user/{id}', [UserController::class, 'show']);
        Route::put('/user/{id}', [UserController::class, 'update']);

        // Creador no tiene permiso para eliminar
     //   Route::middleware('can:eliminar user')->group(function () {
            Route::delete('/user/{id}', [UserController::class, 'destroy']);
       // });
   // });


    //Route::middleware('role:Admin|Creador|Control')->group(function () {

        Route::post('/horas-extras', [ExtrasController::class, 'store']);
        Route::get('/horas-extras-user/{id}', [ExtrasController::class, 'show']);

      //  Route::middleware('can:editar user')->group(function () {
            Route::put('/horas-extra/{id}', [ExtrasController::class, 'update']);
        //});

        //Route::middleware('can:eliminar user')->group(function () {
            Route::delete('/horas-extra/{id}', [ExtrasController::class, 'destroy']);
       // });
    //});

    // Otras rutas protegidas...
    Route::delete('/logout', [SesionController::class, 'logout']);
    Route::get('/ver-actuales', [ExtrasController::class, 'show'])->name('extras.show');
});

// Rutas públicas o sin protección pueden ir fuera del middleware
Route::post('/login', [SesionController::class, 'store']);


Route::resource('/sesion',SesionController::class);
Route::resource('/add-extras', ExtrasController::class);

