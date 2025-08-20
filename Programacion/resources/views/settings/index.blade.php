    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Ajustes Generales del Sitio
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-semibold mb-4">Cambiar Logo del Sitio</h3>

                        @if (session('success'))
                            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
                        @endif

                        <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="mb-4">
                                <label for="logo" class="block font-medium text-sm text-gray-700">Seleccionar nuevo logo (SVG, PNG, JPG)</label>
                                <input id="logo" name="logo" type="file" class="block mt-1 w-full" required />
                                @error('logo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            @if($logoPath)
                            <div class="mb-4">
                                <p class="block font-medium text-sm text-gray-700">Logo Actual:</p>
                                <img src="{{ asset('storage/' . $logoPath) }}" alt="Logo actual" class="mt-2 h-12 bg-gray-100 p-2 rounded">
                            </div>
                            @endif

                            <div class="flex items-center justify-end mt-6">
                                <button type="submit" class="ml-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                    Subir y Guardar Logo
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
    