<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductDatasheetController;
use App\Http\Controllers\Admin\ProductDataController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\InventoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome_new');
});

// Rutas públicas
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

// Rutas de productos y noticias (públicas)
Route::get('/productos', [ProductController::class, 'index'])->name('products.index');
Route::get('/productos/{product:slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/productos/{product:slug}/ficha-tecnica', [ProductDatasheetController::class, 'downloadDatasheet'])->name('products.datasheet.download');
Route::get('/productos/{product:slug}/ficha-tecnica/view', [ProductDatasheetController::class, 'viewDatasheet'])->name('products.datasheet.view');
Route::get('/noticias', [NewsController::class, 'index'])->name('news.index');
Route::get('/noticias/{news:slug}', [NewsController::class, 'show'])->name('news.show');

// Calculadora
Route::get('/calculadora', [CalculatorController::class, 'index'])->name('calculator.index');
Route::post('/calculadora/calcular', [CalculatorController::class, 'calculate'])->name('calculator.calculate');

// Contacto
Route::get('/contacto', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contacto', [ContactController::class, 'store'])->name('contact.store');

// Vista previa pública de cotización (permite ver el formulario y resumen sin estar autenticado)
Route::get('/cotizaciones/preview', [QuotationController::class, 'preview'])->name('quotations.preview');

// API pública para obtener sugerencias de datos de productos
Route::get('/api/product-suggestions/{productName}', function ($productName) {
    $scraperService = new \App\Services\ProductDataScraperService();
    $suggestions = $scraperService->getProductData($productName) ?? $scraperService->getCommonProductsDatabase();
    
    return response()->json([
        'success' => !empty($suggestions),
        'data' => $suggestions ?? null,
        'message' => $suggestions ? 'Datos sugeridos encontrados' : 'No hay datos predefinidos para este producto'
    ]);
});

// Rutas protegidas para usuarios autenticados
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Carrito
    Route::get('/carrito', [CartController::class, 'index'])->name('cart.index');
    Route::post('/carrito/agregar', [CartController::class, 'addToCart'])->name('cart.add');
    Route::put('/carrito/{cart}/cantidad', [CartController::class, 'updateQuantity'])->name('cart.update');
    Route::delete('/carrito/{cart}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/carrito/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

    // Cotizaciones
    Route::get('/cotizaciones', [QuotationController::class, 'index'])->name('quotations.index');
    Route::get('/cotizaciones/crear', [QuotationController::class, 'create'])->name('quotations.create');
    Route::post('/cotizaciones', [QuotationController::class, 'store'])->name('quotations.store');
    Route::get('/cotizaciones/{quotation}', [QuotationController::class, 'show'])->name('quotations.show');

    // Dashboard de cliente
    Route::get('/client/dashboard', function () {
        $quotations = auth()->user()->quotations()->with('items.product')->latest()->limit(5)->get();
        $stats = [
            'total_quotations' => auth()->user()->quotations()->count(),
            'pending_quotations' => auth()->user()->quotations()->where('status', 'pendiente')->count(),
            'accepted_quotations' => auth()->user()->quotations()->where('status', 'aceptada')->count(),
            'rejected_quotations' => auth()->user()->quotations()->where('status', 'rechazada')->count(),
        ];
        return view('client.dashboard', compact('quotations', 'stats'));
    })->name('client.dashboard');

    // Dashboard de administrador (protegido)
    Route::middleware('admin')->prefix('/admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'dashboard'])->name('dashboard');

        // Productos
        Route::get('/productos', [AdminDashboardController::class, 'products'])->name('products');
        Route::get('/productos/crear', [AdminDashboardController::class, 'createProduct'])->name('products.create');
        Route::post('/productos', [AdminDashboardController::class, 'storeProduct'])->name('products.store');
        Route::get('/productos/{product}/editar', [AdminDashboardController::class, 'editProduct'])->name('products.edit');
        Route::put('/productos/{product}', [AdminDashboardController::class, 'updateProduct'])->name('products.update');
        Route::delete('/productos/{product}', [AdminDashboardController::class, 'deleteProduct'])->name('products.delete');
        Route::get('/api/productos/data-suggestions', [ProductDataController::class, 'getSuggestions'])->name('products.data-suggestions');

        // Categorías
        Route::get('/categorias', [AdminDashboardController::class, 'categories'])->name('categories');
        Route::get('/categorias/crear', [AdminDashboardController::class, 'createCategory'])->name('categories.create');
        Route::post('/categorias', [AdminDashboardController::class, 'storeCategory'])->name('categories.store');
        Route::get('/categorias/{category}/editar', [AdminDashboardController::class, 'editCategory'])->name('categories.edit');
        Route::put('/categorias/{category}', [AdminDashboardController::class, 'updateCategory'])->name('categories.update');
        Route::delete('/categorias/{category}', [AdminDashboardController::class, 'deleteCategory'])->name('categories.delete');

        // Noticias
        Route::get('/noticias', [AdminDashboardController::class, 'news'])->name('news');
        Route::get('/noticias/crear', [AdminDashboardController::class, 'createNews'])->name('news.create');
        Route::post('/noticias', [AdminDashboardController::class, 'storeNews'])->name('news.store');
        Route::get('/noticias/{news}/editar', [AdminDashboardController::class, 'editNews'])->name('news.edit');
        Route::put('/noticias/{news}', [AdminDashboardController::class, 'updateNews'])->name('news.update');
        Route::delete('/noticias/{news}', [AdminDashboardController::class, 'deleteNews'])->name('news.delete');

        // Cotizaciones
        Route::get('/cotizaciones', [AdminDashboardController::class, 'quotations'])->name('quotations');
        Route::get('/cotizaciones/{quotation}', [AdminDashboardController::class, 'viewQuotation'])->name('quotations.show');
        Route::patch('/cotizaciones/{quotation}', [AdminDashboardController::class, 'updateQuotationStatus'])->name('quotations.update');
        Route::post('/cotizaciones/{quotation}/aprobar', [AdminDashboardController::class, 'approveQuotation'])->name('quotations.approve');
        Route::post('/cotizaciones/{quotation}/rechazar', [AdminDashboardController::class, 'rejectQuotation'])->name('quotations.reject');

        // Usuarios
        Route::get('/usuarios', [AdminDashboardController::class, 'users'])->name('users');
        Route::delete('/usuarios/{user}', [AdminDashboardController::class, 'deleteUser'])->name('users.delete');

        // Mensajes de Contacto
        Route::get('/mensajes', [MessageController::class, 'index'])->name('messages.index');
        Route::get('/mensajes/{message}', [MessageController::class, 'show'])->name('messages.show');
        Route::delete('/mensajes/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');
        Route::patch('/mensajes/{message}/leer', [MessageController::class, 'markAsRead'])->name('messages.mark-read');
        Route::patch('/mensajes/{message}/no-leer', [MessageController::class, 'markAsUnread'])->name('messages.mark-unread');

        // Inventario
        Route::get('/inventario', [InventoryController::class, 'index'])->name('inventory.index');
        Route::get('/inventario/crear', [InventoryController::class, 'create'])->name('inventory.create');
        Route::post('/inventario', [InventoryController::class, 'store'])->name('inventory.store');
        Route::get('/inventario/alertas', [InventoryController::class, 'alerts'])->name('inventory.alerts');
        Route::get('/inventario/stock/{product}', [InventoryController::class, 'getStock'])->name('inventory.stock');

        // Entradas y Salidas (Transacciones)
        Route::get('/transacciones', [\App\Http\Controllers\Admin\TransactionController::class, 'index'])->name('transactions.index');
        Route::post('/transacciones/entrada', [\App\Http\Controllers\Admin\TransactionController::class, 'storeEntry'])->name('transactions.entry');
        Route::post('/transacciones/salida', [\App\Http\Controllers\Admin\TransactionController::class, 'storeExit'])->name('transactions.exit');
        Route::get('/transacciones/historial', [\App\Http\Controllers\Admin\TransactionController::class, 'history'])->name('transactions.history');

        // Punto de Venta (POS)
        Route::get('/pos', [\App\Http\Controllers\Admin\POSController::class, 'index'])->name('pos.index');
        Route::post('/pos/procesar', [\App\Http\Controllers\Admin\POSController::class, 'processSale'])->name('pos.process');
        Route::get('/pos/recibo/{sale}', [\App\Http\Controllers\Admin\POSController::class, 'receipt'])->name('pos.receipt');
        Route::get('/pos/ventas', [\App\Http\Controllers\Admin\POSController::class, 'sales'])->name('pos.sales');
        Route::get('/pos/ventas/{sale}', [\App\Http\Controllers\Admin\POSController::class, 'showSale'])->name('pos.show');

        // Reportes
        Route::get('/reportes', [AdminDashboardController::class, 'reports'])->name('reports');
    });
});

