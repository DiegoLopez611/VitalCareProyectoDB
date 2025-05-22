<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pacientes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Título de la sección -->
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Editar Paciente</h3>
                    
                    <!-- Botón regresar a listado -->
                    <div class="mb-6">
                        <a href="{{ route('pacientes.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Volver al Listado
                        </a>
                    </div>

                    <!-- Formulario -->
                    <form method="POST" action="{{ route('pacientes.update', $paciente->id) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Cédula (deshabilitada) -->
                            <div>
                                <x-label for="cedula" value="Cédula" />
                                <x-input id="cedula" class="block mt-1 w-full bg-gray-100" type="text" name="cedula" value="{{ $paciente->cedula }}" disabled />
                                <!-- Campo oculto para enviar el valor -->
                                <input type="hidden" name="cedula" value="{{ $paciente->cedula }}">
                            </div>

                            <!-- Fecha de Nacimiento (deshabilitada) -->
                            <div>
                                <x-label for="fecha_nacimiento" value="Fecha de Nacimiento" />
                                <x-input id="fecha_nacimiento" class="block mt-1 w-full bg-gray-100" type="date" name="fecha_nacimiento_disabled" value="{{ $paciente->fecha_nacimiento }}" disabled />
                                <!-- Campo oculto para enviar el valor -->
                                <input type="hidden" name="fecha_nacimiento" value="{{ $paciente->fecha_nacimiento }}">
                            </div>

                            <!-- Primer Nombre -->
                            <div>
                                <x-label for="primer_nombre" value="Primer Nombre" />
                                <x-input id="primer_nombre" class="block mt-1 w-full" type="text" name="primer_nombre" value="{{ $paciente->primer_nombre }}" required />
                                @error('primer_nombre')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Segundo Nombre -->
                            <div>
                                <x-label for="segundo_nombre" value="Segundo Nombre" />
                                <x-input id="segundo_nombre" class="block mt-1 w-full" type="text" name="segundo_nombre" value="{{ $paciente->segundo_nombre }}" />
                                @error('segundo_nombre')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Primer Apellido -->
                            <div>
                                <x-label for="primer_apellido" value="Primer Apellido" />
                                <x-input id="primer_apellido" class="block mt-1 w-full" type="text" name="primer_apellido" value="{{ $paciente->primer_apellido }}" required />
                                @error('primer_apellido')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Segundo Apellido -->
                            <div>
                                <x-label for="segundo_apellido" value="Segundo Apellido" />
                                <x-input id="segundo_apellido" class="block mt-1 w-full" type="text" name="segundo_apellido" value="{{ $paciente->segundo_apellido }}" />
                                @error('segundo_apellido')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <x-label for="email" value="Email" />
                                <x-input id="email" class="block mt-1 w-full" type="email" name="email" value="{{ $paciente->email }}" required />
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        <!-- Dirección (campo completo) -->
                        <div class="mt-6">
                            <x-label for="direccion" value="Dirección" />
                            <textarea id="direccion" name="direccion" rows="3" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full">{{ $paciente->direccion }}</textarea>
                            @error('direccion')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Campos de selección foráneos -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                            <!-- Ciudad -->
                            <div>
                                <x-label for="ciudad_id" value="Ciudad" />
                                <select id="ciudad_id" name="ciudad_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="">Seleccione una ciudad</option>
                                    @foreach ($ciudades as $ciudad)
                                        <option value="{{ $ciudad->id }}" {{ $paciente->id_ciudad == $ciudad->id ? 'selected' : '' }}>
                                            {{ $ciudad->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('ciudad_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Género -->
                            <div>
                                <x-label for="genero_id" value="Género" />
                                <select id="genero_id" name="genero_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="">Seleccione un género</option>
                                    @foreach ($generos as $genero)
                                        <option value="{{ $genero->id }}" {{ $paciente->id_genero == $genero->id ? 'selected' : '' }}>
                                            {{ $genero->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('genero_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Grupo Sanguíneo -->
                            <div>
                                <x-label for="grupo_sanguineo_id" value="Grupo Sanguíneo" />
                                <select id="grupo_sanguineo_id" name="grupo_sanguineo_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="">Seleccione un grupo</option>
                                    @foreach ($grupos_sanguineos as $grupo)
                                        <option value="{{ $grupo->id }}" {{ $paciente->id_grupo_sanguineo == $grupo->id ? 'selected' : '' }}>
                                            {{ $grupo->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('grupo_sanguineo_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="flex justify-end mt-6 gap-4">
                            <a href="{{ route('pacientes.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring focus:ring-gray-200 disabled:opacity-25 transition">
                                Cancelar
                            </a>
                            <x-button type="submit" class="bg-indigo-600 hover:bg-indigo-700">
                                Actualizar Paciente
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>