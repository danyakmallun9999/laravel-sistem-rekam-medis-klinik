<?php

use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\QueueController;
use App\Http\Controllers\BPJSController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'role:admin|doctor|nurse|pharmacist|front_office'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User Management
    Route::group(['middleware' => ['role:admin']], function () {
        Route::resource('users', \App\Http\Controllers\UserController::class);
    });

    Route::post('patients/{patient}/create-account', [\App\Http\Controllers\PatientController::class, 'createAccount'])->name('patients.create-account');
    Route::resource('patients', \App\Http\Controllers\PatientController::class);
    Route::resource('doctors', \App\Http\Controllers\DoctorController::class);
    Route::group(['middleware' => ['role:admin|doctor|front_office']], function () {
        Route::resource('schedules', \App\Http\Controllers\ScheduleController::class);
    });
    Route::resource('medical_records', MedicalRecordController::class);

    // Patient Flow Routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/flow/screening', [\App\Http\Controllers\PatientFlowController::class, 'screening'])->name('flow.screening')->middleware('role:nurse');
        Route::get('/screening/{appointment}', [\App\Http\Controllers\ScreeningController::class, 'create'])->name('screening.create')->middleware('role:nurse');
        Route::post('/screening/{appointment}', [\App\Http\Controllers\ScreeningController::class, 'store'])->name('screening.store')->middleware('role:nurse');
        Route::get('/flow/consultation', [\App\Http\Controllers\PatientFlowController::class, 'consultation'])->name('flow.consultation')->middleware('role:doctor');
        Route::get('/flow/pharmacy', [\App\Http\Controllers\PatientFlowController::class, 'pharmacy'])->name('flow.pharmacy')->middleware('role:pharmacist');
        Route::get('/flow/cashier', [\App\Http\Controllers\PatientFlowController::class, 'cashier'])->name('flow.cashier')->middleware('role:front_office|admin'); // Assuming cashier is front office or admin
        Route::patch('/flow/appointments/{appointment}/status', [\App\Http\Controllers\PatientFlowController::class, 'updateStatus'])->name('flow.update-status');
    });

    // Pharmacy Routes
    Route::prefix('pharmacy')->name('pharmacy.')->group(function () {
        Route::get('/', [PharmacyController::class, 'prescriptions'])->name('prescriptions');
        
        Route::get('/inventory', [PharmacyController::class, 'inventory'])->name('inventory');
        Route::get('/inventory/create', [PharmacyController::class, 'create'])->name('inventory.create');
        Route::post('/inventory', [PharmacyController::class, 'store'])->name('inventory.store');
        Route::get('/inventory/{medicine}/edit', [PharmacyController::class, 'edit'])->name('inventory.edit');
        Route::put('/inventory/{medicine}', [PharmacyController::class, 'update'])->name('inventory.update');
        Route::delete('/inventory/{medicine}', [PharmacyController::class, 'destroy'])->name('inventory.destroy');

        Route::get('/prescriptions/{record}', [PharmacyController::class, 'showPrescription'])->name('prescriptions.show');
        Route::post('/prescriptions/{record}/dispense', [PharmacyController::class, 'dispense'])->name('prescriptions.dispense');
    });

    // Queue Routes
    Route::get('/queues/display', [\App\Http\Controllers\QueueController::class, 'display'])->name('queues.display');
    Route::resource('queues', QueueController::class)->only(['index', 'create', 'store', 'destroy']);
    Route::patch('/queues/{queue}/status', [QueueController::class, 'updateStatus'])->name('queues.updateStatus');

    // BPJS Mock Route
    // BPJS Mock Route
    Route::post('/bpjs/check', [BPJSController::class, 'check'])->name('bpjs.check');

    // Appointment Routes
    Route::get('/appointments/doctors-slots', [\App\Http\Controllers\AppointmentController::class, 'getDoctorSlots'])->name('appointments.slots');
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

    // Lab Routes
    Route::prefix('lab')->name('lab.')->group(function () {
        Route::get('/', [\App\Http\Controllers\LabController::class, 'index'])->name('index');
        Route::get('/create/{record}', [\App\Http\Controllers\LabController::class, 'create'])->name('create');
        Route::post('/store/{record}', [\App\Http\Controllers\LabController::class, 'store'])->name('store');
    });
});

require __DIR__.'/auth.php';
