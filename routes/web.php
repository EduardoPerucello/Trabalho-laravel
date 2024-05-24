<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PatientController;
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

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->middleware('role:secretaria')->name('dashboard');

    Route::get('/patient', function () {
        return Inertia::render('Patient');
    })->name('patient')->middleware('role:patient');

    Route::get('/psychologist', function () {
        return Inertia::render('Psychologist');
    })->name('psychologist')->middleware('role:psicologo');
});


require __DIR__.'/auth.php';

Route::view('/login', 'auth.login')->name('login');

Route::post('/send-email', [ContactController::class, 'sendEmail']);

Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');

Route::get('/appointments-create', function () {
    return inertia('AgendarConsultas');
})->name('appointments.create')->middleware('role:patient');

Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');

Route::post('/patients', [PatientController::class, 'store'])->middleware(['auth', 'role:secretaria'])->name('patients.store');

Route::get('/create-patient', function () {
    return Inertia::render('CreatePatient');
})->middleware(['auth', 'role:secretaria'])->name('create.patient');



