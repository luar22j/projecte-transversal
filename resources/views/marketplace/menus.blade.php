@extends('layouts.app')

@section('title', 'Menús')

@section('description', 'Nuestros menús especiales')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Productos -->
            <div class="lg:col-span-3">
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach($productos as $producto)
                        <x-marketplace.card-template 
                            :producto="$producto"
                            :nombre="$producto->nombre"
                            :precio="'€' . number_format($producto->precio, 2)"
                            :imagen="$producto->imagen"
                            :descripcion="$producto->descripcion"
                            :ingredientes="json_decode($producto->ingredientes, true) ?? []"
                            :producto_id="$producto->id"
                        />
                    @endforeach
                </div>
            </div>

            <!-- Sidebar del carrito -->
            <div class="lg:col-span-1">
                <div class="sticky top-4">
                    <x-marketplace.sidebar />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection