<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\ChargeController;
use App\Http\Controllers\DepenseController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AttendeeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventTypeController;
use App\Http\Controllers\ImportCsvController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\EventDetailController;
use App\Http\Controllers\DetailFactureController;

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


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();
// Route::resource('admin', AdminController::class);
Route::group(['middleware' => 'auth',
],
function(){
    // Gestion de l'admin/accueil : 
    Route::resource('admin', AdminController::class);

    // Gestions eventtypes : 
    Route::resource('eventtypes', EventTypeController::class);

    // Gestion images/places :
    Route::get('places/list', [PlaceController::class, 'list'])->name('places.list');
    Route::resource('places', PlaceController::class);
    Route::resource('images', ImageController::class);

    // Gestion des participants :
    Route::resource('attendees', AttendeeController::class);

    // Gestion d'evenement : 
    Route::get('events/list', [EventController::class, 'list'])->name('events.list');
    Route::resource('events', EventController::class);

    // Gestion des details d'evenement : 
    Route::get('eventdetails/detail/{id}', [EventDetailController::class, 'detail'])->name('eventdetails.detail');
    Route::get('eventdetails/list', [EventDetailController::class, 'list'])->name('eventdetails.list');
    Route::resource('eventdetails', EventDetailController::class);

    // Gestion des statistiques
    Route::resource('statistics', StatisticController::class);
});