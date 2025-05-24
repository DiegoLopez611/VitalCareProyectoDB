<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\PacienteRepositoryInterface;

class PacienteRepository implements PacienteRepositoryInterface
{
    public function obtenerTodos()
    {
        return DB::table('pacientes')->paginate(10);
    }

    public function  guardarPaciente(array $data)
    {
        DB::table('pacientes')->insert($data);
    }

    public function buscarPaciente($id)
    {
        return DB::table('pacientes')->where('id', $id)->first();
    }

    public function eliminarPaciente($id)
    {
        DB::table('pacientes')->where('id', $id)->update(['estado' => 'INACTIVO']);
    }

    public function actualizarPaciente(array $data, $id)
    {
        DB::table('pacientes')
            ->where('id', $id)
            ->update($data);
    }
}