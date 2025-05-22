<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Medicos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Título de la sección -->
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Crear Nuevo Medico</h3>
                    
                    <!-- Botón regresar a listado -->
                    <div class="mb-6">
                        <a href="{{ route('medicos.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Volver al Listado
                        </a>
                    </div>

                    <!-- Formulario -->
                    <form method="POST" action="{{ route('medicos.store') }}">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Cédula -->
                            <div>
                                <x-label for="cedula" value="Cédula" />
                                <x-input id="cedula" class="block mt-1 w-full" type="text" name="cedula" :value="old('cedula')" required autofocus />
                                @error('cedula')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <x-label for="email" value="Email" />
                                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Primer Nombre -->
                            <div>
                                <x-label for="primer_nombre" value="Primer Nombre" />
                                <x-input id="primer_nombre" class="block mt-1 w-full" type="text" name="primer_nombre" :value="old('primer_nombre')" required />
                                @error('primer_nombre')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Segundo Nombre -->
                            <div>
                                <x-label for="segundo_nombre" value="Segundo Nombre" />
                                <x-input id="segundo_nombre" class="block mt-1 w-full" type="text" name="segundo_nombre" :value="old('segundo_nombre')" />
                                @error('segundo_nombre')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Primer Apellido -->
                            <div>
                                <x-label for="primer_apellido" value="Primer Apellido" />
                                <x-input id="primer_apellido" class="block mt-1 w-full" type="text" name="primer_apellido" :value="old('primer_apellido')" required />
                                @error('primer_apellido')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Segundo Apellido -->
                            <div>
                                <x-label for="segundo_apellido" value="Segundo Apellido" />
                                <x-input id="segundo_apellido" class="block mt-1 w-full" type="text" name="segundo_apellido" :value="old('segundo_apellido')" />
                                @error('segundo_apellido')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Licencia Medica -->
                            <div>
                                <x-label for="licencia_medica" value="licencia_medica" />
                                <x-input id="licencia_medica" class="block mt-1 w-full" type="text" name="licencia_medica" :value="old('licencia_medica')" />
                                @error('licencia_medica')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Fecha de Nacimiento -->
                            <div>
                                <x-label for="fecha_nacimiento" value="Fecha de Nacimiento" />
                                <x-input id="fecha_nacimiento" class="block mt-1 w-full" type="date" name="fecha_nacimiento" :value="old('fecha_nacimiento')" required />
                                @error('fecha_nacimiento')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Fecha de Inicio -->
                            <div>
                                <x-label for="fecha_inicio" value="Fecha de Inicio Laboral" />
                                <x-input id="fecha_inicio" class="block mt-1 w-full" type="date" name="fecha_inicio" :value="old('fecha_inicio')" required />
                                @error('fecha_inicio')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Dirección (campo completo) -->
                        <div class="mt-6">
                            <x-label for="direccion" value="Dirección" />
                            <textarea id="direccion" name="direccion" rows="3" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block w-full">{{ old('direccion') }}</textarea>
                            @error('direccion')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Botones de acción -->
                        <div class="flex justify-end mt-6 gap-4">
                            <a href="{{ route('medicos.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring focus:ring-gray-200 disabled:opacity-25 transition">
                                Cancelar
                            </a>
                            <x-button type="submit" class="bg-indigo-600 hover:bg-indigo-700">
                                Guardar Medico
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>