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
        
        .gender-stats {
            margin: 20px 0;
            background-color: #F0F9FF;
            padding: 15px;
            border-radius: 8px;
        }
        
        .gender-stats h3 {
            margin: 0 0 10px 0;
            color: #1E40AF;
            font-size: 14px;
        }
        
        .gender-item {
            display: inline-block;
            margin-right: 20px;
            font-size: 11px;
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
    </div>

    <!-- Estadísticas por Género -->
    @if(count($estadisticasGenero) > 0)
    <div class="gender-stats">
        <h3>Distribución por Género</h3>
        @foreach($estadisticasGenero as $genero => $cantidad)
            <div class="gender-item">
                <strong>{{ ucfirst($genero ?? 'No especificado') }}:</strong> {{ $cantidad }} pacientes
            </div>
        @endforeach
    </div>
    @endif

    <!-- Tabla de Pacientes -->
    <div class="table-container">
        <h3 style="color: #4F46E5; margin-bottom: 15px;">Listado Completo de Pacientes</h3>
        
        @if(count($pacientes) > 0)
            <table>
                <thead>
                    <tr>
                        <th style="width: 8%">ID</th>
                        <th style="width: 12%">Cédula</th>
                        <th style="width: 20%">Nombre Completo</th>
                        <th style="width: 18%">Correo Electrónico</th>
                        <th style="width: 8%">Género</th>
                        <th style="width: 12%">Fecha Nac.</th>
                        <th style="width: 12%">Registro</th>
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
                                    <th style="width: 8%">ID</th>
                                    <th style="width: 12%">Cédula</th>
                                    <th style="width: 20%">Nombre Completo</th>
                                    <th style="width: 18%">Correo Electrónico</th>
                                    <th style="width: 8%">Género</th>
                                    <th style="width: 12%">Fecha Nac.</th>
                                    <th style="width: 12%">Registro</th>
                                </tr>
                            </thead>
                            <tbody>
                        @endif
                        <tr>
                            <td>{{ $paciente->id }}</td>
                            <td>{{ $paciente->cedula ?? 'N/A' }}</td>
                            <td>{{ $paciente->name }}</td>
                            <td>{{ $paciente->email ?? 'N/A' }}</td>
                            <td>{{ ucfirst($paciente->genero ?? 'No especificado') }}</td>
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
            Fecha: {{ $fechaGeneracion }} | 
            Sistema de Gestión de Pacientes
        </p>
    </div>
</body>
</html>