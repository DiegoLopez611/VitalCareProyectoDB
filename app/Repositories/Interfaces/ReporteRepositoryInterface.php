<?php

namespace App\Repositories\Interfaces;

interface ReporteRepositoryInterface
{
    public function pacientesPorGenero();
    public function pacientesPorCiudad();
    public function obtenerMedicamentos();
    public function sedesPorCiudad();
    public function medicosPorEspecialidad();
    public function pacientesPorGrupoSanguineoCiudad();
    public function obtenerDiagnosticos();
    public function obtenerTratamientos();
    public function atencionesProgramadasPorMedico();
    public function obtenerUsuarios();
}