<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PsicologoController;
use App\Http\Controllers\NotificationController;
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

    Route::get('/patient/{patients_id}', [PatientController::class, 'index2'])->name('patient.index2')->middleware('role:patient');

    Route::get('/psychologist/{psicologo_id}', [PsicologoController::class, 'index2'])->name('psychologist.index2')->middleware('role:psicologo');
});

require __DIR__.'/auth.php';

// Route::view('/login', 'auth.login')->name('login');

Route::post('/send-email', [ContactController::class, 'sendEmail']);

Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');

Route::get('/consultas', [AppointmentController::class, 'index'])->name('consultas.index');

Route::get('/consultas-agendadas/{id}', function () {
    return inertia('ConsultasAgendadas');
})->name('appointments')->middleware('role:patient');

Route::get('/appointments-create/{id}', function () {
    return inertia('AgendarConsultas');
})->name('appointments.create')->middleware('role:patient');

Route::post('/patients', [PatientController::class, 'store'])->middleware(['auth', 'role:secretaria'])->name('patients.store');

Route::get('/create-patient', function () {
    return Inertia::render('CreatePatient');
})->middleware(['auth', 'role:secretaria'])->name('create.patient');

Route::post('/psicologo', [PsicologoController::class, 'store'])->middleware(['auth', 'role:secretaria'])->name('psicologo.store');

Route::get('/create-psicologo', function () {
    return Inertia::render('CreatePsicologo');
})->middleware(['auth', 'role:secretaria'])->name('create.psicologo');

Route::get('/api/psicologos', [PsicologoController::class, 'index']);

Route::get('/avisar-psicologo', function () {
    return Inertia::render('AvisarPsicologo');
})->middleware(['auth', 'role:secretaria'])->name('avisar.psicologo');

Route::get('/historico/{id}', function () {
    return inertia('HistoricoConsultas');
})->name('appointments')->middleware('role:patient');

Route::post('/notifications', [NotificationController::class, 'notifyPsicologo']);

Route::get('/notifications/{psicologo_id}', [NotificationController::class, 'getNotifications']);

Route::post('/notifications/read/{notification_id}', [NotificationController::class, 'markAsRead']);

// Rotas para atualização de pacientes
Route::put('/patients-update/{id}', [PatientController::class, 'update']);

Route::get('/patient-view', function () {
    return inertia('PatientList');
})->name('patient.list')->middleware('role:psicologo');

Route::get('/api/patients', [PatientController::class, 'index'])->name('patients.index');

Route::get('/patient/{id}', [PatientController::class, 'show']);

Route::get('/patients/{id}/info', [PatientController::class, 'showPatient']);

Route::get('/patient-edit/{patientId}', function () {
    return inertia('PatientEdit');
})->name('patient.edit')->middleware('role:psicologo');

Route::get('/patient-detail/{patientsId}', function () {
    return inertia('PatientDetail');
})->name('patient.detail')->middleware('role:psicologo');

Route::put('appointments/{id}/note', [AppointmentController::class, 'updateNote']);

Route::get('/patients/{id}/sessions', [AppointmentController::class, 'patientSessions']);