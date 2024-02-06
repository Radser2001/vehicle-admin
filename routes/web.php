<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\MakeController;
use App\Http\Controllers\ModelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehicleBankAccountController;
use App\Http\Controllers\VehicleContactBookController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\VehicleImageController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/', function () {
    return Inertia::render('Dashboard/index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// vehicles
Route::prefix('/vehicles')->group(function () {
    Route::get('/', [VehicleController::class, "index"])->name('vehicles.index');
    Route::get('/all', [VehicleController::class, "all"])->name('vehicles.all');
    Route::get('/count', [VehicleController::class, "count"])->name('vehicles.count');
    Route::get('/{vehicle_id}/get', [VehicleController::class, "get"])->name('vehicles.get');
    Route::post('/store', [VehicleController::class, "store"])->name('vehicles.store');
    Route::get('/{vehicle_id}/edit', [VehicleController::class, "edit"])->name('vehicles.edit');
    Route::post('/{vehicle_id}/vehicle/update', [VehicleController::class, "update"])->name('vehicles.update');
    Route::delete('/{vehicle_id}/delete', [VehicleController::class, "delete"])->name('vehicles.delete');
    Route::post('/select/vehicle/delete', [VehicleController::class, 'deleteSelectedItems'])->name('vehicles.delete.selected');

    Route::post('/select/vehicle/inactive', [VehicleController::class, 'inactiveSelectedItems'])->name('vehicles.inactive.selected');
    Route::post('/select/vehicle/active', [VehicleController::class, 'activeSelectedItems'])->name('vehicles.active.selected');


    Route::post('/{vehicle_id}/contact/update', [VehicleContactBookController::class, "update"])->name('vehicles.contact.update');
    Route::get('/{vehicle_id}/contact/all', [VehicleContactBookController::class, "all"])->name('vehicles.contact.all');
    Route::delete('/{vehicle_id}/contact/delete', [VehicleContactBookController::class, "delete"])->name('vehicles.contact.delete');

    Route::post('/{vehicle_id}/bank/update', [VehicleBankAccountController::class, "update"])->name('vehicles.bank.update');
    Route::get('/{vehicle_id}/bank/all', [VehicleBankAccountController::class, "all"])->name('vehicles.bank.all');
    Route::delete('/{vehicle_id}/bank/delete', [VehicleBankAccountController::class, "delete"])->name('vehicles.bank.delete');

    Route::post('/{vehicle_id}/image/update', [VehicleImageController::class, "update"])->name('vehicles.image.update');
    Route::get('/{vehicle_id}/image/all', [VehicleImageController::class, "all"])->name('vehicles.image.all');
    Route::delete('/{image_id}/image/delete', [VehicleImageController::class, "delete"])->name('vehicles.image.delete');
});


// Make Registry
Route::prefix('make')->group(function () {
    Route::get('/', [MakeController::class, "index"])->name('make.index');
    Route::get('/all', [MakeController::class, "all"])->name('make.all');
    Route::post('/store', [MakeController::class, "store"])->name('make.store');
    Route::get('/{make_id}/get', [MakeController::class, "get"])->name('make.get');
    Route::post('/{make_id}/update', [MakeController::class, "update"])->name('make.update');
    Route::delete('/{make_id}/delete', [MakeController::class, "delete"])->name('make.delete');

    Route::post('/{make_id}/select/make/delete', [MakeController::class, 'deleteSelectedItems'])->name('make.delete.selected');
    Route::post('/select/make/inactive', [MakeController::class, 'inactiveSelectedItems'])->name('make.inactive.selected');
    Route::post('/select/make/active', [MakeController::class, 'activeSelectedItems'])->name('make.active.selected');
});

// Model Registry
Route::prefix('model')->group(function () {
    Route::get('/', [ModelController::class, "index"])->name('model.index');
    Route::get('/all', [ModelController::class, "all"])->name('model.all');
    Route::post('/store', [ModelController::class, "store"])->name('model.store');
    Route::get('/{model_id}/get', [ModelController::class, "get"])->name('model.get');
    Route::post('/{model_id}/update', [ModelController::class, "update"])->name('model.update');
    Route::delete('/{model_id}/delete', [ModelController::class, "delete"])->name('model.delete');

    Route::post('/{model_id}/select/model/delete', [ModelController::class, 'deleteSelectedItems'])->name('model.delete.selected');
    Route::post('/select/model/inactive', [ModelController::class, 'inactiveSelectedItems'])->name('model.inactive.selected');
    Route::post('/select/model/active', [ModelController::class, 'activeSelectedItems'])->name('model.active.selected');
});

require __DIR__ . '/auth.php';
