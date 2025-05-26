<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\MedicamentoController;
use App\Http\Controllers\SedeController;

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
    
    Route::resource('pacientes', PacienteController::class);
    Route::resource('medicos', MedicoController::class);
    Route::resource('medicamentos', MedicamentoController::class);
    Route::resource('sedes', SedeController::class);

    Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes');
    Route::get('/reportes/pacientes', [ReporteController::class, 'reportePacientes'])->name('reportes.pacientes');
    Route::get('/reportes/medicamentos', [ReporteController::class, 'reporteMedicamentos'])->name('reportes.medicamentos');
    Route::get('/reportes/sedes', [ReporteController::class, 'reporteSedes'])->name('reportes.sedes');
    Route::get('/reportes/medicos', [ReporteController::class, 'reporteMedicos'])->name('reportes.medicos');
    Route::get('/reportes/pacientes_ciudad', [ReporteController::class, 'reportePacientesCiudad'])->name('reportes.pacientes_ciudad');
    Route::get('/reportes/pacientes_grupo_sanguineo', [ReporteController::class, 'reportePacientesGrupoSanguineo'])->name('reportes.pacientes_grupo_sanguineo');
    Route::get('/reportes/diagnosticos', [ReporteController::class, 'reporteDiagnosticos'])->name('reportes.diagnosticos');
    Route::get('/reportes/tratamientos', [ReporteController::class, 'reporteTratamientos'])->name('reportes.tratamientos');
    Route::get('/reportes/atenciones_programadas', [ReporteController::class, 'reporteAtencionesProgramadas'])->name('reportes.atenciones_programadas');
    Route::get('/reportes/usuarios', [ReporteController::class, 'reporteUsuarios'])->name('reportes.usuarios');


});
