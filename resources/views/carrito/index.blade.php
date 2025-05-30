@extends('layouts.app')

@section('title', 'Carrito de Compras')

@section('description', 'Tu carrito de compras')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-[#1A323E] overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h1 class="text-2xl font-bold text-white mb-6">Carrito de Compras</h1>
                <div id="cart-container">
                    <!-- El contenido del carrito se cargará dinámicamente aquí -->
                    <div class="text-center">
                        <div class="spinner-border text-[#F3C71E]" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .cart-item {
        @apply bg-white rounded-xl shadow-sm p-4 mb-4 transition-all duration-300 hover:shadow-md;
    }

    .cart-item img {
        @apply h-24 object-cover rounded-lg;
    }

    .item-details h3 {
        @apply text-lg font-semibold text-[#1A323E];
    }

    .item-details p {
        @apply text-[#1A323E];
    }

    .quantity-controls {
        @apply flex items-center gap-2 flex-row;
    }

    .quantity-controls button {
        @apply bg-[#F3C71E] hover:bg-[#f4cf3c] text-[#1A323E] rounded-full w-8 h-8 flex items-center justify-center transition-colors;
    }

    .quantity-controls input {
        @apply w-12 text-center rounded-lg bg-white text-[#1A323E] border border-gray-200;
        -moz-appearance: textfield;
    }

    .quantity-controls input::-webkit-outer-spin-button,
    .quantity-controls input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .remove-item {
        @apply bg-red-500 hover:bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center transition-colors;
    }

    .cart-summary {
        @apply bg-white rounded-xl shadow-sm p-6 mt-6;
    }

    .cart-summary p {
        @apply text-xl font-semibold text-[#1A323E];
    }

    .clear-cart {
        @apply bg-gray-500 hover:bg-gray-600 text-white rounded-full px-6 py-2 transition-colors;
    }

    .checkout-button {
        @apply bg-[#F3C71E] hover:bg-[#f4cf3c] text-[#1A323E] rounded-full px-6 py-2 font-semibold transition-colors;
    }

    .notification {
        @apply fixed top-4 right-4 p-4 rounded-lg text-white z-50 shadow-lg;
        animation: slideIn 0.3s ease-out;
        background-color: #1A323E;
        border-left: 4px solid #F3C71E;
    }

    .notification.success {
        @apply bg-[#1A323E];
    }

    .notification.error {
        @apply bg-red-500;
    }

    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }

    .empty-cart {
        @apply text-center py-12;
    }

    .empty-cart p {
        @apply text-[#1A323E] mb-4;
    }

    .empty-cart a {
        @apply inline-block bg-[#F3C71E] hover:bg-[#f4cf3c] text-[#1A323E] rounded-full px-6 py-2 font-semibold transition-colors;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script defer>
    // Configuración de Axios
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (token) {
        axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    }
</script>
@endpush
@endsection 