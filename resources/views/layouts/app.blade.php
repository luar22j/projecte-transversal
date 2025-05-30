<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Burgers & Roll') }}</title>

        <link rel="shortcut icon" href="{{ asset('images/icon.png') }}" type="image/x-icon">
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
    </head>
    <body class="font-sans antialiased {{ auth()->check() ? 'logged-in' : '' }}">
        <div class="min-h-screen bg-base-100">
            @include('components.header')
            @if(request()->is('marketplace*'))
                @include('components.navigation')
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot ?? '' }}
                @yield('content')
            </main>

            @include('components.footer')

            <!-- Modal de detalles -->
            <div id="detallesModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
                <div class="bg-base-100 p-6 rounded-xl max-w-2xl w-full mx-4 md:mx-auto max-h-[90vh] overflow-y-auto transform scale-95 transition-all duration-300">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h3 class="text-2xl text-base-content font-bold" id="modalTitulo"></h3>
                            <div class="flex items-center gap-1 mt-2">
                                @for ($i = 0; $i < 4; $i++)
                                    <i class="fas fa-star text-yellow-400"></i>
                                @endfor
                                <i class="fas fa-star text-gray-300"></i>
                                <span class="ml-1 text-sm text-base-content/70">(4.0)</span>
                            </div>
                        </div>
                        <button onclick="cerrarDetalles()" class="text-base-content/70 hover:text-base-content">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    
                    <div class="flex flex-col md:flex-row gap-6 mb-6">
                        <div class="md:w-1/2">
                            <img id="modalImagen" class="w-full rounded-lg object-cover" src="" alt="">
                        </div>
                        <div class="md:w-1/2">
                            <p class="text-2xl text-base-content font-bold mb-2" id="modalPrecio"></p>
                            <p class="text-base-content mb-4" id="modalDescripcion"></p>
                            <div id="modalIngredientes" class="mt-4">
                                <h4 class="text-lg text-base-content font-semibold mb-2">Ingredientes:</h4>
                                <ul class="list-disc list-inside text-base-content pl-5" id="listaIngredientes"></ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6 flex justify-end">
                        <button onclick="cerrarDetalles()" class="bg-base-300 text-base-content py-2 px-4 rounded-lg mr-2 hover:bg-base-400 transition-all">
                            Cerrar
                        </button>
                        <button class="bg-[#F3C71E] text-[#1A323E] py-2 px-4 rounded-lg hover:bg-[#f4cf3c] transition-all">
                            Añadir al carrito
                        </button>
                    </div>
                </div>
            </div>

            <!-- Botón flotante de administración -->
            @auth
                @if(auth()->user()->hasRole('admin'))
                    <a href="{{ route('admin.dashboard') }}" 
                       class="z-50 fixed bottom-6 right-6 bg-[#F3C71E] text-[#1A323E] rounded-full p-4 shadow-lg transition-all duration-500 hover:scale-110 group">
                        <div class="flex items-center justify-center">
                            <i class="fas fa-user-shield text-xl flex-shrink-0"></i>
                            <span class="group-hover:ml-2 w-0 group-hover:w-[100px] overflow-hidden whitespace-nowrap transition-all duration-500 ease-in-out">Panel Admin</span>
                        </div>
                    </a>
                @endif
            @endauth
        </div>

        <!-- Theme Script -->
        <script defer>
            document.addEventListener('DOMContentLoaded', function() {
                const themeToggle = document.querySelector('.theme-controller');
                const html = document.documentElement;

                // Función para aplicar el tema
                function applyTheme(theme) {
                    if (theme === 'light') {
                        html.setAttribute('data-theme', 'light');
                        document.body.classList.add('light-mode');
                    } else {
                        html.setAttribute('data-theme', 'dark');
                        document.body.classList.remove('light-mode');
                    }
                }

                // Función para cambiar el tema
                function toggleTheme() {
                    const currentTheme = html.getAttribute('data-theme');
                    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                    
                    // Guardar preferencia en localStorage
                    localStorage.setItem('theme', newTheme);
                    
                    // Aplicar el nuevo tema
                    applyTheme(newTheme);
                }

                // Aplicar tema guardado al cargar la página
                const savedTheme = localStorage.getItem('theme');
                if (savedTheme) {
                    applyTheme(savedTheme);
                    themeToggle.checked = savedTheme === 'light';
                }

                // Añadir evento al botón
                if (themeToggle) {
                    themeToggle.addEventListener('change', toggleTheme);
                }
            });
        </script>

        @stack('scripts')
    </body>
</html>
