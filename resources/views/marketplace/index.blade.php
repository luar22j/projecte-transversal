@extends('layouts.app')

@section('title', 'Marketplace')

@section('description', 'Nuestro catálogo de productos')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Categorías -->
            <div class="md:col-span-2">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Menús -->
                    <a href="{{ route('marketplace.menus') }}" class="bg-[#1A323E] text-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-all duration-300">
                        <div class="p-6">
                            <img src="{{ asset('images/marketplace/menu.png') }}" alt="Menús" class="w-full object-cover rounded-lg mb-4">
                            <h3 class="text-lg font-semibold text-white mb-2">Menús</h3>
                            <p class="text-gray-200">Nuestros menús especiales con las mejores combinaciones</p>
                        </div>
                    </a>

                    <!-- Hamburguesas -->
                    <a href="{{ route('marketplace.burgers') }}" class="bg-[#1A323E] text-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-all duration-300">
                        <div class="p-6">
                            <img src="{{ asset('images/marketplace/burger.png') }}" alt="Hamburguesas" class="w-full object-cover rounded-lg mb-4">
                            <h3 class="text-lg font-semibold text-white mb-2">Hamburguesas</h3>
                            <p class="text-gray-200">Nuestras deliciosas hamburguesas artesanales</p>
                        </div>
                    </a>

                    <!-- Bebidas -->
                    <a href="{{ route('marketplace.bebidas') }}" class="bg-[#1A323E] text-white     overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-all duration-300">
                        <div class="p-6">
                            <img src="{{ asset('images/marketplace/drink.png') }}" alt="Bebidas" class="w-full object-cover rounded-lg mb-4">
                            <h3 class="text-lg font-semibold text-white mb-2">Bebidas</h3>
                            <p class="text-gray-200">Refrescantes bebidas para acompañar tu comida</p>
                        </div>
                    </a>

                    <!-- Postres -->
                    <a href="{{ route('marketplace.postres') }}" class="bg-[#1A323E] text-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-all duration-300">
                        <div class="p-6">
                            <img src="{{ asset('images/marketplace/dessert.png') }}" alt="Postres" class="w-full object-cover rounded-lg mb-4">
                            <h3 class="text-lg font-semibold text-white mb-2">Postres</h3>
                            <p class="text-gray-200">Dulces postres para endulzar tu día</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Sidebar del carrito -->
            <div class="md:col-span-1">
                <x-marketplace.sidebar />
            </div>
        </div>
    </div>
</div>
@endsection 