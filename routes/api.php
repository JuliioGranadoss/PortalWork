<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\WorkerController;
use App\Http\Controllers\API\OfferController;
use App\Http\Controllers\API\AuthController;

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

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');

// Rutas para los trabajadores
Route::get('/workers', [WorkerController::class, 'index'])->middleware(['auth:sanctum']); // Obtener todos los trabajadores
Route::get('/workers/{id}', [WorkerController::class, 'show'])->middleware(['auth:sanctum']); // Mostrar datos de trabajador
Route::put('/workers/{id}', [WorkerController::class, 'store'])->middleware(['auth:sanctum']); // Actualizar un trabajador existente
Route::delete('/workers/{id}', [WorkerController::class, 'destroy'])->middleware(['auth:sanctum']); // Eliminar un trabajador

// Rutas para las ofertas
Route::get('/offers', [OfferController::class, 'index'])->middleware(['auth:sanctum']); // Obtener todas las ofertas
Route::get('/offers/{id}', [OfferController::class, 'show'])->middleware(['auth:sanctum']); // Obtener una oferta específica