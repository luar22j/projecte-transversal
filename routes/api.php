<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\InventarioController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductoController;
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Cliente\PedidoController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\UserDataController;
use Illuminate\Support\Facades\Auth;

// Rutas públicas
Route::get('/productos', [ProductoController::class, 'index']);
Route::get('/productos/{producto}', [ProductoController::class, 'show']);
Route::get('/categorias', [CategoriaController::class, 'index']);
Route::get('/categorias/{categoria}/subcategorias', [CategoriaController::class, 'subcategorias']);

Route::middleware(['auth:sanctum'])->group(function () {
    // Rutas de autenticación
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);

    // Rutas de carrito
    Route::get('/carrito/items', [CarritoController::class, 'getItems']);
    Route::post('/carrito', [CarritoController::class, 'store']);
    Route::put('/carrito/{carrito}', [CarritoController::class, 'update']);
    Route::delete('/carrito/{carrito}', [CarritoController::class, 'destroy']);
    Route::delete('/carrito', [CarritoController::class, 'clear']);

    // Rutas de pedidos
    Route::prefix('cliente')->group(function () {
        Route::get('/pedidos', [PedidoController::class, 'index']);
        Route::get('/pedidos/{pedido}', [PedidoController::class, 'show']);
        Route::post('/pedidos/{pedido}/cancelar', [PedidoController::class, 'cancelar']);
    });

    // Rutas de checkout
    Route::post('/checkout', [CheckoutController::class, 'store']);

    // Rutas de inventario
    Route::prefix('inventario')->group(function () {
        Route::get('/', [InventarioController::class, 'index']);
        Route::get('/agotados', [InventarioController::class, 'agotados']);
        Route::get('/mas-vendidos', [InventarioController::class, 'masVendidos']);
        Route::get('/ordenar/{campo}/{orden}', [InventarioController::class, 'ordenar']);
        Route::post('/actualizar-stock/{producto}', [InventarioController::class, 'actualizarStock']);
    });

    // Rutas de usuarios
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::post('/', [UserController::class, 'store']);
        Route::get('/{user}', [UserController::class, 'show']);
        Route::put('/{user}', [UserController::class, 'update']);
        Route::delete('/{user}', [UserController::class, 'destroy']);
    });

    // Ruta para obtener datos del usuario autenticado
    Route::get('/user-data', [UserDataController::class, 'getUserData']);

    // Rutas protegidas de productos
    Route::prefix('productos')->group(function () {
        Route::post('/', [ProductoController::class, 'store']);
        Route::put('/{producto}', [ProductoController::class, 'update']);
        Route::delete('/{producto}', [ProductoController::class, 'destroy']);
    });

    // Ruta para verificar la autenticación del usuario
    Route::get('/check-auth', function () {
        return response()->json([
            'authenticated' => Auth::check()
        ]);
    });
}); 