<?php

namespace App\Repositories\Interfaces;

interface PacienteRepositoryInterface
{
    public function obtenerTodos();
    public function guardarPaciente(array $data);
    public function buscarPaciente($id);
    public function eliminarPaciente($id);
    public function actualizarPaciente(array $data, $id);
}