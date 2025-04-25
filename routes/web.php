<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\RenewalController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [RenewalController::class, 'index'])->middleware(['auth'])->name('dashboard');

    Route::resource('clients', ClientController::class);
    Route::prefix('clients/{client}')->group(function () {
        Route::resource('registrations', RegistrationController::class);
        Route::resource('tasks', TaskController::class);
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/renewals', [RenewalController::class, 'index'])->name('renewals.index');
    Route::post('/renewals/{task}/send-reminder', [RenewalController::class, 'sendReminder'])->name('renewals.sendReminder');
    Route::post('/renewals/{task}/generate-whatsapp', [RenewalController::class, 'generateWhatsapp'])->name('renewals.generateWhatsapp');
    Route::post('/renewals/{task}/update-status', [RenewalController::class, 'updateStatus'])->name('renewals.updateStatus');

    Route::get('/clients/{client}/pdf', [ClientController::class, 'generatePDF'])->name('clients.pdf');
});


//Route::domain('{client}.yourdomain.test')->group(function () {
//    Route::middleware(['web', 'identify.tenant'])->group(function () {
//        Route::get('/', function () {
//            return view('dashboard');
//        })->name('dashboard');
//
//        Route::resource('clients', App\Http\Controllers\ClientController::class);
//        Route::resource('registrations', App\Http\Controllers\RegistrationController::class);
//        Route::resource('tasks', App\Http\Controllers\TaskController::class);
//    });
//});


require __DIR__.'/auth.php';
