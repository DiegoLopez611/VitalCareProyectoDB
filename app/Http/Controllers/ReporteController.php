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
        try {

            $sedes = DB::table('sedes as s')
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


            // Calcular estadísticas básicas
            $totalSedes = $sedes->count();
            $sedesHoy = $sedes->where('created_at', '>=', Carbon::today())->count();
            $sedesEsteMes = $sedes->where('created_at', '>=', Carbon::now()->startOfMonth())->count();

            // Preparar datos para la vista
            $data = [
                'sedes' => $sedes,
                'totalSedes' => $totalSedes,
                'sedesHoy' => $sedesHoy,
                'sedesEsteMes' => $sedesEsteMes,
                'fechaGeneracion' => Carbon::now()->format('d/m/Y H:i:s'),
                'titulo' => 'Reporte de Sedes Registradas'
            ];

            // Generar PDF
            $pdf = Pdf::loadView('reportes.sedes-pdf', $data);
            
            // Configurar el PDF
            $pdf->setPaper('A4', 'portrait');
            $pdf->setOptions([
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true
            ]);

            // Generar nombre del archivo
            $nombreArchivo = 'reporte_sedes_' . Carbon::now()->format('Y-m-d_H-i-s') . '.pdf';
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

    public function reporteMedicos()
    {
        try {

            \Log::info('Iniciando generación de reporte de medicos');
            $medicos = DB::table('medicos as m')
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

             $medicos = $medicos->map(function ($medico) {
                $medico->name = trim($medico->nombre . ' ' . 
                                    $medico->apellido . ' ' );
                return $medico;
            });

            // Calcular estadísticas básicas
            $totalMedicos = $medicos->count();
            $medicosHoy = $medicos->where('created_at', '>=', Carbon::today())->count();
            $medicosEsteMes = $medicos->where('created_at', '>=', Carbon::now()->startOfMonth())->count();
            
            // Preparar datos para la vista
            $data = [
                'medicos' => $medicos,
                'totalMedicos' => $totalMedicos,
                'medicosHoy' => $medicosHoy,
                'medicosEsteMes' => $medicosEsteMes,
                'fechaGeneracion' => Carbon::now()->format('d/m/Y H:i:s'),
                'titulo' => 'Reporte de Medicamentos Registrados'
            ];

            // Generar PDF
            $pdf = Pdf::loadView('reportes.medicos-pdf', $data);
            
            // Configurar el PDF
            $pdf->setPaper('A4', 'portrait');
            $pdf->setOptions([
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true
            ]);

            // Generar nombre del archivo
            $nombreArchivo = 'reporte_medicos_' . Carbon::now()->format('Y-m-d_H-i-s') . '.pdf';
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

    public function reportePacientesCiudad()
    {
        try {
            \Log::info('Iniciando generación de reporte de pacientes por ciudad');
            
            // Obtener pacientes con información de ciudad
            $pacientes = DB::table('pacientes as p')
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

            // Agregar nombre completo
            $pacientes = $pacientes->map(function ($paciente) {
                $paciente->name = trim($paciente->primer_nombre . ' ' . $paciente->primer_apellido);
                return $paciente;
            });

            // Calcular estadísticas básicas
            $totalPacientes = $pacientes->count();
            $pacientesHoy = $pacientes->where('created_at', '>=', Carbon::today())->count();
            $pacientesEsteMes = $pacientes->where('created_at', '>=', Carbon::now()->startOfMonth())->count();

            // Estadísticas por ciudad
            $pacientesPorCiudad = $pacientes->groupBy('ciudad')->map(function ($grupo) {
                return $grupo->count();
            })->sortByDesc(function ($total) {
                return $total;
            });

            // Datos para gráfica de barras
            $ciudadesLabels = $pacientesPorCiudad->keys()->toArray();
            $ciudadesData = $pacientesPorCiudad->values()->toArray();
            
            // URL para gráfica usando QuickChart
            $chartUrl = $this->generateCityChartUrl($ciudadesLabels, $ciudadesData);

            // Preparar datos para la vista
            $data = [
                'pacientes' => $pacientes,
                'totalPacientes' => $totalPacientes,
                'pacientesHoy' => $pacientesHoy,
                'pacientesEsteMes' => $pacientesEsteMes,
                'pacientesPorCiudad' => $pacientesPorCiudad,
                'chartUrl' => $chartUrl,
                'fechaGeneracion' => Carbon::now()->format('d/m/Y H:i:s'),
                'titulo' => 'Reporte de Pacientes por Ciudad'
            ];

            // Generar PDF
            $pdf = Pdf::loadView('reportes.pacientes-ciudad-pdf', $data);
            
            // Configurar el PDF
            $pdf->setPaper('A4', 'portrait');
            $pdf->setOptions([
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
            ]);

            // Generar nombre del archivo
            $nombreArchivo = 'reporte_pacientes_ciudad_' . Carbon::now()->format('Y-m-d_H-i-s') . '.pdf';
            \Log::info('PDF generado exitosamente: ' . $nombreArchivo);
            
            // Descargar el PDF
            return $pdf->download($nombreArchivo);

        } catch (\Exception $e) {
            \Log::error('Error al generar reporte de pacientes por ciudad', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('reportes')
                ->with('error', 'Error al generar el reporte: ' . $e->getMessage());
        }
    }

    private function generateCityChartUrl($labels, $data)
    {
        $chartConfig = [
            'type' => 'bar',
            'data' => [
                'labels' => $labels,
                'datasets' => [[
                    'label' => 'Pacientes',
                    'data' => $data,
                    'backgroundColor' => ['#4F46E5', '#7C3AED', '#DC2626', '#059669', '#D97706', '#2563EB', '#C026D3', '#EA580C', '#65A30D', '#0891B2']
                ]]
            ],
            'options' => [
                'responsive' => false,
                'plugins' => ['legend' => ['display' => false]],
                'scales' => [
                    'y' => ['beginAtZero' => true, 'ticks' => ['stepSize' => 1]],
                    'x' => ['ticks' => ['maxRotation' => 45]]
                ]
            ]
        ];
        
        return 'https://quickchart.io/chart?c=' . urlencode(json_encode($chartConfig)) . '&width=500&height=300&backgroundColor=white';
    }
}
