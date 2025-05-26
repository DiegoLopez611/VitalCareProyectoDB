<?php

namespace App\Repositories\Interfaces;

interface MedicamentoRepositoryInterface
{
    public function obtenerTodos();
    public function guardarMedicamento(array $data);
    public function buscarMedicamento($id);
    public function actualizarMedicamento(array $data, $id);
    public function eliminarMedicamento($id);
    public function buscarPacienteArgumento($buscar);

}