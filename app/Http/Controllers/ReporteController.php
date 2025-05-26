<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Repositories\Interfaces\ReporteRepositoryInterface;

class ReporteController extends Controller
{

    protected $reporteRepository;

    public function __construct(ReporteRepositoryInterface $reporteRepository)
    {
        $this->reporteRepository = $reporteRepository;
    }

    public function index()
    {
         return view('reportes.index');
    }

    public function reportePacientes()
    {
        try {

            \Log::info('Iniciando generación de reporte de pacientes');
            // Consultar todos los pacientes con JOIN a la tabla generos
            $pacientes = $this->reporteRepository->pacientesPorGenero();

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
            $pdf = Pdf::loadView('reportes.pacientes_pdf', $data);
            
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

            $medicamentos = $this->reporteRepository->obtenerMedicamentos();

            $totalMedicamentos = $medicamentos->count();
            $medicamentosHoy = $medicamentos->where('created_at', '>=', Carbon::today())->count();
            $medicamentosEsteMes = $medicamentos->where('created_at', '>=', Carbon::now()->startOfMonth())->count();
            
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
            $pdf = Pdf::loadView('reportes.medicamentos_pdf', $data);
            
            // Configurar el PDF
            $pdf->setPaper('A4', 'portrait');
            $pdf->setOptions([
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true
            ]);

            // Generar nombre del archivo
            $nombreArchivo = 'reporte_medicamentos_' . Carbon::now()->format('Y-m-d_H-i-s') . '.pdf';
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

            $sedes = $this->reporteRepository->sedesPorCiudad();

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
            $pdf = Pdf::loadView('reportes.sedes_pdf', $data);
            
            // Configurar el PDF
            $pdf->setPaper('A4', 'portrait');
            $pdf->setOptions([
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true
            ]);

            // Generar nombre del archivo
            $nombreArchivo = 'reporte_sedes_' . Carbon::now()->format('Y-m-d_H-i-s') . '.pdf';
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

            $medicos = $this->reporteRepository->medicosPorEspecialidad();

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
                'titulo' => 'Reporte de Medicos Registrados'
            ];

            // Generar PDF
            $pdf = Pdf::loadView('reportes.medicos_pdf', $data);
            
            // Configurar el PDF
            $pdf->setPaper('A4', 'portrait');
            $pdf->setOptions([
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true
            ]);

            // Generar nombre del archivo
            $nombreArchivo = 'reporte_medicos_' . Carbon::now()->format('Y-m-d_H-i-s') . '.pdf';
            return $pdf->download($nombreArchivo);

        } catch (\Exception $e) {

            \Log::error('Error al generar reporte de medicos', [
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
            
            // Obtener pacientes con información de ciudad
            $pacientes = $this->reporteRepository->pacientesPorCiudad();

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
            $pdf = Pdf::loadView('reportes.pacientes_ciudad_pdf', $data);
            
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
    
    public function reportePacientesGrupoSanguineo()
    {
        try {
            // Consultar pacientes con sus relaciones
            $pacientes = $this->reporteRepository->pacientesPorGrupoSanguineoCiudad();
            
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
            
            // Agrupar por ciudad y tipo de sangre
            $estadisticasCiudadTipoSangre = $pacientes->groupBy('ciudad')->map(function ($pacientesPorCiudad, $ciudad) {
                return $pacientesPorCiudad->groupBy('tipo_sangre')->map(function ($group) {
                    return $group->count();
                });
            });
            
            // Estadísticas por ciudad (totales)
            $estadisticasPorCiudad = $pacientes->groupBy('ciudad')->map(function ($group) {
                return $group->count();
            });
            
            // Estadísticas por tipo de sangre (totales)
            $estadisticasPorTipoSangre = $pacientes->groupBy('tipo_sangre')->map(function ($group) {
                return $group->count();
            });
            
            // Obtener ciudades únicas para el resumen
            $ciudades = $pacientes->pluck('ciudad')->unique()->sort()->values();
            
            // Obtener tipos de sangre únicos para el resumen
            $tiposSangre = $pacientes->pluck('tipo_sangre')->unique()->sort()->values();
            
            $data = [
                'pacientes' => $pacientes,
                'totalPacientes' => $totalPacientes,
                'pacientesHoy' => $pacientesHoy,
                'pacientesEsteMes' => $pacientesEsteMes,
                'estadisticasCiudadTipoSangre' => $estadisticasCiudadTipoSangre,
                'estadisticasPorCiudad' => $estadisticasPorCiudad,
                'estadisticasPorTipoSangre' => $estadisticasPorTipoSangre,
                'ciudades' => $ciudades,
                'tiposSangre' => $tiposSangre,
                'fechaGeneracion' => Carbon::now()->format('d/m/Y H:i:s'),
                'titulo' => 'Reporte de Pacientes por Tipo de Sangre y Ciudad'
            ];

            $pdf = Pdf::loadView('reportes.pacientes_grupo_sanguineo_ciudad_pdf', $data);
            $pdf->setPaper('A4', 'landscape'); // Cambiar a horizontal por más columnas
            $pdf->setOptions([
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true
            ]);
            
            // Generar nombre del archivo
            $nombreArchivo = 'reporte_pacientes_sangre_ciudad_' . Carbon::now()->format('Y-m-d_H-i-s') . '.pdf';
            return $pdf->download($nombreArchivo);
            
        } catch (\Exception $e) {
            \Log::error('Error al generar reporte de pacientes por tipo de sangre y ciudad', [
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

    public function reporteDiagnosticos()
    {
        try {

            $diagnosticos = $this->reporteRepository->obtenerDiagnosticos();

            $totalDiagnosticos = $diagnosticos->count();
            $diagnosticosHoy = $diagnosticos->where('created_at', '>=', Carbon::today())->count();
            $diagnosticosEsteMes = $diagnosticos->where('created_at', '>=', Carbon::now()->startOfMonth())->count();
            
            // Preparar datos para la vista
            $data = [
                'diagnosticos' => $diagnosticos,
                'totalDiagnosticos' => $totalDiagnosticos,
                'diagnosticosHoy' => $diagnosticosHoy,
                'diagnosticosEsteMes' => $diagnosticosEsteMes,
                'fechaGeneracion' => Carbon::now()->format('d/m/Y H:i:s'),
                'titulo' => 'Reporte de Diagnosticos Registrados'
            ];

            // Generar PDF
            $pdf = Pdf::loadView('reportes.diagnosticos_pdf', $data);
            
            // Configurar el PDF
            $pdf->setPaper('A4', 'portrait');
            $pdf->setOptions([
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true
            ]);

            // Generar nombre del archivo
            $nombreArchivo = 'reporte_diagnosticos_' . Carbon::now()->format('Y-m-d_H-i-s') . '.pdf';
            return $pdf->download($nombreArchivo);

        } catch (\Exception $e) {

            \Log::error('Error al generar reporte de diagnosticos', [
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

    public function reporteTratamientos()
    {
        try {

            $tratamientos = $this->reporteRepository->obtenerTratamientos();

            $totalTratamientos = $tratamientos->count();
            $tratamientosHoy = $tratamientos->where('created_at', '>=', Carbon::today())->count();
            $tratamientosEsteMes = $tratamientos->where('created_at', '>=', Carbon::now()->startOfMonth())->count();
            
            // Preparar datos para la vista
            $data = [
                'tratamientos' => $tratamientos,
                'totalTratamientos' => $totalTratamientos,
                'tratamientosHoy' => $tratamientosHoy,
                'tratamientosEsteMes' => $tratamientosEsteMes,
                'fechaGeneracion' => Carbon::now()->format('d/m/Y H:i:s'),
                'titulo' => 'Reporte de Tratamientos Registrados'
            ];

            // Generar PDF
            $pdf = Pdf::loadView('reportes.tratamientos_pdf', $data);
            
            // Configurar el PDF
            $pdf->setPaper('A4', 'portrait');
            $pdf->setOptions([
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true
            ]);

            // Generar nombre del archivo
            $nombreArchivo = 'reporte_tratamientos_' . Carbon::now()->format('Y-m-d_H-i-s') . '.pdf';
            return $pdf->download($nombreArchivo);

        } catch (\Exception $e) {

            \Log::error('Error al generar reporte de diagnosticos', [
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

    public function reporteAtencionesProgramadas()
    {
        try {
            // Consultar atenciones programadas con sus relaciones
            $atenciones = $this->reporteRepository->atencionesProgramadasPorMedico();
            
            // Transformar datos para agregar información completa
            $atenciones = $atenciones->map(function ($atencion) {
                // Nombre completo del médico
                $atencion->medico_nombre_completo = trim(
                    $atencion->medico_nombres . ' ' .
                    $atencion->medico_apellidos
                );
                
                // Nombre completo del paciente
                $atencion->paciente_nombre_completo = trim(
                    $atencion->paciente_primer_nombre . ' ' .
                    ($atencion->paciente_segundo_nombre ?? '') . ' ' .
                    $atencion->paciente_primer_apellido . ' ' .
                    ($atencion->paciente_segundo_apellido ?? '')
                );
                
                return $atencion;
            });
            
            // Calcular estadísticas básicas
            $totalAtenciones = $atenciones->count();
            $atencionesHoy = $atenciones->where('fecha_atencion', Carbon::today()->format('Y-m-d'))->count();
            $atencionesSemana = $atenciones->where('fecha_atencion', '>=', Carbon::now()->startOfWeek())
                                        ->where('fecha_atencion', '<=', Carbon::now()->endOfWeek())->count();
            $atencionesProximaSemana = $atenciones->where('fecha_atencion', '>=', Carbon::now()->addWeek()->startOfWeek())
                                                ->where('fecha_atencion', '<=', Carbon::now()->addWeek()->endOfWeek())->count();
            
            // Agrupar por médico
            $atencionesPorMedico = $atenciones->groupBy('medico_id')->map(function ($atencionesGrupo, $medicoId) {
                $primerAtencion = $atencionesGrupo->first();
                return [
                    'medico_id' => $medicoId,
                    'medico_nombre' => $primerAtencion->medico_nombre_completo,
                    'medico_email' => $primerAtencion->medico_email ?? 'N/A',
                    'especialidades' => $atencionesGrupo->pluck('especialidad_nombre')->unique()->implode(', '),
                    'total_atenciones' => $atencionesGrupo->count(),
                    'atenciones_hoy' => $atencionesGrupo->where('fecha_atencion', Carbon::today()->format('Y-m-d'))->count(),
                    'atenciones_semana' => $atencionesGrupo->where('fecha_atencion', '>=', Carbon::now()->startOfWeek()->format('Y-m-d'))
                                                        ->where('fecha_atencion', '<=', Carbon::now()->endOfWeek()->format('Y-m-d'))->count(),
                    'atenciones' => $atencionesGrupo->sortBy('fecha_atencion')
                ];
            });
            
            // Estadísticas por especialidad (desde la atención)
            $estadisticasPorEspecialidad = $atenciones->groupBy('especialidad_nombre')->map(function ($group) {
                return $group->count();
            });
            
            // Estadísticas por fecha (próximos 7 días)
            $estadisticasPorFecha = $atenciones->groupBy('fecha_atencion')->map(function ($group) {
                return $group->count();
            })->sortKeys();
            
            // Obtener médicos únicos
            $medicos = $atenciones->groupBy('medico_id')->map(function ($group) {
                $primerAtencion = $group->first();
                return [
                    'id' => $primerAtencion->medico_id,
                    'nombre' => $primerAtencion->medico_nombre_completo,
                    'especialidades' => $group->pluck('especialidad_nombre')->unique()->implode(', ')
                ];
            })->values();
            
            // Obtener especialidades únicas (desde las atenciones)
            $especialidades = $atenciones->pluck('especialidad_nombre')->unique()->filter()->sort()->values();
            
            $data = [
                'atenciones' => $atenciones,
                'atencionesPorMedico' => $atencionesPorMedico,
                'totalAtenciones' => $totalAtenciones,
                'atencionesHoy' => $atencionesHoy,
                'atencionesSemana' => $atencionesSemana,
                'atencionesProximaSemana' => $atencionesProximaSemana,
                'estadisticasPorEspecialidad' => $estadisticasPorEspecialidad,
                'estadisticasPorFecha' => $estadisticasPorFecha,
                'medicos' => $medicos,
                'especialidades' => $especialidades,
                'fechaGeneracion' => Carbon::now()->format('d/m/Y H:i:s'),
                'titulo' => 'Reporte de Atenciones Programadas por Médico'
            ];

            $pdf = Pdf::loadView('reportes.atenciones_programadas_medicos_pdf', $data);
            $pdf->setPaper('A4', 'landscape'); // Horizontal por más columnas
            $pdf->setOptions([
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true
            ]);
            
            // Generar nombre del archivo
            $nombreArchivo = 'reporte_atenciones_programadas_medicos_' . Carbon::now()->format('Y-m-d_H-i-s') . '.pdf';
            return $pdf->download($nombreArchivo);
            
        } catch (\Exception $e) {
            \Log::error('Error al generar reporte de atenciones programadas por médico', [
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
