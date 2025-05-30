<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Burgers & Roll - Panel de Administración</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/icon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/admin.css','resources/css/app.css', 'resources/js/app.js'])
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>
<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
    <div class="min-h-screen">
        <!-- Barra de navegación superior -->
        <nav class="bg-white dark:bg-gray-800 border-b border-[#F3C71E] border-opacity-20 fixed w-full z-30">
            <div class="mx-auto px-4 sm:px-6 lg:px-8">
                <div class="header-admin flex justify-between h-16">
                    <div class="flex items-center">
                        <!-- Botón del menú móvil -->
                        <button id="sidebarToggle" class="lg:hidden p-2 rounded-md text-[#1A323E] dark:text-white hover:bg-[#F3C71E] hover:bg-opacity-10 focus:outline-none">
                            <i class="fas fa-bars"></i>
                        </button>
                        <!-- Logo -->
                        <div class="shrink-0 flex items-center ml-2 lg:ml-0">
                            <a href="{{ route('admin.dashboard') }}" class="text-[#1A323E] dark:text-white font-bold text-xl">
                                Burgers & Roll Admin
                            </a>
                        </div>
                    </div>

                    <!-- Enlaces de navegación -->
                    <div class="flex items-center space-x-2 sm:space-x-4 justify-center">
                        <a href="{{ route('home') }}" class="inline-flex items-center p-2 sm:px-4 sm:py-2 bg-[#F3C71E] bg-opacity-10 hover:bg-opacity-20 text-[#1A323E] dark:text-white rounded-lg transition-colors">
                            <i class="fas fa-home"></i>
                            <span class="hidden sm:inline ml-2">Inicio</span>
                        </a>
                        <a href="{{ route('marketplace') }}" class="inline-flex items-center p-2 sm:px-4 sm:py-2 bg-[#F3C71E] bg-opacity-10 hover:bg-opacity-20 text-[#1A323E] dark:text-white rounded-lg transition-colors">
                            <i class="fas fa-store"></i>
                            <span class="hidden sm:inline ml-2">Marketplace</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center p-2 sm:px-4 sm:py-2 bg-red-100 hover:bg-red-200 text-red-800 dark:bg-red-900/30 dark:hover:bg-red-900/50 dark:text-red-400 rounded-lg transition-colors">
                                <i class="fas fa-sign-out-alt"></i>
                                <span class="hidden sm:inline ml-2">Cerrar Sesión</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Sidebar -->
        <aside id="sidebar" class="fixed inset-y-0 left-0 w-64 bg-white dark:bg-gray-800 border-r border-[#F3C71E] border-opacity-20 pt-16 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out z-20">
            <nav class="mt-5 px-2">
                <a href="{{ route('admin.dashboard') }}" class="group flex items-center px-2 py-2 text-base font-medium rounded-md text-[#1A323E] dark:text-white hover:bg-[#F3C71E] hover:bg-opacity-10 transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-[#F3C71E] bg-opacity-10' : '' }}">
                    <i class="fas fa-home mr-4 text-[#F3C71E]"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="mt-1 group flex items-center px-2 py-2 text-base font-medium rounded-md text-[#1A323E] dark:text-white hover:bg-[#F3C71E] hover:bg-opacity-10 transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-[#F3C71E] bg-opacity-10' : '' }}">
                    <i class="fas fa-users mr-4 text-[#F3C71E]"></i>
                    <span>Usuarios</span>
                </a>
                <a href="{{ route('admin.productos.index') }}" class="mt-1 group flex items-center px-2 py-2 text-base font-medium rounded-md text-[#1A323E] dark:text-white hover:bg-[#F3C71E] hover:bg-opacity-10 transition-colors {{ request()->routeIs('admin.productos.*') ? 'bg-[#F3C71E] bg-opacity-10' : '' }}">
                    <i class="fas fa-box mr-4 text-[#F3C71E]"></i>
                    <span>Productos</span>
                </a>
                <a href="{{ route('admin.categorias.index') }}" class="mt-1 group flex items-center px-2 py-2 text-base font-medium rounded-md text-[#1A323E] dark:text-white hover:bg-[#F3C71E] hover:bg-opacity-10 transition-colors {{ request()->routeIs('admin.categorias.*') ? 'bg-[#F3C71E] bg-opacity-10' : '' }}">
                    <i class="fas fa-tags mr-4 text-[#F3C71E]"></i>
                    <span>Categorías</span>
                </a>
                <a href="{{ route('admin.descuentos.index') }}" class="mt-1 group flex items-center px-2 py-2 text-base font-medium rounded-md text-[#1A323E] dark:text-white hover:bg-[#F3C71E] hover:bg-opacity-10 transition-colors {{ request()->routeIs('admin.descuentos.*') ? 'bg-[#F3C71E] bg-opacity-10' : '' }}">
                    <i class="fas fa-tags mr-4 text-[#F3C71E]"></i>
                    <span>Descuentos</span>
                </a>
                <a href="{{ route('admin.inventario.index') }}" class="mt-1 group flex items-center px-2 py-2 text-base font-medium rounded-md text-[#1A323E] dark:text-white hover:bg-[#F3C71E] hover:bg-opacity-10 transition-colors {{ request()->routeIs('admin.inventario.*') ? 'bg-[#F3C71E] bg-opacity-10' : '' }}">
                    <i class="fas fa-warehouse mr-4 text-[#F3C71E]"></i>
                    <span>Inventario</span>
                </a>
                <a href="{{ route('admin.pedidos.index') }}" class="mt-1 group flex items-center px-2 py-2 text-base font-medium rounded-md text-[#1A323E] dark:text-white hover:bg-[#F3C71E] hover:bg-opacity-10 transition-colors {{ request()->routeIs('admin.pedidos.*') ? 'bg-[#F3C71E] bg-opacity-10' : '' }}">
                    <i class="fas fa-shopping-cart mr-4 text-[#F3C71E]"></i>
                    <span>Pedidos</span>
                </a>
                <a href="{{ route('admin.grafico.ventas') }}" class="mt-1 group flex items-center px-2 py-2 text-base font-medium rounded-md text-[#1A323E] dark:text-white hover:bg-[#F3C71E] hover:bg-opacity-10 transition-colors {{ request()->routeIs('admin.grafico.*') ? 'bg-[#F3C71E] bg-opacity-10' : '' }}">
                    <i class="fas fa-chart-bar mr-4 text-[#F3C71E]"></i>
                    <span>Ventas</span>
                </a>
            </nav>
        </aside>

        <!-- Overlay para móvil -->
        <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-10 hidden lg:hidden"></div>

        <!-- Main Content -->
        <main class="lg:pl-64 pt-16">
            <div class="py-6">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                    <div id="alert-container"></div>
                    @yield('content')
                </div>
            </div>
        </main>
    </div>

    <script defer>
        // Configuración global de Axios
        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

        // Función para mostrar alertas
        function showAlert(message, type = 'success') {
            const alertContainer = document.getElementById('alert-container');
            const alert = document.createElement('div');
            alert.className = `mb-4 p-4 rounded-lg ${
                type === 'success' 
                    ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400' 
                    : 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400'
            }`;
            alert.textContent = message;
            alertContainer.appendChild(alert);
            setTimeout(() => alert.remove(), 3000);
        }

        // Control del sidebar en móvil
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');

            function toggleSidebar() {
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
            }

            sidebarToggle.addEventListener('click', toggleSidebar);
            overlay.addEventListener('click', toggleSidebar);

            // Cerrar sidebar al cambiar de ruta en móvil
            document.querySelectorAll('aside a').forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth < 1024) {
                        toggleSidebar();
                    }
                });
            });
        });
    </script>

    @stack('scripts')
</body>
</html> 