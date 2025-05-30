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
                ->orderBy('p.created_at', 'asc')
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
                ->orderBy('created_at', 'asc')
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
                ->orderBy('created_at', 'asc')
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
                ->orderBy('created_at', 'asc')
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
                ->orderBy('p.created_at', 'asc')
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
                ->orderBy('created_at', 'asc')
                ->get();
    }

    public function obtenerTratamientos()
    {
        return DB::table('tratamientos as t')
            ->join('tipos_tratamientos as tt', 't.id_tipo_tratamiento', '=', 'tt.id')
            ->select([
                't.id',
                't.nombre',
                't.created_at',
                'tt.nombre as tipo_tratamiento'
            ])
            ->orderBy('t.created_at', 'asc')
            ->get();
    }

    public function atencionesProgramadasPorMedico()
    {
        return DB::table('atenciones as a')
            ->join('medicos as m', 'a.id_medico', '=', 'm.id')
            ->join('pacientes as p', 'a.id_paciente', '=', 'p.id')
            ->join('estados_atencion as ea', 'a.id_estado_atencion', '=', 'ea.id')
            ->join('especialidades as esp', 'a.id_especialidad', '=', 'esp.id')
            ->join('usuarios as u', 'm.cedula', '=', 'u.cedula')
            ->select([
                
                //datos de la atencion
                'a.id',
                'u.nombre as medico_nombres',
                'u.apellido as medico_apellidos',

                'p.primer_nombre as paciente_primer_nombre',
                'p.segundo_nombre as paciente_segundo_nombre',
                'p.primer_apellido as paciente_primer_apellido',
                'p.segundo_apellido as paciente_segundo_apellido',

                'a.id_medico as medico_id',
                'u.email as medico_email',
                'esp.nombre as especialidad_nombre',
                'a.fecha as fecha_atencion'
            ])
            ->where('ea.nombre', '=', 'Programada') // Solo atenciones programadas
            ->orderBy('a.fecha', 'asc')
            ->orderBy('a.hora', 'asc')
            ->orderBy('u.apellido', 'asc')
            ->get();
    }

    public function obtenerUsuarios()
    {
        return DB::table('usuarios as u')
                ->join('estados_usuario as e', 'u.id_estado_usuario','=','e.id')
                ->select([
                    'u.cedula',
                    'u.nombre',
                    'u.apellido',
                    'u.email',
                    'u.fecha_nacimiento',
                    'e.nombre as estado',
                    'u.created_at'
                ])
                ->orderBy('u.created_at', 'asc')
                ->get();
    }
}