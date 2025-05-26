<?php

namespace App\Repositories\Interfaces;

interface SedeRepositoryInterface
{
    public function obtenerTodos();
    public function guardarSede(array $data);
    public function buscarSede($id);
    public function actualizarSede(array $data, $id);
    public function eliminarSede($id);
    public function buscarPacienteArgumento($buscar);
}