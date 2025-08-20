<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Slide: {{ $slide->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('carousel.update', $slide) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Título -->
                            <div>
                                <label for="title" class="block font-medium text-sm text-gray-700">Título Principal</label>
                                <input id="title" name="title" type="text" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" value="{{ old('title', $slide->title) }}" required />
                            </div>
                            <!-- Subtítulo -->
                            <div>
                                <label for="subtitle" class="block font-medium text-sm text-gray-700">Subtítulo</label>
                                <textarea id="subtitle" name="subtitle" rows="3" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" required>{{ old('subtitle', $slide->subtitle) }}</textarea>
                            </div>
                            <!-- Texto del Botón -->
                            <div>
                                <label for="button_text" class="block font-medium text-sm text-gray-700">Texto del Botón</label>
                                <input id="button_text" name="button_text" type="text" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" value="{{ old('button_text', $slide->button_text) }}" required />
                            </div>
                            <!-- Enlace del Botón -->
                            <div>
                                <label for="button_link" class="block font-medium text-sm text-gray-700">Enlace del Botón (URL)</label>
                                <input id="button_link" name="button_link" type="url" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" value="{{ old('button_link', $slide->button_link) }}" required />
                            </div>
                            <!-- Imagen -->
                            <div>
                                <label for="image" class="block font-medium text-sm text-gray-700">Cambiar Imagen de Fondo (Opcional)</label>
                                <input id="image" name="image" type="file" class="block mt-1 w-full" />
                                <img src="{{ asset('storage/' . $slide->image_path) }}" alt="Imagen actual" class="mt-2 w-32 h-16 object-cover rounded">
                            </div>
                            <!-- Orden -->
                            <div>
                                <label for="order" class="block font-medium text-sm text-gray-700">Orden de Aparición</label>
                                <input id="order" name="order" type="number" class="block mt-1 w-full rounded-md shadow-sm border-gray-300" value="{{ old('order', $slide->order) }}" required />
                            </div>
                        </div>
                        <!-- Activo -->
                        <div class="block mt-4">
                            <label for="is_active" class="inline-flex items-center">
                                <input id="is_active" name="is_active" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm" value="1" @checked(old('is_active', $slide->is_active))>
                                <span class="ml-2 text-sm text-gray-600">¿Mostrar este slide en la página de inicio?</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('carousel.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">Cancelar</a>
                            <button type="submit" class="ml-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Actualizar Slide
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
