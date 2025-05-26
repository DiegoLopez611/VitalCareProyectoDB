<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reportes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8">
                    <div class="mb-8">
                        <h1 class="text-2xl font-medium text-gray-900">
                            Sistema de Reportes
                        </h1>
                        <p class="mt-2 text-gray-600 leading-relaxed">
                            Genera y descarga diferentes tipos de reportes del sistema para análisis y toma de decisiones.
                        </p>
                        <br>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @php
                            $reportes = [
                                [
                                    'titulo' => 'Reporte de Medicametos',
                                    'nivel' => 'Básico',
                                    'descripcion' => 'Generar un reporte de todos los medicamentos registrados en el sistema, incluyecdo información básica como nombre del medicamento, nombre del consultorio y la concentración.',
                                    'icono' => '💊',
                                    'ruta' => 'reportes.medicamentos'
                                ],
                                [
                                    'titulo' => 'Reporte de Diagnosticos',
                                    'nivel' => 'Básico',
                                    'descripcion' => 'Generar un reporte de todos los diagnosticos registrados en el sistema, incluyendo información básica como nombre del diagnostico y descripción.',
                                    'icono' => '🩺',
                                    'ruta' => 'reportes.diagnosticos'
                                ],
                                [
                                    'titulo' => 'Reporte de Usuarios',
                                    'nivel' => 'Intermedio',
                                    'descripcion' => 'Generar un reporte de todos los usuarios registrados en el sistema, incluyendo información básica.',
                                    'icono' => '👤',
                                    'ruta' => 'reportes.usuarios'
                                ],
                                [
                                    'titulo' => 'Reporte de Tratamientos',
                                    'nivel' => 'Intermedio',
                                    'descripcion' => 'Generar un reporte de todos los Tratamientos registrados en el sistema, incluyendo información básica como nombre del tratamiento, tipo del tratamiento y descripción.',
                                    'icono' => '📋',
                                    'ruta' => 'reportes.tratamientos'
                                ],
                                [
                                    'titulo' => 'Reporte de Sedes',
                                    'nivel' => 'Intermedio',
                                    'descripcion' => 'Generar un reporte de todas las sedes registradas en el sistema, incluyecdo información básica como nombre de la sede, telefono, dirección y ciudad',
                                    'icono' => '🏥',
                                    'ruta' => 'reportes.sedes'
                                ],
                                [
                                    'titulo' => 'Reporte de Pacientes',
                                    'nivel' => 'Intermedio',
                                    'descripcion' => 'Generar un reporte completo de todos los pacientes registrados en el sistema, incluyendo información básica (discriminados por género).',
                                    'icono' => '👥',
                                    'ruta' => 'reportes.pacientes'
                                ],
                                [
                                    'titulo' => 'Reporte de Pacientes por Ciudad',
                                    'nivel' => 'Intermedio',
                                    'descripcion' => 'Genera un reporte completo de todos los pacientes registrados en el sistema, incluyendo información básica (discriminados por ciudad).',
                                    'icono' => '🏙️',
                                    'ruta' => 'reportes.pacientes_ciudad'
                                ],
                                [
                                    'titulo' => 'Reporte de Pacientes y Grupo Sanguineo por Ciudad',
                                    'nivel' => 'Avanazado',
                                    'descripcion' => 'Generar un reporte completo de la cantidad de pacientes por grupo sanguineo en cada una de las ciudades registradas en el sistema.',
                                    'icono' => '🩸',
                                    'ruta' => 'reportes.pacientes_grupo_sanguineo'
                                ],
                                [
                                    'titulo' => 'Reporte de Medicos',
                                    'nivel' => 'Avanzado',
                                    'descripcion' => 'Generar un reporte de todos los medicos registrados en el sistema, incluyecdo información básica como nombre, cedula y especialidad',
                                    'icono' => '🧑‍⚕️',
                                    'ruta' => 'reportes.medicos'
                                ],
                                [
                                    'titulo' => 'Reporte de Atenciones Programadas',
                                    'nivel' => 'Avanzado',
                                    'descripcion' => 'Generar un reporte de todas las atenciones programadas registradas en el sistema, incluyendo información general de la atención, médico y paciente asociado.',
                                    'icono' => '📢',
                                    'ruta' => 'reportes.atenciones_programadas'
                                ]
                            ];
                        @endphp

                        @foreach($reportes as $reporte)
                        <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 p-6 flex flex-col border border-gray-200">
                            <div class="flex items-center justify-between mb-4">
                                <div class="text-3xl">{{ $reporte['icono'] }}</div>
                                <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                    @if($reporte['nivel'] === 'Básico') 
                                        bg-green-100 text-green-800
                                    @elseif($reporte['nivel'] === 'Intermedio')
                                        bg-yellow-100 text-yellow-800
                                    @else
                                        bg-red-100 text-red-800
                                    @endif">
                                    {{ $reporte['nivel'] }}
                                </span>
                            </div>
                            
                            <h3 class="text-lg font-semibold text-gray-800 mb-3">
                                {{ $reporte['titulo'] }}
                            </h3>
                            
                            <p class="text-gray-600 text-sm mb-6 flex-grow leading-relaxed">
                                {{ $reporte['descripcion'] }}
                            </p>
                            
                            <div class="mt-auto">
                                <a href="{{ route($reporte['ruta']) }}" 
                                   class="reporte-link block w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 text-center">
                                    <span class="flex items-center justify-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Generar Reporte
                                    </span>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de carga -->
    <div id="loadingModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 max-w-sm mx-auto shadow-xl">
            <div class="flex items-center">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600 mr-4"></div>
                <span class="text-gray-700 font-medium">Generando reporte...</span>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    // Agregar indicador de carga al hacer clic en los enlaces de reportes
    document.addEventListener('DOMContentLoaded', function() {
        const reporteLinks = document.querySelectorAll('.reporte-link');
        
        reporteLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                // Mostrar modal de carga
                document.getElementById('loadingModal').classList.remove('hidden');
                document.getElementById('loadingModal').classList.add('flex');
                
                // Cambiar el texto del enlace
                const originalContent = this.innerHTML;
                this.innerHTML = `
                    <span class="flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Generando...
                    </span>
                `;
                
                // Restaurar después de un tiempo (para PDFs que se descargan rápido)
                setTimeout(() => {
                    document.getElementById('loadingModal').classList.add('hidden');
                    document.getElementById('loadingModal').classList.remove('flex');
                    this.innerHTML = originalContent;
                }, 3000);
            });
        });
    });
    </script>
    @endpush
</x-app-layout>