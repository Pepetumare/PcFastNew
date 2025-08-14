<x-guest-layout>
    {{-- Sección Principal (Hero) --}}
    <div class="bg-gray-800 text-white">
        <div class="container mx-auto px-6 py-24 text-center">
            <h1 class="text-4xl md:text-5xl font-bold leading-tight">Monitoreo Proactivo para tu PC en Mariquina</h1>
            <p class="mt-4 text-lg text-gray-300">Anticipamos los problemas antes de que ocurran. Tu tranquilidad es nuestro servicio.</p>
            <a href="{{ route('register') }}" class="mt-8 inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300">Contratar Servicio</a>
        </div>
    </div>

    {{-- Sección de Características --}}
    <div class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">¿Cómo te ayudamos?</h2>
            <div class="flex flex-wrap -mx-4">
                <div class="w-full md:w-1/3 px-4 mb-8">
                    <div class="rounded-lg shadow-lg p-6 text-center">
                        <h3 class="text-xl font-bold mb-2">Detección Temprana</h3>
                        <p class="text-gray-600">Nuestro agente vigila la salud de tu PC 24/7, detectando altas temperaturas, fallos de disco o falta de memoria.</p>
                    </div>
                </div>
                <div class="w-full md:w-1/3 px-4 mb-8">
                    <div class="rounded-lg shadow-lg p-6 text-center">
                        <h3 class="text-xl font-bold mb-2">Alertas Inteligentes</h3>
                        <p class="text-gray-600">Te notificamos proactivamente si algo no va bien, recomendando acciones antes de una falla catastrófica.</p>
                    </div>
                </div>
                <div class="w-full md:w-1/3 px-4 mb-8">
                    <div class="rounded-lg shadow-lg p-6 text-center">
                        <h3 class="text-xl font-bold mb-2">Soporte Local</h3>
                        <p class="text-gray-600">Somos de Mariquina. Ofrecemos un servicio cercano, confiable y rápido para solucionar cualquier problema.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
