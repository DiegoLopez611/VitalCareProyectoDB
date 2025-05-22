<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteController extends Controller
{
    public function index()
    {
         return view('reportes.index');
    }

    public function reportePacientes()
    {
        try {

            \Log::info('Iniciando generación de reporte de pacientes');
            // Consultar todos los pacientes con JOIN a la tabla generos
            $pacientes = DB::table('pacientes as p')
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

            \Log::info('Pacientes obtenidos: ' . $pacientes->count());

            // Transformar datos para agregar nombre completo
            $pacientes = $pacientes->map(function ($paciente) {
                $paciente->name = trim($paciente->primer_nombre . ' ' . 
                                    ($paciente->segundo_nombre ?? '') . ' ' . 
                                    $paciente->primer_apellido . ' ' . 
                                    ($paciente->segundo_apellido ?? ''));
                return $paciente;
            });

            // Calcular estadísticas básicas
            $totalPacientes = $pacientes->count();
            $pacientesHoy = $pacientes->where('created_at', '>=', Carbon::today())->count();
            $pacientesEsteMes = $pacientes->where('created_at', '>=', Carbon::now()->startOfMonth())->count();
            
            // Agrupar por género usando el nombre del género
            $estadisticasGenero = $pacientes->groupBy('genero')->map(function ($group) {
                return $group->count();
            });

             // Debug: Log de estadísticas
            \Log::info('Estadísticas calculadas', [
                'total' => $totalPacientes,
                'hoy' => $pacientesHoy,
                'mes' => $pacientesEsteMes
            ]);

            // Preparar datos para la vista
            $data = [
                'pacientes' => $pacientes,
                'totalPacientes' => $totalPacientes,
                'pacientesHoy' => $pacientesHoy,
                'pacientesEsteMes' => $pacientesEsteMes,
                'estadisticasGenero' => $estadisticasGenero,
                'fechaGeneracion' => Carbon::now()->format('d/m/Y H:i:s'),
                'titulo' => 'Reporte de Pacientes Registrados'
            ];

            // Generar PDF
            $pdf = Pdf::loadView('reportes.pacientes-pdf', $data);
            
            // Configurar el PDF
            $pdf->setPaper('A4', 'portrait');
            $pdf->setOptions([
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true
            ]);

            // Generar nombre del archivo
            $nombreArchivo = 'reporte_pacientes_' . Carbon::now()->format('Y-m-d_H-i-s') . '.pdf';
            \Log::info('PDF generado exitosamente: ' . $nombreArchivo);
            // Descargar el PDF
            return $pdf->download($nombreArchivo);

        } catch (\Exception $e) {

            \Log::error('Error al generar reporte de pacientes', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            // En caso de error, redirigir con mensaje
            return redirect()->route('reportes')
                ->with('error', 'Error al generar el reporte: ' . $e->getMessage());
        }
    }

    public function reporteMedicamentos()
    {
        try {

            \Log::info('Iniciando generación de reporte de pacientes');
            $medicamentos = DB::table('medicamentos')
                ->select([
                    'nombre',
                    'nombre_laboratorio',
                    'concentracion',
                    'id',
                    'created_at'
                ])
                ->orderBy('created_at', 'desc')
                ->get();

            \Log::info('Pacientes obtenidos: ' . $medicamentos->count());
            // Calcular estadísticas básicas
            $totalMedicamentos = $medicamentos->count();
            $medicamentosHoy = $medicamentos->where('created_at', '>=', Carbon::today())->count();
            $medicamentosEsteMes = $medicamentos->where('created_at', '>=', Carbon::now()->startOfMonth())->count();

            \Log::info('Estadísticas calculadas', [
                'total' => $totalMedicamentos,
                'hoy' => $medicamentosHoy,
                'mes' => $medicamentosEsteMes
            ]);
            
            // Preparar datos para la vista
            $data = [
                'medicamentos' => $medicamentos,
                'totalMedicamentos' => $totalMedicamentos,
                'medicamentosHoy' => $medicamentosHoy,
                'medicamentosEsteMes' => $medicamentosEsteMes,
                'fechaGeneracion' => Carbon::now()->format('d/m/Y H:i:s'),
                'titulo' => 'Reporte de Medicamentos Registrados'
            ];

            // Generar PDF
            $pdf = Pdf::loadView('reportes.medicamentos-pdf', $data);
            
            // Configurar el PDF
            $pdf->setPaper('A4', 'portrait');
            $pdf->setOptions([
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true
            ]);

            // Generar nombre del archivo
            $nombreArchivo = 'reporte_medicamentos_' . Carbon::now()->format('Y-m-d_H-i-s') . '.pdf';
            \Log::info('PDF generado exitosamente: ' . $nombreArchivo);
            // Descargar el PDF
            return $pdf->download($nombreArchivo);

        } catch (\Exception $e) {

            \Log::error('Error al generar reporte de pacientes', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            // En caso de error, redirigir con mensaje
            return redirect()->route('reportes')
                ->with('error', 'Error al generar el reporte: ' . $e->getMessage());
        }
    }

    public function reporteSedes()
    {
        
    }
}
