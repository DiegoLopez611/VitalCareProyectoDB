<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\MedicoRepositoryInterface;

class MedicoRepository implements MedicoRepositoryInterface
{
    public function obtenerInformacionCompletaTodos()
    {
        return DB::table('medicos as m')
            ->join('usuarios as u','m.cedula','=','u.cedula')
            ->select([
                'm.id',
                'm.cedula',
                'u.nombre',
                'u.apellido',
                'u.fecha_nacimiento',
                'u.email',
                'm.numero_licencia_medica as licencia_medica',
                'm.fecha_inicio_laboral as fecha_inicio',
                'm.estado'
            ])
            ->paginate(10);
    }

    public function guardarMedico(array $data)
    {
        DB::table('medicos')->insert($data);
    }

    public function buscarMedico($id)
    {
        return DB::table('medicos')->where('id', $id)->first();
    }

    public function actualizarMedico(array $data, $cedula)
    {
        DB::table('medicos')
            ->where('cedula', $cedula)
            ->update($data);
    }

    public function eliminarMedico($id)
    {
        DB::table('medicos')->where('id', $id)->update(['estado' => 'INACTIVO']);
    }

    public function buscarPacienteArgumento($buscar)
    {
        return DB::table('medicos as m')
            ->join('usuarios as u','m.cedula','=','u.cedula')
            ->select([
                'm.id',
                'm.cedula',
                'u.nombre',
                'u.apellido',
                'u.fecha_nacimiento',
                'u.email',
                'm.numero_licencia_medica as licencia_medica',
                'm.estado'
            ])
            ->where('m.estado', 'ACTIVO')
            ->where(function ($q) use ($buscar) {
                $q->where('m.cedula', 'like', "%$buscar%")
                  ->orWhere('u.nombre', 'like', "%$buscar%")
                  ->orWhere('u.apellido', 'like', "%$buscar%")
                  ->orWhere('u.email', 'like', "%$buscar%");
            })
            ->orderBy('u.apellido')
            ->paginate(10);
    }
}