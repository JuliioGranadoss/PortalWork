<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkerController;
use App\Http\Controllers\OfferController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rutas para los usuarios
Route::get('/users', [UserController::class, 'index']); // Obtener todos los usuarios
Route::post('/users', [UserController::class, 'store']); // Crear un nuevo usuario
Route::get('/users/{id}', [UserController::class, 'edit']); // Obtener un usuario específico
Route::put('/users/{id}', [UserController::class, 'store']); // Actualizar un usuario existente
Route::delete('/users/{id}', [UserController::class, 'destroy']); // Eliminar un usuario

//Ruta para las incidencias
Route::get('/incidences', [IncidenceController::class, 'data']); // Obtener todas las incidencias
Route::post('/incidences', [IncidenceController::class, 'store']); // Crear una nueva incidencia
Route::get('/incidences/{id}', [IncidenceController::class, 'edit']); // Obtener una incidencia específica
Route::put('/incidences/{id}', [IncidenceController::class, 'store']); // Actualizar una incidencia existente
Route::delete('/incidences/{id}', [IncidenceController::class, 'destroy']); // Eliminar una incidencia

// Rutas para los trabajadores
Route::get('/workers', [WorkerController::class, 'data']); // Obtener todos los trabajadores
Route::post('/workers', [WorkerController::class, 'store']); // Crear un nuevo trabajador
Route::get('/workers/{id}', [WorkerController::class, 'edit']); // Obtener un trabajador específico
Route::put('/workers/{id}', [WorkerController::class, 'store']); // Actualizar un trabajador existente
Route::delete('/workers/{id}', [WorkerController::class, 'destroy']); // Eliminar un trabajador

// Rutas para las ofertas
Route::get('/offers', [OfferController::class, 'data']); // Obtener todas las ofertas
Route::post('/offers', [OfferController::class, 'store']); // Crear una nueva oferta
Route::get('/offers/{id}', [OfferController::class, 'edit']); // Obtener una oferta específica
Route::put('/offers/{id}', [OfferController::class, 'store']); // Actualizar una oferta existente
Route::delete('/offers/{id}', [OfferController::class, 'destroy']); // Eliminar una oferta