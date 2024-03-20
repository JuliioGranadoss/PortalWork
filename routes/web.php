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
use App\Http\Controllers\CompanyController;
use App\Http\Livewire\Calendar;
use App\Models\Config;

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

Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home');
});

Route::resource('users', UserController::class)->middleware(['role:admin|manager']);
Route::controller(UserController::class)->group(function () {
    Route::post('/users/check-email', 'checkEmail')->name('users.check_email');
    Route::get('/users/profile/data', 'profile')->name('users.profile');
    Route::post('/users/profile/store', 'profileStore')->name('users.profileStore');
});

Route::controller(AccessLogController::class)->group(function () {
    Route::get('/access-log', 'index')->name('accesslog.index');
});

Route::resource('companies', CompanyController::class)->middleware(['role:admin|manager']);
Route::controller(CompanyController::class)->group(function () {
    Route::post('/companies/get/data', 'data')->name('companies.data');
});

Route::resource('incidents', IncidentController::class)->middleware(['role:admin|manager']);
Route::resource('files', FileController::class)->middleware(['role:admin|manager']);

Route::controller(ConfigController::class)->group(function () {
    Route::get('/config', 'index')->name('config')->middleware(['role:admin|manager']);
    Route::get('/calendar', 'calendar')->name('calendar')->middleware(['role:admin|manager']);
    Route::get('/config/data', 'data')->name('config.data')->middleware(['role:admin|manager']);
    Route::post('/config/save', 'save')->name('config.save')->middleware(['role:admin|manager']);
});

Route::resource('workers', WorkerController::class)->middleware(['role:admin|manager']);

Route::resource('offers', OfferController::class)->middleware(['role:admin|manager']);