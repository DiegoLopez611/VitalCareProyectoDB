<?php

namespace App\Repositories\Interfaces;

interface MedicoRepositoryInterface
{
    public function obtenerInformacionCompletaTodos();
    public function guardarMedico(array $data);
    public function buscarMedico($id);
    public function actualizarMedico(array $data, $cedula);
    public function eliminarMedico($id);
    public function buscarPacienteArgumento($buscar);
}