<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\WorkerController;
use App\Http\Controllers\API\OfferController;
use App\Http\Controllers\API\DegreeController;
use App\Http\Controllers\API\ExperienceController;
use App\Http\Controllers\API\JobController;
use App\Http\Controllers\API\OtherController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\FileController;

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

// Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');

// Rutas para los trabajadores
Route::get('/workers', [WorkerController::class, 'index'])->middleware(['auth:sanctum']); // Obtener todos los trabajadores
Route::get('/workers/{id}', [WorkerController::class, 'show'])->middleware(['auth:sanctum']); // Mostrar datos de trabajador
Route::put('/workers/{id}', [WorkerController::class, 'store'])->middleware(['auth:sanctum']); // Actualizar un trabajador existente
Route::delete('/workers/{id}', [WorkerController::class, 'destroy'])->middleware(['auth:sanctum']); // Eliminar un trabajador
Route::post('/workers/{worker_id}/assign-offer/{offer_id}', [WorkerController::class, 'assignOffer'])->middleware(['auth:sanctum']); // Asignar una oferta a un trabajador
Route::delete('/workers/{worker_id}/detach-offer/{offer_id}', [WorkerController::class, 'detachOffer'])->middleware(['auth:sanctum']); // Desvincular una oferta de un trabajador

// Rutas para las fotos de perfil de los trabajadores
Route::post('/workers/{id}/profile-photo', [WorkerController::class, 'updateOrAddProfilePhoto'])->middleware(['auth:sanctum']); // Actualizar o añadir la foto de perfil a un trabajador

// Rutas para las ofertas
Route::get('/offers', [OfferController::class, 'index'])->middleware(['auth:sanctum']); // Obtener todas las ofertas
Route::get('/offers/{id}', [OfferController::class, 'show'])->middleware(['auth:sanctum']); // Obtener una oferta específica

Route::resource('/degrees', DegreeController::class)->middleware(['auth:sanctum']); // Rutas para los títulos
Route::resource('/experiences', ExperienceController::class)->middleware(['auth:sanctum']); // Rutas para las experiencias
Route::resource('/others', OtherController::class)->middleware(['auth:sanctum']); // Rutas para las habilidades
//Route::resource('/jobs', JobController::class)->middleware(['auth:sanctum']); // Rutas para los trabajos
