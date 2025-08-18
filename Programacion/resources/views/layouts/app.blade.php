<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- SEO Básico --}}
    <meta name="description" content="Monitoreo proactivo de PCs en Mariquina. Anticipa problemas antes de que ocurran.">
    <meta name="author" content="Pc Fast Mariquina">

    <title>{{ config('app.name', 'Pc Fast Mariquina') }}</title>

    {{-- Fuente moderna --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- Tailwind + JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Animaciones AOS (opcional) --}}
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
</head>

<body class="font-sans antialiased bg-gray-50 text-gray-900">
    {{-- Barra de navegación --}}
    <div class="min-h-screen flex flex-col">
        @include('layouts.navigation')

        {{-- Encabezado de página --}}
        @if (isset($header))
            <header class="bg-white shadow-md sticky top-0 z-50">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        {{-- Contenido principal --}}
        <main class="flex-grow">
            {{ $slot }}
        </main>

        {{-- Footer global --}}
        <footer class="bg-gray-900 text-white py-6 mt-12">
            <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center text-sm">
                <p>&copy; {{ date('Y') }} Pc Fast Mariquina. Todos los derechos reservados.</p>
                <p>Desarrollado con ❤️ en Mariquina</p>
            </div>
        </footer>
    </div>

    {{-- Scripts personalizados --}}
    @stack('scripts')

    {{-- AOS Animations --}}
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true
        });
    </script>
</body>

</html>
