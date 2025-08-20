<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Pc Fast Mariquina') }}</title>

    {{-- Fuentes y estilos --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- AOS Animations --}}
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
</head>

<body class="font-sans text-gray-900 antialiased bg-gray-50">
    <div class="min-h-screen flex flex-col">
        <!-- Navbar -->
        <nav class="bg-white shadow-md fixed w-full z-50 transition duration-300">
            <div class="container mx-auto px-6 py-4 flex justify-between items-center">
                <a href="{{ route('home') }}">
                    @if ($logoPath)
                        <img src="{{ asset('storage/' . $logoPath) }}" alt="Logo Pc Fast Mariquina" class="h-10">
                    @else
                        <span class="font-bold text-xl text-gray-800">Pc Fast Mariquina</span>
                    @endif
                </a>
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('home') }}" class="nav-link">Inicio</a>
                    <a href="{{ route('about') }}" class="nav-link">Nosotros</a>
                    <a href="{{ route('contact') }}" class="nav-link">Contáctanos</a>
                    <a href="{{ route('login') }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow">Acceder</a>
                </div>
                <button id="menu-btn" class="md:hidden text-gray-800 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
            <div id="mobile-menu" class="hidden md:hidden bg-white px-6 pb-4 space-y-2">
                <a href="{{ route('home') }}" class="block nav-link">Inicio</a>
                <a href="{{ route('about') }}" class="block nav-link">Nosotros</a>
                <a href="{{ route('contact') }}" class="block nav-link">Contáctanos</a>
                <a href="{{ route('login') }}"
                    class="block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg">Acceder</a>
            </div>
        </nav>

        <!-- Contenido principal -->
        <main class="flex-grow mt-20">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-gray-900 text-gray py-8 mt-12">
            <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center">
                <p class="text-sm">&copy; {{ date('Y') }} Pc Fast Mariquina. Todos los derechos reservados.</p>
                <div class="flex space-x-4 mt-4 md:mt-0">
                    <a href="#" class="hover:text-blue-400 transition"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="hover:text-blue-400 transition"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="hover:text-blue-400 transition"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
        </footer>
    </div>

    {{-- Scripts --}}
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true
        });
        const menuBtn = document.getElementById('menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>

    <style>
        .nav-link {
            @apply text-gray-600 hover:text-blue-600 transition;
        }
    </style>
    @vite(['resources/js/app.js'])

    <!-- Swiper.js JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    @stack('scripts')
</body>

</html>
