<x-guest-layout>
    {{-- Hero con fondo y animaciones --}}
        <!-- Slider main container -->
        <div class="swiper-container h-[60vh] md:h-[80vh] bg-gray-800">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
                <!-- Slides -->
                @forelse($slides as $slide)
                <div class="swiper-slide relative">
                    <img src="{{ asset('storage/' . $slide->image_path) }}" class="w-full h-full object-cover" alt="{{ $slide->title }}">
                    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                        <div class="text-center text-white p-4">
                            <h1 class="text-4xl md:text-5xl font-bold leading-tight">{{ $slide->title }}</h1>
                            <p class="mt-4 text-lg text-gray-200 max-w-2xl mx-auto">{{ $slide->subtitle }}</p>
                            <a href="{{ $slide->button_link }}" class="mt-8 inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300">{{ $slide->button_text }}</a>
                        </div>
                    </div>
                </div>
                @empty
                {{-- Slide por defecto si no hay ninguno configurado --}}
                <div class="swiper-slide relative">
                    <img src="https://placehold.co/1920x1080/374151/FFFFFF?text=Pc+Fast+Mariquina" class="w-full h-full object-cover" alt="Placeholder">
                    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                        <div class="text-center text-white p-4">
                            <h1 class="text-4xl md:text-5xl font-bold leading-tight">Monitoreo Proactivo</h1>
                            <p class="mt-4 text-lg text-gray-200">Configura tu primer slide en el panel de administrador.</p>
                            <a href="{{ route('register') }}" class="mt-8 inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg">Contratar Servicio</a>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>
            <!-- If we need pagination -->
            <div class="swiper-pagination"></div>

            <!-- If we need navigation buttons -->
            <div class="swiper-button-prev text-white"></div>
            <div class="swiper-button-next text-white"></div>
        </div>

    {{-- Características con iconos y hover effects --}}
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl md:text-4xl font-bold text-center text-gray-800 mb-16">¿Cómo te ayudamos?</h2>
            <div class="grid md:grid-cols-3 gap-10">
                {{-- Card 1 --}}
                <div
                    class="bg-gray-50 rounded-2xl shadow-lg p-8 text-center transform hover:-translate-y-2 transition duration-300 hover:shadow-2xl">
                    <div class="text-blue-600 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 8c-1.105 0-2 .895-2 2s.895 2 2 2 2-.895 2-2-.895-2-2-2z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 14c-3.314 0-6 2.239-6 5v1h12v-1c0-2.761-2.686-5-6-5z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Detección Temprana</h3>
                    <p class="text-gray-600">Nuestro agente vigila la salud de tu PC 24/7, detectando altas
                        temperaturas, fallos de disco o falta de memoria.</p>
                </div>

                {{-- Card 2 --}}
                <div
                    class="bg-gray-50 rounded-2xl shadow-lg p-8 text-center transform hover:-translate-y-2 transition duration-300 hover:shadow-2xl">
                    <div class="text-green-600 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13 16h-1v-4h-1m1-4h.01M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Alertas Inteligentes</h3>
                    <p class="text-gray-600">Te notificamos proactivamente si algo no va bien, recomendando acciones
                        antes de una falla catastrófica.</p>
                </div>

                {{-- Card 3 --}}
                <div
                    class="bg-gray-50 rounded-2xl shadow-lg p-8 text-center transform hover:-translate-y-2 transition duration-300 hover:shadow-2xl">
                    <div class="text-indigo-600 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M5.121 17.804A13.94 13.94 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 20v-1a6 6 0 00-12 0v1" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Soporte Local</h3>
                    <p class="text-gray-600">Somos de Mariquina. Ofrecemos un servicio cercano, confiable y rápido para
                        solucionar cualquier problema.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Animaciones personalizadas --}}
    <style>
        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.8s ease-out forwards;
        }

        .delay-200 {
            animation-delay: 0.2s;
        }

        .delay-400 {
            animation-delay: 0.4s;
        }
    </style>

    @push('scripts')
    <script>
        const swiper = new Swiper('.swiper-container', {
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    </script>
    @endpush
</x-guest-layout>
