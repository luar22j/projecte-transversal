<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\Admin\InventarioController;
use App\Http\Controllers\Admin\DescuentoController;
use App\Http\Controllers\Admin\ProductoController;
use App\Http\Controllers\Admin\SubcategoriaController;
use App\Http\Controllers\UserDataController;

// Redirección de la ruta raíz a home
Route::get('/', function () {
    return redirect()->route('home');
});

// Rutas públicas (accesibles sin autenticación)
Route::middleware('guest')->group(function () {
    // Login
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // Registro
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
});

// Landing page (accesible para todos)
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Formulario de contacto
Route::post('/contact', [ContactController::class, 'store'])->name('contact.send');

// Rutas del marketplace (accesibles para todos)
Route::get('/marketplace', [MarketplaceController::class, 'index'])->name('marketplace');
Route::get('/marketplace/menus', [MarketplaceController::class, 'menus'])->name('marketplace.menus');
Route::get('/marketplace/burgers', [MarketplaceController::class, 'burgers'])->name('marketplace.burgers');
Route::get('/marketplace/bebidas', [MarketplaceController::class, 'bebidas'])->name('marketplace.bebidas');
Route::get('/marketplace/postres', [MarketplaceController::class, 'postres'])->name('marketplace.postres');

// Rutas del carrito
Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
Route::post('/carrito', [CarritoController::class, 'store'])->name('carrito.store');
Route::put('/carrito/{carrito}', [CarritoController::class, 'update'])->name('carrito.update');
Route::delete('/carrito/{carrito}', [CarritoController::class, 'destroy'])->name('carrito.destroy');
Route::delete('/carrito', [CarritoController::class, 'clear'])->name('carrito.clear');
Route::get('/carrito/items', [CarritoController::class, 'getItems'])->name('carrito.items');

// Rutas protegidas (requieren autenticación)
Route::middleware(['auth', 'verified'])->group(function () {
    // Perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    // Rutas de pedidos del cliente
    Route::prefix('cliente')->name('cliente.')->group(function () {
        Route::get('/pedidos', [App\Http\Controllers\Cliente\PedidoController::class, 'index'])->name('pedidos.index');
        Route::get('/pedidos/{pedido}', [App\Http\Controllers\Cliente\PedidoController::class, 'show'])->name('pedidos.show');
        Route::get('/pedidos/{pedido}/factura', [App\Http\Controllers\Cliente\PedidoController::class, 'descargarFactura'])->name('pedidos.factura');
        Route::post('/pedidos/{pedido}/cancelar', [App\Http\Controllers\Cliente\PedidoController::class, 'cancelar'])->name('pedidos.cancelar');
    });

    // Rutas de checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

    // Ruta para obtener datos del usuario
    Route::get('/user-data', [UserDataController::class, 'getUserData']);
});

// Rutas de verificación de email
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
});

// Legal
Route::get('/legal/cookies', function () {
    return view('legal.cookies');
})->name('legal.cookies');

Route::get('/legal/aviso-legal', function () {
    return view('legal.aviso-legal');
})->name('legal.aviso-legal');

Route::get('/legal/politica-privacidad', function () {
    return view('legal.politica-privacidad');
})->name('legal.politica-privacidad');

// Quienes somos
Route::get('/quienes-somos', function () {
    return view('pages.quienes-somos');
})->name('quienes-somos');

Route::get('/presentacion', function () {
    return view('pages.presentacion');
})->name('presentacion');

Route::get('/ubicacion', function () {
    return view('pages.ubicacion');
})->name('ubicacion');

Route::get('/contacto', function () {
    return view('pages.contacto');
})->name('contacto');

Route::get('/consulta', function () {
    return view('pages.consulta');
})->name('consulta');

Route::get('/search', function () {
    return view('pages.search');
})->name('search');

Route::get('/searchEmails', [AjaxController::class, 'getEmails'])->name('pages.emailSearch');

// Rutas del panel de administración
Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/data', [App\Http\Controllers\Admin\DashboardController::class, 'getData'])->name('dashboard.data');
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    Route::resource('categorias', App\Http\Controllers\Admin\CategoriaController::class);
    Route::resource('subcategorias', SubcategoriaController::class);
    
    // Rutas de productos
    Route::prefix('productos')->name('productos.')->group(function () {
        Route::get('/', [ProductoController::class, 'index'])->name('index');
        Route::get('/create', [ProductoController::class, 'create'])->name('create');
        Route::post('/', [ProductoController::class, 'store'])->name('store');
        Route::get('/{producto}/edit', [ProductoController::class, 'edit'])->name('edit');
        Route::put('/{producto}', [ProductoController::class, 'update'])->name('update');
        Route::delete('/{producto}', [ProductoController::class, 'destroy'])->name('destroy');
        
        // Rutas AJAX
        Route::put('/{producto}/precio', [ProductoController::class, 'updatePrecio'])->name('update.precio');
        Route::put('/{producto}/stock', [ProductoController::class, 'updateStock'])->name('update.stock');
        Route::put('/{producto}/subcategoria', [ProductoController::class, 'updateSubcategoria'])->name('update.subcategoria');
    });

    // Rutas de pedidos
    Route::get('/pedidos', [App\Http\Controllers\Admin\PedidoController::class, 'index'])->name('pedidos.index');
    Route::get('/pedidos/listar', [App\Http\Controllers\Admin\PedidoController::class, 'listar'])->name('pedidos.listar');
    Route::get('/pedidos/{pedido}', [App\Http\Controllers\Admin\PedidoController::class, 'show'])->name('pedidos.show');
    Route::put('/pedidos/{pedido}/estado', [App\Http\Controllers\Admin\PedidoController::class, 'actualizarEstado'])->name('pedidos.actualizar-estado');

    // Rutas de inventario
    Route::prefix('inventario')->name('inventario.')->group(function () {
        Route::get('/', [InventarioController::class, 'index'])->name('index');
        Route::put('/{producto}/stock', [InventarioController::class, 'actualizarStock'])->name('stock.update');
        Route::get('/agotados', [InventarioController::class, 'productosAgotados'])->name('agotados');
        Route::get('/mas-vendidos', [InventarioController::class, 'masVendidos'])->name('mas-vendidos');
        Route::get('/estadisticas', [InventarioController::class, 'getEstadisticas'])->name('estadisticas');
        Route::get('/{producto}', [InventarioController::class, 'show'])->name('show');
    });

    // Rutas de descuentos
    Route::get('/descuentos', [DescuentoController::class, 'index'])->name('descuentos.index');
    Route::get('/descuentos/create', [DescuentoController::class, 'create'])->name('descuentos.create');
    Route::post('/descuentos', [DescuentoController::class, 'store'])->name('descuentos.store');
    Route::get('/descuentos/{descuento}/edit', [DescuentoController::class, 'edit'])->name('descuentos.edit');
    Route::put('/descuentos/{descuento}', [DescuentoController::class, 'update'])->name('descuentos.update');
    Route::delete('/descuentos/{descuento}', [DescuentoController::class, 'destroy'])->name('descuentos.destroy');
    Route::patch('/descuentos/{descuento}/toggle-activo', [DescuentoController::class, 'toggleActivo'])->name('descuentos.toggle-activo');

    // Ruta del gráfico de ventas
    Route::get('/grafico/ventas', [App\Http\Controllers\Admin\GraficoController::class, 'ventas'])->name('grafico.ventas');

    // Rutas AJAX para productos y subcategorías
    Route::prefix('ajax')->name('ajax.')->group(function () {
        // Rutas de productos
        Route::put('/productos/{producto}/stock', [AjaxController::class, 'updateStock'])->name('productos.stock');
        Route::put('/productos/{producto}/precio', [AjaxController::class, 'updatePrecio'])->name('productos.precio');
        Route::delete('/productos/{producto}', [AjaxController::class, 'deleteProducto'])->name('productos.delete');
        Route::put('/productos/{producto}/subcategoria', [ProductoController::class, 'updateSubcategoria'])->name('productos.subcategoria');
        
        // Rutas de subcategorías
        Route::put('/subcategorias/{subcategoria}/categoria', [AjaxController::class, 'updateSubcategoriaCategoria'])->name('subcategorias.categoria');
    });
});