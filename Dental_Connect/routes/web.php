<?php

use App\Http\Controllers\Appointment\ShowController;
use App\Http\Controllers\Dentist\DentistController;
use App\Http\Controllers\Dentist\EditController;
use App\Http\Controllers\Dentist\UpdateController;
use App\Http\Controllers\Order\CreateController;
use App\Http\Controllers\Order\StoreController;
use App\Http\Controllers\Appointment\StoreController as AppointmentStoreController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dentist\IndexController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['dentist'])->group(function () {
    Route::get('/dentist', IndexController::class)->name('dentist.index');
    Route::patch('/dentist/orders/{order}/toggle', [App\Http\Controllers\Dentist\ToggleStatusController::class, '__invoke'])
        ->name('dentist.orders.toggle');

    Route::get('/dentist/edit', EditController::class)->name('dentist.edit');
    Route::patch('/dentist/update', UpdateController::class)->name('dentist.update');

    Route::post('/dentist/appointments', AppointmentStoreController::class)->name('dentist.appointment.store');

    Route::get('/appointments', ShowController::class)->name('appointment.show');
});

Route::get('/dentists', [DentistController::class, 'index'])->name('dentist.dentists');


Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', CreateController::class)->name('order.create');
Route::post('/order', StoreController::class)->name('order.store');

