<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\IncidentController;
use App\Http\Controllers\WorkerController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\AccessLogController;
use App\Http\Controllers\BarcodeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DegreeController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\OtherController;
use App\Http\Controllers\WorkerOfferController;
use App\Http\Controllers\CategoryProductController;
use Livewire\Livewire;
use App\Http\Livewire\Calendar;
use App\Models\Config;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\StockHistoryController;

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

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
]);

Route::get('/dynamic-styles', function () {
    $primaryColor = Config::where('key','theme_color')->first()->value ?? '#5a5c69';

    $content = "
        :root {
            --theme_color: {$primaryColor};
        }
    ";

    return response($content)->header('Content-Type', 'text/css');
});

Livewire::component('calendar', Calendar::class);

Route::get('/', [WorkerController::class, 'index'])->name('home')->middleware(['role:admin|manager']);

Route::resource('users', UserController::class)->middleware(['role:admin|manager']);
Route::controller(UserController::class)->group(function () {
    Route::post('/users/check-email', 'checkEmail')->name('users.check_email');
    Route::get('/users/profile/data', 'profile')->name('users.profile');
    Route::post('/users/profile/store', 'profileStore')->name('users.profileStore');
});

Route::controller(AccessLogController::class)->group(function () {
    Route::get('/access-log', 'index')->name('accesslog.index');
});

Route::resource('incidents', IncidentController::class)->middleware(['role:admin|manager']);
Route::resource('files', FileController::class)->middleware(['role:admin|manager']);

Route::controller(ConfigController::class)->group(function () {
    Route::get('/config', 'index')->name('config')->middleware(['role:admin|manager']);
    Route::get('/calendar', 'calendar')->name('calendar')->middleware(['role:admin|manager']);
    Route::get('/config/data', 'data')->name('config.data')->middleware(['role:admin|manager']);
    Route::post('/config/save', 'save')->name('config.save')->middleware(['role:admin|manager']);
});

// Ruta para trabajadores
Route::resource('workers', WorkerController::class)->middleware(['role:admin|manager']);

// Ruta para ofertas de trabajo
Route::resource('offers', OfferController::class)->middleware(['role:admin|manager']);

// Ruta para los títulos
Route::resource('degrees', DegreeController::class)->except(['index'])->middleware(['role:admin|manager']);
Route::controller(DegreeController::class)->group(function () {
    Route::get('/degrees/{id}/index', 'index')->name('degrees.index');
})->middleware(['role:admin|manager']);

// Ruta para las experiencias
Route::resource('experiencies', ExperienceController::class)->except(['index'])->middleware(['role:admin|manager']);
Route::controller(ExperienceController::class)->group(function () {
    Route::get('/experiencies/{id}/index', 'index')->name('experiencies.index');
})->middleware(['role:admin|manager']);

// Ruta para las otras formaciones
Route::resource('others', OtherController::class)->except(['index'])->middleware(['role:admin|manager']);
Route::controller(OtherController::class)->group(function () {
    Route::get('/others/{id}/index', 'index')->name('others.index');
})->middleware(['role:admin|manager']);

// Ruta para los trabajos
Route::resource('jobs', JobController::class)->except(['index'])->middleware(['role:admin|manager']);
Route::controller(JobController::class)->group(function () {
    Route::get('/jobs/{id}/index', 'index')->name('jobs.index');
})->middleware(['role:admin|manager']);

// Ruta para las ofertas de trabajo asociadas a un trabajador
Route::resource('workeroffers', WorkerOfferController::class)->except(['destroy'])->middleware(['role:admin|manager']);
Route::controller(WorkerOfferController::class)->group(function () {
    Route::get('/workeroffers/{id}/offers', 'offers')->name('workeroffers.offers');
    Route::get('/workeroffers/{id}/available-offers', 'availableOffers')->name('workeroffers.available-offers');
    Route::delete('/workeroffers/{worker_id}/{offer_id}/destroy', 'destroy')->name('workeroffers.destroy');
})->middleware(['role:admin|manager']);

// Ruta para enviar credenciales por email
Route::get('/email/{id}', [WorkerController::class, 'sendCredentials'])->name('email.sendCredentials');

// Rutas para la vista de ofertas de trabajo asociadas a un trabajador
Route::get('/workers/{id}/offers', [WorkerController::class, 'offers'])->name('workers.offers')->middleware(['role:admin|manager']);

// Ruta para los proveedores
Route::resource('providers', ProviderController::class)->middleware(['role:admin|manager']);
Route::controller(ProviderController::class)->group(function () {
    Route::get('/providers/get/data', 'data')->name('providers.data');
})->middleware(['role:admin|manager']);

//Ruta para los proveedores
Route::resource('providers', ProviderController::class)->middleware(['role:admin|manager']);

// Ruta para las categorías
Route::resource('categories', CategoryController::class)->middleware(['role:admin|manager']);

// Ruta para los productos
Route::resource('products', ProductController::class)->middleware(['role:admin|manager']);

// Ruta para los historiales
Route::resource('stockhistories', StockHistoryController::class)->middleware(['role:admin|manager']);

// Ruta para los códigos de barras
Route::resource('barcodes', BarcodeController::class)->middleware(['role:admin|manager']);

// Ruta para las categorías de productos
Route::resource('categoryproducts', CategoryProductController::class)->except(['destroy','index'])->middleware(['role:admin|manager']);

Route::controller(CategoryProductController::class)->group(function () {
    Route::get('/categoryproducts/{id}/index', 'index')->name('categoryproducts.index');
    Route::get('/categoryproducts/{id}/categories', 'categories')->name('categoryproducts.categories');
    Route::get('/categoryproducts/{id}/available-categories', 'availableCategories')->name('categoryproducts.available-categories');
    Route::delete('/categoryproducts/{product_id}/{category_id}/destroy', 'destroy')->name('categoryproducts.destroy');
})->middleware(['role:admin|manager']);


Route::resource('barcodes', BarcodeController::class)->except(['index'])->middleware(['role:admin|manager']);
Route::controller(BarcodeController::class)->group(function () {
    Route::get('/barcodes/{id}/index', 'index')->name('barcodes.index');
})->middleware(['role:admin|manager']);