<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Medicamentos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Título de la sección -->
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Listado de Medicamentos</h3>
                    
                    <!-- Barra superior con búsqueda y botón crear -->
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-6">
                        <!-- Campo de búsqueda -->
                        <form method="GET" action="{{ route('medicamentos.buscar') }}" class="flex w-full sm:w-2/3 gap-2">
                            <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar medicamento..." class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                                BUSCAR
                            </button>
                        </form>
                        
                        <!-- Botón crear paciente de tamaño normal -->
                        <a href="{{ route('medicamentos.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring focus:ring-indigo-300 disabled:opacity-25 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Crear medicamento
                        </a>
                    </div>

                    <!-- Tabla de pacientes -->
                    <div class="overflow-x-auto w-full">
                        <table class="w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nombre
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Concentración (Mg)
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nombre Labotario
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($medicamentos as $medicamento)
                                    @if($medicamento->estado == 'ACTIVO')
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                                                {{ $medicamento->nombre }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                                                {{ $medicamento->concentracion }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                                                {{ $medicamento->nombre_laboratorio }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                                <div class="flex justify-center space-x-2">
                                                
                                                    <!-- Botón para ver detalles (ojo) 
                                                    <button type="button" class="text-blue-600 hover:text-blue-900" onclick="openModal('modal-{{ $medicamento->id }}')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                                        </svg>
                                                    </button>
                                                    -->
                                                    <a href="{{ route('medicamentos.edit', $medicamento->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                        </svg>
                                                    </a>
                                                    <form action="{{ route('medicamentos.destroy', $medicamento->id) }}" method="POST" class="inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('¿Está seguro que desea eliminar este medicamento?')">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                    <!-- Botón para ver detalles -->
                                                    <button type="button" class="text-blue-600 hover:text-blue-900" onclick="openModal('modal-{{ $medicamento->id }}')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                                        </svg>
                                                    </button>

                                                    <!-- Modal -->
                                                    <div id="modal-{{ $medicamento->id }}" class="fixed inset-0 bg-gray-800 bg-opacity-50 hidden items-center justify-center z-50">
                                                        <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
                                                            <div class="flex justify-between items-center mb-4">
                                                                <h2 class="text-xl font-semibold w-full text-center">Detalles del Medicamento</h2>
                                                                <button onclick="closeModal('modal-{{ $medicamento->id }}')" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
                                                            </div>
                                                            <p><strong>Nombre:</strong> {{ $medicamento->nombre }}</p>
                                                            <p><strong>Nombre Laboratorio:</strong> {{ $medicamento->nombre_laboratorio }}</p>
                                                            <p><strong>Concentración:</strong> {{ $medicamento->concentracion }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            No hay medicamentos registrados
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- Paginación -->
                    <div class="mt-4">
                        @if(isset($medicamentos) && $medicamentos->hasPages())
                            {{ $medicamentos->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script para manejar los modales -->
    <script>
        
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            // Removemos hidden y agregamos flex para centrar el modal
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            // Bloquear el scroll del body cuando el modal está abierto
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.remove('flex');
            modal.classList.add('hidden');
            // Restaurar el scroll del body cuando el modal se cierra
            document.body.style.overflow = 'auto';
        }
    </script>
</x-app-layout>