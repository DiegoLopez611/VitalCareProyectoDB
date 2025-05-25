<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\ReporteRepositoryInterface;

class ReporteRepository implements ReporteRepositoryInterface
{
    public function pacientesPorGenero()
    {
        return DB::table('pacientes as p')
                ->leftJoin('generos as g', 'p.id_genero', '=', 'g.id')
                ->select([
                    'p.id',
                    'p.cedula',
                    'p.primer_nombre',
                    'p.segundo_nombre',
                    'p.primer_apellido',
                    'p.segundo_apellido',
                    'p.email',
                    'p.direccion',
                    'p.fecha_nacimiento',
                    'p.created_at',
                    'p.updated_at',
                    'g.nombre as genero' // Nombre del género
                ])
                ->orderBy('p.created_at', 'desc')
                ->get();
    }

    public function obtenerMedicamentos()
    {
        return DB::table('medicamentos')
                ->select([
                    'nombre',
                    'nombre_laboratorio',
                    'concentracion',
                    'id',
                    'created_at'
                ])
                ->orderBy('created_at', 'desc')
                ->get();
    }

    public function sedesPorCiudad()
    {
        return DB::table('sedes as s')
                ->leftJoin('ciudades as c', 's.id_ciudad','=','c.id')
                ->select([
                    's.nombre',
                    's.direccion',
                    's.telefono',
                    's.id',
                    's.created_at',
                    'c.nombre as ciudad'
                ])
                ->orderBy('created_at', 'desc')
                ->get();
    }

    public function medicosPorEspecialidad()
    {
        return DB::table('medicos as m')
                ->join('usuarios as u', 'm.id','=','u.id')
                ->join('especialidades as e', 'm.id_especialidad','=','e.id')
                ->select([
                    'u.nombre as nombre',
                    'u.apellido as apellido',
                    'm.cedula',
                    'm.numero_licencia_medica',
                    'e.nombre as especialidad',
                    'm.created_at'
                ])
                ->orderBy('created_at', 'desc')
                ->get();
    }

    public function pacientesPorCiudad()
    {
        return DB::table('pacientes as p')
                ->join('ciudades as c', 'p.id_ciudad', '=', 'c.id')
                ->select([
                    'p.primer_nombre',
                    'p.segundo_nombre',
                    'p.primer_apellido',
                    'p.segundo_apellido',
                    'p.cedula',
                    'c.nombre as ciudad',
                    'p.created_at'
                ])
                ->orderBy('c.nombre', 'asc')
                ->orderBy('p.created_at', 'desc')
                ->get();
    }

    public function pacientesPorGrupoSanguineoCiudad()
    {
        return DB::table('pacientes as p')
            ->leftJoin('ciudades as c', 'p.id_ciudad', '=', 'c.id')
            ->leftJoin('grupos_sanguineos as gs', 'p.id_grupo_sanguineo', '=', 'gs.id')
            ->select([
                'p.id',
                'p.cedula',
                'p.primer_nombre',
                'p.segundo_nombre',
                'p.primer_apellido',
                'p.segundo_apellido',
                'p.email',
                'p.fecha_nacimiento',
                'p.created_at',
                'c.nombre as ciudad',
                'gs.nombre as tipo_sangre'
            ])
            ->orderBy('c.nombre')
            ->orderBy('gs.nombre')
            ->orderBy('p.primer_apellido')
            ->get();
    }

    public function obtenerDiagnosticos()
    {
        return DB::table('diagnosticos')
                ->select([
                    'nombre',
                    'descripcion',
                    'id',
                    'created_at'
                ])
                ->orderBy('created_at', 'desc')
                ->get();
    }
}