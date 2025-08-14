<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col bg-gray-100">
            <!-- Barra de Navegación -->
            <nav class="bg-white shadow-md">
                <div class="container mx-auto px-6 py-4 flex justify-between items-center">
                    <a href="{{ route('home') }}" class="font-bold text-xl text-gray-800">Pc Fast Mariquina</a>
                    <div class="flex items-center space-x-6">
                        <a href="{{ route('home') }}" class="text-gray-600 hover:text-blue-600">Inicio</a>
                        <a href="{{ route('about') }}" class="text-gray-600 hover:text-blue-600">Nosotros</a>
                        <a href="{{ route('contact') }}" class="text-gray-600 hover:text-blue-600">Contáctanos</a>
                        <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">Acceder</a>
                    </div>
                </div>
            </nav>

            <!-- Contenido Principal -->
            <main class="flex-grow">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="bg-gray-800 text-white py-4">
                <div class="container mx-auto px-6 text-center">
                    &copy; {{ date('Y') }} Pc Fast Mariquina. Todos los derechos reservados.
                </div>
            </footer>
        </div>
    </body>
</html>
