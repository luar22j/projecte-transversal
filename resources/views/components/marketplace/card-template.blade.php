@props(['nombre', 'precio', 'imagen', 'descripcion', 'ingredientes' => [], 'producto_id', 'producto'])

@vite(['resources/js/marketplace/card-template.js']) 

<div onclick="mostrarDetalles('{{ $nombre }}', '{{ $precio }}', '{{ $imagen }}', '{{ addslashes($descripcion) }}', {{ json_encode($ingredientes ?? []) }}, {{ $producto_id }})" 
     class="flex flex-col gap-2 justify-between items-center p-5 bg-[#1a323e] rounded-xl shadow cursor-pointer hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300">
    <div class="flex flex-col items-center">
        <h2 class="text-xl font-bold text-center text-white">{{ $nombre }}</h2>
        <p class="text-sm mt-2 text-gray-200">
                @if($producto->descuento_activo)
                    <div class="flex items-center text-gray-200 gap-2">
                        <span class="line-through text-gray-400">€{{ number_format($producto->precio, 2) }}</span>
                        <span class="text-green-400 ml-2">€{{ number_format($producto->precio_con_descuento, 2) }}</span>
                        <span class="bg-[#F3C71E] text-[#1A323E] px-2 py-1 mx-2 rounded-full text-xs ml-2">
                            -{{ $producto->descuento_activo->porcentaje }}%
                        </span>
                    </div>
                @else
                    €{{ number_format($producto->precio, 2) }}
                @endif
            <span class="text-gray-200">(IVA incluido)</span>
        </p>
    </div>

    <div class="flex items-center justify-center h-[200px]">
        <img class="w-[200px] h-[200px] object-contain" src="{{ asset('images/' . $imagen) }}" alt="{{ $nombre }}">
    </div>

    <div class="flex flex-col items-center justify-end gap-3 w-full">
        @if($producto->stock > 0)
            <div class="flex items-center gap-2">
                <button type="button" onclick="event.stopPropagation(); decrementarCantidad(this)" class="bg-[#F3C71E] hover:bg-[#f4cf3c] rounded-full w-8 h-8 flex items-center justify-center transition-colors">
                    <span class="text-[#1A323E] font-bold text-lg">-</span>
                </button>
                <input type="number" min="1" max="{{ $producto->stock }}" value="1" onclick="event.stopPropagation()" class="w-10 text-center rounded-lg bg-gray-700 text-white [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                <button type="button" onclick="event.stopPropagation(); incrementarCantidad(this)" class="bg-[#F3C71E] hover:bg-[#f4cf3c] rounded-full w-8 h-8 flex items-center justify-center transition-colors">
                    <span class="text-[#1A323E] font-bold text-lg">+</span>
                </button>
            </div>
            <button type="button" 
                    onclick="event.stopPropagation(); window.cart.addItem({
                        id: {{ $producto_id }},
                        nombre: '{{ $nombre }}',
                        precio: {{ $producto->descuento_activo ? $producto->precio_con_descuento : $producto->precio }},
                        imagen: '{{ $imagen }}',
                        cantidad: parseInt(this.parentElement.querySelector('input[type=number]').value),
                        descuento: {{ $producto->descuento_activo ? $producto->descuento_activo->porcentaje : 0 }}
                    })" 
                    class="w-full uppercase bg-[#F3C71E] rounded-full text-[#1A323E] py-2 px-6 shadow hover:shadow-md hover:bg-[#f4cf3c] transition-all duration-300">
                Añadir al Carrito
            </button>
        @else
            <div class="text-red-500 font-semibold">Sin Stock</div>
            <button type="button" 
                    disabled
                    class="w-full uppercase bg-gray-500 rounded-full text-white py-2 px-6 cursor-not-allowed">
                No Disponible
            </button>
        @endif
    </div>
</div>