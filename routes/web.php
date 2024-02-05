<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehicleBankAccountController;
use App\Http\Controllers\VehicleContactBookController;
use App\Http\Controllers\VehicleController;
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


Route::prefix('/vehicles')->group(function () {
    Route::get('/', [VehicleController::class, "index"])->name('vehicles.index');
    Route::get('/all', [VehicleController::class, "all"])->name('vehicles.all');
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

    // Route::post('/{vehicle_id}/finance/update', [VehicleFinanceRecordController::class, "update"])->name('vehicles.finance.update');
    // Route::get('/{vehicle_id}/finance/get', [VehicleFinanceRecordController::class, "get"])->name('vehicles.finance.get');

    // Route::post('/{vehicle_id}/partner/update', [VehiclePartnerAccountController::class, "update"])->name('vehicles.partner.update');
    // Route::get('/{vehicle_id}/partner/all', [VehiclePartnerAccountController::class, "all"])->name('vehicles.partner.all');
    // Route::delete('/{vehicle_id}/partner/delete', [VehiclePartnerAccountController::class, "delete"])->name('vehicles.partner.delete');


});


require __DIR__ . '/auth.php';
