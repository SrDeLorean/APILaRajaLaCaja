<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ReferenciaController;
use App\Http\Controllers\BrindiController;
use App\Http\Controllers\PasatiempoController;
use App\Http\Controllers\EstadoController;
use App\Http\Controllers\TipoController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\DetalleTicketController;
use App\Http\Controllers\MascotaController;
use App\Http\Controllers\PreferenciaController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [AuthController::class, "login"]);
    Route::post('logout', [AuthController::class, "logout"]);
    Route::post('refresh', [AuthController::class, "refresh"]);
    Route::get('me', [AuthController::class, "me"]);
});

Route::resource('menus', MenuController::class);
Route::resource('restaurantes', RestauranteController::class);

Route::resource('productos', ProductoController::class);
Route::resource('categorias', CategoriaController::class);
Route::resource('referencias', ReferenciaController::class);
Route::resource('brindis', BrindiController::class);
Route::resource('pasatiempos', PasatiempoController::class);
Route::resource('estados', EstadoController::class);
Route::resource('tipos', TipoController::class);
Route::resource('tickets', TicketController::class);
Route::resource('detalleticket', DetalleTicketController::class);
Route::resource('mascotas', MascotaController::class);
Route::resource('preferencias', PreferenciaController::class);
