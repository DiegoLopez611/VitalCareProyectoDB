<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $titulo }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #8B5CF6;
            padding-bottom: 20px;
        }
        
        .header h1 {
            color: #8B5CF6;
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }
        
        .header p {
            margin: 5px 0;
            color: #666;
        }
        
        .stats-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 25px;
            background-color: #F8FAFC;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #E5E7EB;
        }
        
        .stat-box {
            text-align: center;
            flex: 1;
            margin: 0 10px;
        }
        
        .stat-number {
            font-size: 20px;
            font-weight: bold;
            color: #8B5CF6;
            display: block;
        }
        
        .stat-label {
            font-size: 11px;
            color: #666;
            margin-top: 5px;
        }
        
        .summary-section {
            margin: 20px 0;
            display: flex;
            justify-content: space-between;
            gap: 15px;
        }
        
        .summary-box {
            flex: 1;
            background-color: #F3E8FF;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #DDD6FE;
        }
        
        .summary-box.dates {
            background-color: #EDE9FE;
            border: 1px solid #C4B5FD;
        }
        
        .summary-box h3 {
            margin: 0 0 15px 0;
            color: #7C3AED;
            font-size: 16px;
        }
        
        .summary-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 10px;
        }

        .summary-stat-item {
            background-color: white;
            padding: 10px;
            border-radius: 6px;
            border-left: 4px solid #8B5CF6;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .summary-name {
            font-weight: bold;
            color: #5B21B6;
            font-size: 12px;
        }

        .summary-count {
            font-size: 16px;
            font-weight: bold;
            color: #8B5CF6;
        }
        
        .doctor-section {
            margin: 30px 0;
            background-color: #F8FAFC;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #E5E7EB;
        }
        
        .doctor-section h3 {
            margin: 0 0 15px 0;
            color: #8B5CF6;
            font-size: 16px;
            text-align: center;
        }
        
        .doctor-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .doctor-card {
            background-color: white;
            border: 1px solid #DDD6FE;
            border-radius: 8px;
            padding: 15px;
            border-left: 4px solid #8B5CF6;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: all 0.2s ease;
        }

        .doctor-card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            transform: translateY(-1px);
        }

        .doctor-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .doctor-name {
            font-weight: bold;
            color: #7C3AED;
            font-size: 14px;
        }

        .doctor-specialty {
            font-size: 12px;
            color: #6B7280;
            font-style: italic;
            margin-top: 2px;
        }

        .doctor-stats {
            display: flex;
            justify-content: space-between;
            margin: 8px 0;
            font-size: 11px;
        }

        .doctor-stat {
            text-align: center;
            background-color: #F9FAFB;
            padding: 5px 8px;
            border-radius: 4px;
            min-width: 60px;
        }

        .doctor-stat-number {
            font-weight: bold;
            color: #8B5CF6;
            display: block;
            font-size: 14px;
        }

        .doctor-contact {
            font-size: 10px;
            color: #666;
            margin-top: 8px;
        }
        
        .table-container {
            margin-top: 20px;
        }
        
        .detail-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 10px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        .detail-table th {
            background-color: #8B5CF6;
            color: white;
            padding: 8px 6px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #ddd;
        }
        
        .detail-table td {
            padding: 6px;
            border: 1px solid #E5E7EB;
            vertical-align: top;
        }
        
        .detail-table tr:nth-child(even) {
            background-color: #FAFAFA;
        }
        
        .detail-table tr:hover {
            background-color: #F3F4F6;
        }
        
        .doctor-group {
            margin-bottom: 25px;
            border: 1px solid #DDD6FE;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .doctor-group-header {
            background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%);
            color: white;
            padding: 12px 15px;
            font-weight: bold;
            font-size: 14px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .doctor-info {
            flex-grow: 1;
        }

        .doctor-count {
            background-color: rgba(255,255,255,0.2);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #DDD6FE;
            padding-top: 15px;
            background-color: #FAFBFF;
            border-radius: 8px;
            padding: 15px;
        }
        
        .no-data {
            text-align: center;
            padding: 40px;
            color: #666;
            font-style: italic;
            background-color: #F9FAFB;
            border-radius: 8px;
            border: 1px solid #E5E7EB;
        }
        
        .page-break {
            page-break-before: always;
        }

        .status-badge {
            background-color: #FEF3C7;
            color: #92400E;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
        }

        .status-badge.programada {
            background-color: #DBEAFE;
            color: #1E40AF;
        }

        .status-badge.completada {
            background-color: #D1FAE5;
            color: #065F46;
        }

        .status-badge.cancelada {
            background-color: #FEE2E2;
            color: #DC2626;
        }

        .priority-high {
            background-color: #FEE2E2;
            color: #DC2626;
        }

        .priority-normal {
            background-color: #DBEAFE;
            color: #2563EB;
        }

        .section-divider {
            height: 2px;
            background: linear-gradient(90deg, transparent 0%, #8B5CF6 50%, transparent 100%);
            margin: 30px 0;
            border-radius: 1px;
        }
        
        @media print {
            body {
                margin: 0;
                padding: 15px;
            }
            
            .doctor-card:hover {
                transform: none;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }
        }
    </style>
</head>
<body>
    <!-- Encabezado -->
    <div class="header">
        <h1>{{ $titulo }}</h1>
        <p>Fecha de generación: {{ $fechaGeneración }}</p>
        <p>Sistema de Gestión Médica</p>
    </div>

    <!-- Estadísticas Generales -->
    <div class="stats-container">
        <div class="stat-box">
            <span class="stat-number">{{ $totalAtenciones }}</span>
            <div class="stat-label">Total Atenciones Programadas</div>
        </div>
        <div class="stat-box">
            <span class="stat-number">{{ $atencionesHoy }}</span>
            <div class="stat-label">Para Hoy</div>
        </div>
        <div class="stat-box">
            <span class="stat-number">{{ $atencionesSemana }}</span>
            <div class="stat-label">Esta Semana</div>
        </div>
        <div class="stat-box">
            <span class="stat-number">{{ $atencionesProximaSemana }}</span>
            <div class="stat-label">Próxima Semana</div>
        </div>
        <div class="stat-box">
            <span class="stat-number">{{ $medicos->count() }}</span>
            <div class="stat-label">Médicos Activos</div>
        </div>
    </div>

    <!-- Resúmenes por Especialidad -->
    <div class="summary-section">
        <div class="summary-box">
            <h3>Atenciones por Especialidad</h3>
            <div class="summary-stats-grid">
                @foreach($estadisticasPorEspecialidad->sortDesc() as $especialidad => $cantidad)
                <div class="summary-stat-item">
                    <div class="summary-name">{{ $especialidad ?? 'Sin especialidad' }}</div>
                    <div class="summary-count">{{ $cantidad }}</div>
                </div>
                @endforeach
            </div>
        </div>
        
        <div class="summary-box dates">
            <h3>Próximas Fechas (Mayor demanda)</h3>
            <div class="summary-stats-grid">
                @foreach($estadisticasPorFecha->take(6) as $fecha => $cantidad)
                <div class="summary-stat-item">
                    <div class="summary-name">{{ \Carbon\Carbon::parse($fecha)->format('d/m/Y') }}</div>
                    <div class="summary-count">{{ $cantidad }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="section-divider"></div>

    <!-- Resumen por Médicos -->
    <div class="doctor-section">
        <h3>Resumen por Médicos</h3>
        <div class="doctor-grid">
            @foreach($atencionesPorMedico->sortByDesc('total_atenciones') as $medico)
            <div class="doctor-card">
                <div class="doctor-header">
                    <div>
                        <div class="doctor-name">{{ $medico['medico_nombre'] }}</div>
                        <div class="doctor-specialty">{{ $medico['especialidades'] }}</div>
                    </div>
                </div>
                <div class="doctor-stats">
                    <div class="doctor-stat">
                        <span class="doctor-stat-number">{{ $medico['total_atenciones'] }}</span>
                        <div>Total</div>
                    </div>
                    <div class="doctor-stat">
                        <span class="doctor-stat-number">{{ $medico['atenciones_hoy'] }}</span>
                        <div>Hoy</div>
                    </div>
                    <div class="doctor-stat">
                        <span class="doctor-stat-number">{{ $medico['atenciones_semana'] }}</span>
                        <div>Semana</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="section-divider"></div>

    <!-- Listado Detallado por Médico -->
    <div class="table-container">
        <h3 style="color: #8B5CF6; margin-bottom: 15px;">Listado Detallado de Atenciones por Médico</h3>
        
        @if(count($atencionesPorMedico) > 0)
            @foreach($atencionesPorMedico->sortByDesc('total_atenciones') as $medico)
                <div class="doctor-group">
                    <div class="doctor-group-header">
                        <div class="doctor-info">
                            <strong>{{ $medico['medico_nombre'] }}</strong> - {{ $medico['especialidades'] }}
                            <br><small>{{ $medico['medico_email'] }}</small>
                        </div>
                        <div class="doctor-count">{{ $medico['total_atenciones'] }} atenciones</div>
                    </div>
                    
                    <table class="detail-table">
                        <thead>
                            <tr>
                                <th style="width: 8%">ID</th>
                                <th style="width: 12%">Fecha</th>
                                <th style="width: 10%">Hora</th>
                                <th style="width: 25%">Paciente</th>
                                <th style="width: 12%">Cédula</th>
                                <th style="width: 15%">Especialidad</th>
                                <th style="width: 10%">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($medico['atenciones'] as $atencion)
                                <tr>
                                    <td>{{ $atencion->id }}</td>
                                    <td>
                                        @if($atencion->fecha_atencion)
                                            {{ \Carbon\Carbon::parse($atencion->fecha_atencion)->format('d/m/Y') }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>{{ $atencion->hora_atencion ?? 'N/A' }}</td>
                                    <td>{{ $atencion->paciente_nombre_completo }}</td>
                                    <td>{{ $atencion->paciente_cedula ?? 'N/A' }}</td>
                                    <td><strong>{{ $atencion->especialidad_nombre ?? 'N/A' }}</strong></td>
                                    <td>
                                        <span class="status-badge programada">
                                            {{ $atencion->estado_nombre ?? 'Programada' }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        @else
            <div class="no-data">
                <p>No se encontraron atenciones programadas en el sistema.</p>
            </div>
        @endif
    </div>

    <!-- Pie de página -->
    <div class="footer">
        <p>
            <strong>Reporte de Atenciones Programadas por Médico</strong><br>
            Total de atenciones: {{ $totalAtenciones }} | 
            Médicos activos: {{ $medicos->count() }} | 
            Especialidades: {{ $especialidades->count() }} | 
            Fecha: {{ $fechaGeneracion }} | 
            Sistema de Gestión Médica
        </p>
    </div>
</body>
</html>