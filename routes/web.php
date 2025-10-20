<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GestorController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\Auth\ClienteLoginController;
use App\Http\Controllers\Auth\GestorLoginController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Auth\RegisterClienteController;
use App\Http\Controllers\Auth\RegisterGestorController;

/*
|--------------------------------------------------------------------------
| Redirecionamento da raiz "/"
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $user = Auth::user();

    if ($user) {
        // 👉 Agora redireciona direto para a lista de consultas
        if ($user->role === 'gestor') {
            return redirect()->route('gestor.appointments.index');
        }
        return redirect()->route('appointments.index');
    }

    return redirect()->route('login.cliente');
})->name('login');

/*
|--------------------------------------------------------------------------
| Login do Cliente
|--------------------------------------------------------------------------
*/
Route::get('/login/cliente', [ClienteLoginController::class, 'showLoginForm'])
    ->name('login.cliente');
Route::post('/login/cliente', [ClienteLoginController::class, 'login']);
Route::post('/logout/cliente', [ClienteLoginController::class, 'logout'])
    ->name('logout.cliente');

/*
|--------------------------------------------------------------------------
| Login do Gestor
|--------------------------------------------------------------------------
*/
Route::get('/login/gestor', [GestorLoginController::class, 'showLoginForm'])
    ->name('login.gestor');
Route::post('/login/gestor', [GestorLoginController::class, 'login']);
Route::post('/logout/gestor', [GestorLoginController::class, 'logout'])
    ->name('logout.gestor');

    // Registro do Cliente
Route::get('/register/cliente', [RegisterClienteController::class, 'showForm'])->name('register.cliente');
Route::post('/register/cliente', [RegisterClienteController::class, 'register']);

// Registro do Gestor
Route::get('/register/gestor', [RegisterGestorController::class, 'showForm'])->name('register.gestor');
Route::post('/register/gestor', [RegisterGestorController::class, 'register']);
/*
|--------------------------------------------------------------------------
| Perfil do usuário
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Área do Gestor (Médico)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'gestor'])->group(function () {
    // 👉 Gestor cai direto aqui
    Route::get('/gestor/consultas', [AppointmentController::class, 'index'])
        ->name('gestor.appointments.index');

    Route::patch('/gestor/consultas/{appointment}', [AppointmentController::class, 'update'])
        ->name('gestor.appointments.update');

    // Diagnóstico
    Route::get('/gestor/consultas/{appointment}/diagnostico', [DiagnosisController::class, 'create'])
        ->name('diagnoses.create');
    Route::post('/gestor/consultas/{appointment}/diagnostico', [DiagnosisController::class, 'store'])
        ->name('diagnoses.store');

    // Relatórios
    Route::get('/gestor/relatorios/consultas-por-paciente', [ReportController::class, 'consultationsByPatient'])
        ->name('reports.consultations_by_patient');
});

/*
|--------------------------------------------------------------------------
| Área do Cliente (Paciente)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'cliente'])->group(function () {
    // 👉 Cliente cai direto aqui
    Route::get('/cliente/consultas', [AppointmentController::class, 'index'])
        ->name('appointments.index');
    Route::get('/cliente/consultas/nova', [AppointmentController::class, 'create'])
        ->name('appointments.create');
    Route::post('/cliente/consultas', [AppointmentController::class, 'store'])
        ->name('appointments.store');
});

require __DIR__.'/auth.php';
