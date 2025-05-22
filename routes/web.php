<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReporteController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes');
    Route::get('/reportes/pacientes', [ReporteController::class, 'reportePacientes'])->name('reportes.pacientes');
    Route::get('/reportes/medicamentos', [ReporteController::class, 'reporteMedicamentos'])->name('reportes.medicamentos');
    Route::get('/reportes/sedes', [ReporteController::class, 'reporteSedes'])->name('reportes.sedes');
    Route::get('/reportes/medicos', [ReporteController::class, 'reporteMedicos'])->name('reportes.medicos');
    Route::get('/reportes/pacientes_ciudad', [ReporteController::class, 'reportePacientesCiudad'])->name('reportes.pacientes_ciudad');
});
