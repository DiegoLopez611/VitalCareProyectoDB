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
        
        .summary-section {
            margin: 20px 0;
            display: flex;
            justify-content: space-between;
            gap: 15px;
        }
        
        .summary-box {
            flex: 1;
            background-color: #F0F9FF;
            padding: 15px;
            border-radius: 8px;
        }
        
        .summary-box.blood-type {
            background-color: #F0F9FF;
        }
        
        .summary-box h3 {
            margin: 0 0 15px 0;
            color: #1E40AF;
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
            border-left: 4px solid #4F46E5;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .summary-name {
            font-weight: bold;
            color: #1E40AF;
            font-size: 12px;
        }

        .summary-count {
            font-size: 16px;
            font-weight: bold;
            color: #4F46E5;
        }
        
        .matrix-section {
            margin: 30px 0;
            background-color: #F8FAFC;
            padding: 20px;
            border-radius: 8px;
        }
        
        .matrix-section h3 {
            margin: 0 0 15px 0;
            color: #4F46E5;
            font-size: 16px;
            text-align: center;
        }
        
        .matrix-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
            margin-bottom: 15px;
        }
        
        .matrix-table th {
            background-color: #4F46E5;
            color: white;
            padding: 8px 6px;
            text-align: center;
            font-weight: bold;
            border: 1px solid #ddd;
        }
        
        .matrix-table td {
            padding: 6px;
            border: 1px solid #ddd;
            text-align: center;
        }
        
        .matrix-table td.city-name {
            background-color: #F8FAFC;
            font-weight: bold;
            text-align: left;
            padding-left: 8px;
        }
        
        .matrix-table tr:nth-child(even) {
            background-color: #F9FAFB;
        }
        
        .matrix-table tr:hover {
            background-color: #F3F4F6;
        }
        
        .table-container {
            margin-top: 20px;
        }
        
        .detail-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 10px;
        }
        
        .detail-table th {
            background-color: #4F46E5;
            color: white;
            padding: 8px 6px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #ddd;
        }
        
        .detail-table td {
            padding: 6px;
            border: 1px solid #ddd;
            vertical-align: top;
        }
        
        .detail-table tr:nth-child(even) {
            background-color: #F9FAFB;
        }
        
        .detail-table tr:hover {
            background-color: #F3F4F6;
        }
        
        .city-group {
            margin-bottom: 25px;
            border: 1px solid #E5E7EB;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .city-header {
            background-color: #4F46E5;
            color: white;
            padding: 12px 15px;
            font-weight: bold;
            font-size: 14px;
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
        <p>Sistema de Gestión de Pacientes</p>
    </div>

    <!-- Estadísticas Generales -->
    <div class="stats-container">
        <div class="stat-box">
            <span class="stat-number">{{ $totalPacientes }}</span>
            <div class="stat-label">Total Pacientes</div>
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
            <span class="stat-number">{{ $ciudades->count() }}</span>
            <div class="stat-label">Ciudades</div>
        </div>
        <div class="stat-box">
            <span class="stat-number">{{ $tiposSangre->count() }}</span>
            <div class="stat-label">Tipos de Sangre</div>
        </div>
    </div>

    <!-- Resúmenes por Ciudad y Tipo de Sangre -->
    <div class="summary-section">
        <div class="summary-box">
            <h3>Pacientes por Ciudad</h3>
            <div class="summary-stats-grid">
                @foreach($estadisticasPorCiudad->sortDesc() as $ciudad => $cantidad)
                <div class="summary-stat-item">
                    <div class="summary-name">{{ $ciudad ?? 'Sin ciudad' }}</div>
                    <div class="summary-count">{{ $cantidad }} pacientes</div>
                </div>
                @endforeach
            </div>
        </div>
        
        <div class="summary-box blood-type">
            <h3>Pacientes por Tipo de Sangre</h3>
            <div class="summary-stats-grid">
                @foreach($estadisticasPorTipoSangre->sortDesc() as $tipoSangre => $cantidad)
                <div class="summary-stat-item">
                    <div class="summary-name">{{ $tipoSangre ?? 'Sin tipo' }}</div>
                    <div class="summary-count">{{ $cantidad }} pacientes</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Matriz de Distribución -->
    <div class="matrix-section">
        <h3>Matriz de Distribución: Pacientes por Ciudad y Tipo de Sangre</h3>
        @if(count($estadisticasCiudadTipoSangre) > 0)
            <table class="matrix-table">
                <thead>
                    <tr>
                        <th style="width: 20%">Ciudad</th>
                        @foreach($tiposSangre as $tipo)
                            <th style="width: {{ 80 / $tiposSangre->count() }}%">{{ $tipo ?? 'S/T' }}</th>
                        @endforeach
                        <th style="width: 10%">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($estadisticasCiudadTipoSangre as $ciudad => $tiposSangreCiudad)
                        <tr>
                            <td class="city-name">{{ $ciudad ?? 'Sin ciudad' }}</td>
                            @php $totalCiudad = 0; @endphp
                            @foreach($tiposSangre as $tipo)
                                @php 
                                    $cantidad = $tiposSangreCiudad->get($tipo, 0);
                                    $totalCiudad += $cantidad;
                                @endphp
                                <td>{{ $cantidad > 0 ? $cantidad : '-' }}</td>
                            @endforeach
                            <td><strong>{{ $totalCiudad }}</strong></td>
                        </tr>
                    @endforeach
                    <!-- Fila de totales -->
                    <tr style="background-color: #E5E7EB; font-weight: bold;">
                        <td class="city-name">TOTAL</td>
                        @foreach($tiposSangre as $tipo)
                            <td>{{ $estadisticasPorTipoSangre->get($tipo, 0) }}</td>
                        @endforeach
                        <td><strong>{{ $totalPacientes }}</strong></td>
                    </tr>
                </tbody>
            </table>
        @else
            <div class="no-data">
                <p>No se encontraron datos para generar la matriz.</p>
            </div>
        @endif
    </div>

    <!-- Listado Detallado por Ciudad -->
    <div class="table-container">
        <h3 style="color: #4F46E5; margin-bottom: 15px;">Listado Detallado por Ciudad</h3>
        
        @if(count($pacientes) > 0)
            @foreach($estadisticasCiudadTipoSangre as $ciudad => $tiposSangreCiudad)
                <div class="city-group">
                    <div class="city-header">
                        {{ $ciudad ?? 'Sin ciudad especificada' }} 
                        ({{ $estadisticasPorCiudad->get($ciudad, 0) }} pacientes)
                    </div>
                    
                    <table class="detail-table">
                        <thead>
                            <tr>
                                <th style="width: 8%">ID</th>
                                <th style="width: 12%">Cédula</th>
                                <th style="width: 25%">Nombre Completo</th>
                                <th style="width: 20%">Correo</th>
                                <th style="width: 10%">Tipo Sangre</th>
                                <th style="width: 12%">Fecha Nac.</th>
                                <th style="width: 13%">Registro</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pacientes->where('ciudad', $ciudad) as $paciente)
                                <tr>
                                    <td>{{ $paciente->id }}</td>
                                    <td>{{ $paciente->cedula ?? 'N/A' }}</td>
                                    <td>{{ $paciente->name }}</td>
                                    <td>{{ $paciente->email ?? 'N/A' }}</td>
                                    <td><strong>{{ $paciente->tipo_sangre ?? 'N/A' }}</strong></td>
                                    <td>
                                        @if($paciente->fecha_nacimiento)
                                            {{ \Carbon\Carbon::parse($paciente->fecha_nacimiento)->format('d/m/Y') }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($paciente->created_at)->format('d/m/Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        @else
            <div class="no-data">
                <p>No se encontraron pacientes registrados en el sistema.</p>
            </div>
        @endif
    </div>

    <!-- Pie de página -->
    <div class="footer">
        <p>
            <strong>Reporte de Distribución por Tipo de Sangre y Ciudad</strong><br>
            Total de registros: {{ $totalPacientes }} | 
            Ciudades: {{ $ciudades->count() }} | 
            Tipos de sangre: {{ $tiposSangre->count() }} | 
            Fecha: {{ $fechaGeneracion }} | 
            Sistema de Gestión de Pacientes
        </p>
    </div>
</body>
</html>