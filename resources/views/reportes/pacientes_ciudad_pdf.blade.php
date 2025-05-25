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
            border-bottom: 2px solid #4F46E5;
            padding-bottom: 20px;
        }
        
        .header h1 {
            color: #4F46E5;
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
        }
        
        .stat-box {
            text-align: center;
            flex: 1;
            margin: 0 10px;
        }
        
        .stat-number {
            font-size: 20px;
            font-weight: bold;
            color: #4F46E5;
            display: block;
        }
        
        .stat-label {
            font-size: 11px;
            color: #666;
            margin-top: 5px;
        }

        .chart-container {
            text-align: center;
            margin: 30px 0;
            background-color: #F8FAFC;
            padding: 20px;
            border-radius: 8px;
        }

        .chart-container h3 {
            color: #4F46E5;
            margin: 0 0 15px 0;
            font-size: 16px;
        }
        
        .city-stats {
            margin: 20px 0;
            background-color: #F0F9FF;
            padding: 15px;
            border-radius: 8px;
        }
        
        .city-stats h3 {
            margin: 0 0 15px 0;
            color: #1E40AF;
            font-size: 16px;
        }

        .city-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .city-stat-item {
            background-color: white;
            padding: 12px;
            border-radius: 6px;
            border-left: 4px solid #4F46E5;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .city-name {
            font-weight: bold;
            color: #1E40AF;
            font-size: 13px;
        }

        .city-count {
            font-size: 18px;
            font-weight: bold;
            color: #4F46E5;
        }
        
        .table-container {
            margin-top: 20px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 10px;
        }
        
        table th {
            background-color: #4F46E5;
            color: white;
            padding: 8px 6px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #ddd;
        }
        
        table td {
            padding: 6px;
            border: 1px solid #ddd;
            vertical-align: top;
        }
        
        table tr:nth-child(even) {
            background-color: #F9FAFB;
        }
        
        table tr:hover {
            background-color: #F3F4F6;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
        
        .no-data {
            text-align: center;
            padding: 40px;
            color: #666;
            font-style: italic;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        @media print {
            body {
                margin: 0;
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Encabezado -->
    <div class="header">
        <h1>{{ $titulo }}</h1>
        <p>Fecha de generación: {{ $fechaGeneracion }}</p>
        <p>Sistema de Gestión Médica</p>
    </div>

    <!-- Estadísticas Generales -->
    <div class="stats-container">
        <div class="stat-box">
            <span class="stat-number">{{ $totalPacientes }}</span>
            <div class="stat-label">Total Pacientes Registrados</div>
        </div>
        <div class="stat-box">
            <span class="stat-number">{{ $pacientesHoy }}</span>
            <div class="stat-label">Registrados Hoy</div>
        </div>
        <div class="stat-box">
            <span class="stat-number">{{ $pacientesEsteMes }}</span>
            <div class="stat-label">Este Mes</div>
        </div>
        <div class="stat-box">
            <span class="stat-number">{{ count($pacientesPorCiudad) }}</span>
            <div class="stat-label">Ciudades con Pacientes Registrados</div>
        </div>
    </div>

    <!-- Gráfica -->
    <div class="chart-container">
        <h3>Distribución de Pacientes por Ciudad</h3>
        <img src="{{ $chartUrl }}" 
             alt="Gráfica de Pacientes por Ciudad" 
             style="max-width: 100%; height: auto; border: 1px solid #ddd; border-radius: 4px;">
    </div>

    <!-- Estadísticas por Ciudad -->
    <div class="city-stats">
        <h3>Pacientes por Ciudad</h3>
        <div class="city-stats-grid">
            @foreach($pacientesPorCiudad as $ciudad => $total)
            <div class="city-stat-item">
                <div class="city-name">{{ $ciudad }}</div>
                <div class="city-count">{{ $total }} pacientes</div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Tabla de Pacientes -->
    <div class="table-container">
        <h3 style="color: #4F46E5; margin-bottom: 15px;">Listado Completo de Pacientes por Ciudad</h3>
        
        @if(count($pacientes) > 0)
            <table>
                <thead>
                    <tr>
                        <th style="width: 12%">Cédula</th>
                        <th style="width: 25%">Nombre Completo</th>
                        <th style="width: 20%">Ciudad</th>
                        <th style="width: 15%">Fecha Registro</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pacientes as $index => $paciente)
                        @if($index > 0 && $index % 25 == 0)
                            </tbody>
                        </table>
                        <div class="page-break"></div>
                        <table>
                            <thead>
                                <tr>
                                    <th style="width: 12%">Cédula</th>
                                    <th style="width: 25%">Nombre Completo</th>
                                    <th style="width: 20%">Ciudad</th>
                                    <th style="width: 15%">Fecha Registro</th>
                                </tr>
                            </thead>
                            <tbody>
                        @endif
                        <tr>
                            <td>{{ $paciente->cedula }}</td>
                            <td>{{ $paciente->name }}</td>
                            <td>{{ $paciente->ciudad }}</td>
                            <td>{{ \Carbon\Carbon::parse($paciente->created_at)->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="no-data">
                <p>No se encontraron pacientes registrados en el sistema.</p>
            </div>
        @endif
    </div>

    <!-- Pie de página -->
    <div class="footer">
        <p>
            <strong>Reporte generado automáticamente</strong><br>
            Total de registros: {{ $totalPacientes }} | 
            Ciudades: {{ count($pacientesPorCiudad) }} | 
            Fecha: {{ $fechaGeneracion }} | 
            Sistema de Gestión Médica
        </p>
    </div>
</body>
</html>