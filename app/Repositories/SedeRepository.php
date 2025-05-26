<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\SedeRepositoryInterface;

class SedeRepository implements SedeRepositoryInterface
{
    public function obtenerTodos()
    {
        return DB::table('sedes')->paginate(10);
    }

    public function guardarSede(array $data)
    {
        DB::table('sedes')->insert($data);
    }

    public function buscarSede($id)
    {
        return DB::table('sedes')->where('id', $id)->first();
    }

    public function actualizarSede(array $data, $id)
    {
        DB::table('sedes')->where('id', $id)->update($data);
    }

    public function eliminarSede($id)
    {
        DB::table('sedes')->where('id', $id)->update(['estado' => 'INACTIVO']);
    }

    public function buscarPacienteArgumento($buscar)
    {
        return DB::table('sedes')
            ->where('estado', 'ACTIVO')
            ->where(function ($q) use ($buscar) {
                $q->where('nombre', 'like', "%$buscar%")
                  ->orWhere('direccion', 'like', "%$buscar%");
            })
            ->orderBy('created_at', 'asc')
            ->paginate(10);
    }
}