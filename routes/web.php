<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ExtrasController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SesionController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/sesion',SesionController::class);

Route::resource('/add-extras', ExtrasController::class);


// Rutas protegidas por el middleware 'auth'
Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [SesionController::class, 'logout'])->name('sesion.logout');
    Route::get('/ver-actuales', [ExtrasController::class, 'show'])->name('extras.show');
    Route::resource('/home', HomeController::class);
});

Auth::routes();


