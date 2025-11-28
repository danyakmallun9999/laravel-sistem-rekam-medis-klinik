<?php

use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\QueueController;
use App\Http\Controllers\BPJSController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('patients', \App\Http\Controllers\PatientController::class);
    Route::resource('doctors', \App\Http\Controllers\DoctorController::class);
    Route::resource('medical_records', MedicalRecordController::class);

    // Pharmacy Routes
    Route::prefix('pharmacy')->name('pharmacy.')->group(function () {
        Route::get('/inventory', [PharmacyController::class, 'inventory'])->name('inventory');
        Route::get('/inventory/create', [PharmacyController::class, 'create'])->name('inventory.create');
        Route::post('/inventory', [PharmacyController::class, 'store'])->name('inventory.store');
        Route::get('/inventory/{medicine}/edit', [PharmacyController::class, 'edit'])->name('inventory.edit');
        Route::put('/inventory/{medicine}', [PharmacyController::class, 'update'])->name('inventory.update');
        Route::delete('/inventory/{medicine}', [PharmacyController::class, 'destroy'])->name('inventory.destroy');

        Route::get('/prescriptions', [PharmacyController::class, 'prescriptions'])->name('prescriptions');
        Route::get('/prescriptions/{record}', [PharmacyController::class, 'showPrescription'])->name('prescriptions.show');
        Route::post('/prescriptions/{record}/dispense', [PharmacyController::class, 'dispense'])->name('prescriptions.dispense');
    });

    // Queue Routes
    Route::resource('queues', QueueController::class)->only(['index', 'create', 'store']);
    Route::patch('/queues/{queue}/status', [QueueController::class, 'updateStatus'])->name('queues.updateStatus');

    // BPJS Mock Route
    // BPJS Mock Route
    Route::post('/bpjs/check', [BPJSController::class, 'check'])->name('bpjs.check');

    // Appointment Routes
    Route::resource('appointments', \App\Http\Controllers\AppointmentController::class);
    Route::patch('/appointments/{appointment}/status', [\App\Http\Controllers\AppointmentController::class, 'updateStatus'])->name('appointments.updateStatus');

    // Invoice Routes
    Route::resource('invoices', \App\Http\Controllers\InvoiceController::class);
    Route::patch('/invoices/{invoice}/status', [\App\Http\Controllers\InvoiceController::class, 'updateStatus'])->name('invoices.updateStatus');

    // Patient Portal Routes
    Route::prefix('portal')->name('patient.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\PatientPortalController::class, 'dashboard'])->name('dashboard');
        Route::get('/records', [\App\Http\Controllers\PatientPortalController::class, 'records'])->name('records');
        Route::get('/appointments', [\App\Http\Controllers\PatientPortalController::class, 'appointments'])->name('appointments');
        Route::get('/invoices', [\App\Http\Controllers\PatientPortalController::class, 'invoices'])->name('invoices');
    });
});

require __DIR__.'/auth.php';
