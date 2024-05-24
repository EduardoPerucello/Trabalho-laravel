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

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';

Route::view('/login', 'auth.login')->name('login');

Route::view('/register', 'auth.register')->name('register');

Route::post('/send-email', [ContactController::class, 'sendEmail']);

Route::get('/appointments', [AppointmentController::class, 'index']);

Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');

Route::post('/patients', [PatientController::class, 'store'])->middleware(['auth', 'role:secretaria'])->name('patients.store');

Route::get('/create-patient', function () {
    return Inertia::render('CreatePatient');
})->middleware(['auth', 'role:secretaria'])->name('create.patient');

