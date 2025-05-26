<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\MedicamentoRepositoryInterface;

class MedicamentoRepository implements MedicamentoRepositoryInterface
{
    public function obtenerTodos()
    {
        return DB::table('medicamentos')->paginate(10);
    }

    public function guardarMedicamento(array $data)
    {
        DB::table('medicamentos')->insert($data);
    }

    public function buscarMedicamento($id)
    {
        return DB::table('medicamentos')->where('id', $id)->first();
    }

    public function actualizarMedicamento(array $data, $id)
    {
        DB::table('medicamentos')->where('id', $id)->update($data);
    }

    public function eliminarMedicamento($id)
    {
        DB::table('medicamentos')->where('id', $id)->update(['estado' => 'INACTIVO']);
    }

    public function buscarPacienteArgumento($buscar)
    {
        return DB::table('medicamentos')
            ->where('estado', 'ACTIVO')
            ->where(function ($q) use ($buscar) {
                $q->where('nombre', 'like', "%$buscar%")
                  ->orWhere('nombre_laboratorio', 'like', "%$buscar%")
                  ->orWhere('concentracion', 'like', "%$buscar%");
            })
            ->orderBy('created_at','asc')
            ->paginate(10);
    }
}