@props(['producto'])

<form action="{{ route('carrito.store') }}" method="POST" class="inline">
    @csrf
    <input type="hidden" name="producto_id" value="{{ $producto->id }}">
    <input type="hidden" name="cantidad" value="1">
    <button type="submit" class="bg-[#F3C71E] hover:bg-[#f4cf3c] text-[#1A323E] font-bold py-2 px-4 rounded-full transition-all duration-300 shadow-md hover:shadow-lg flex items-center gap-2">
        <i class="fas fa-shopping-cart"></i>
        <span>Añadir al carrito</span>
    </button>
</form> 