<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Registrar Nuevo Dispositivo
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('devices.store') }}">
                        @csrf

                        <!-- Nombre del Dispositivo -->
                        <div>
                            <label for="name" class="block font-medium text-sm text-gray-700">Nombre Descriptivo del
                                Dispositivo</label>
                            <input id="name" name="name" type="text"
                                class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required autofocus />
                        </div>

                        <!-- AÑADIMOS EL MENÚ DESPLEGABLE PARA ASIGNAR USUARIO -->
                        <div class="mt-4">
                            <label for="user_id" class="block font-medium text-sm text-gray-700">Asignar a Usuario
                                (Cliente)</label>
                            <select name="user_id" id="user_id"
                                class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required>
                                <option value="">Seleccione un cliente</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('dashboard') }}"
                                class="text-sm text-gray-600 hover:text-gray-900 mr-4">Cancelar</a>
                            <button type="submit"
                                class="ml-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Guardar y Generar Token
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
