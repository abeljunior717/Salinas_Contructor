<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\InventoryMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

/**
 * Controlador de Transacciones de Inventario
 * 
 * Gestiona el control de entradas y salidas de mercancía:
 * - Registro de entradas (nuevas compras, devoluciones)
 * - Registro de salidas (ventas, mermas, transferencias)
 * - Historial completo de movimientos
 * - Estadísticas en tiempo real
 * - Validación de stock disponible
 * 
 * @package App\Http\Controllers\Admin
 * @author Abel Luna Pérez
 * @version 1.0
 */
class TransactionController extends Controller
{
    /**
     * Mostrar página principal de entradas y salidas
     * 
     * Presenta dos paneles (entrada verde/salida roja) con selectores
     * de productos organizados por categoría, estadísticas del día
     * y los últimos 10 movimientos registrados.
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Obtener productos activos con sus categorías
        $products = Product::where('is_active', true)
            ->with('category')
            ->orderBy('name')
            ->get();

        // Obtener categorías activas para organización
        $categories = \App\Models\Category::where('is_active', true)->get();

        // Últimos 10 movimientos de inventario
        $recentMovements = InventoryMovement::with(['product', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Calcular estadísticas generales
        $stats = [
            'total_entradas' => InventoryMovement::where('type', 'entrada')->sum('quantity'),
            'total_salidas' => InventoryMovement::where('type', 'salida')->sum('quantity'),
            'total_ajustes' => InventoryMovement::where('type', 'ajuste')->count(),
            'movimientos_hoy' => InventoryMovement::whereDate('created_at', today())->count(),
        ];

        return view('admin.transactions.index', compact('products', 'categories', 'recentMovements', 'stats'));
    }

    /**
     * Procesar entrada de productos
     * 
     * Registra una entrada de mercancía al inventario:
     * 1. Valida los datos de entrada
     * 2. Crea el registro de movimiento
     * 3. Actualiza el stock del producto
     * 4. Registra stock antes y después del movimiento
     * 
     * @param Request $request Datos del movimiento
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeEntry(Request $request)
    {
        // Validar datos de entrada
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'reason' => 'nullable|string|max:500',
        ]);

        try {
            // Iniciar transacción para integridad de datos
            DB::beginTransaction();

            $product = Product::findOrFail($request->product_id);
            $stockBefore = $product->stock_quantity;
            $stockAfter = $stockBefore + $request->quantity;

            // Crear registro de movimiento (entrada)
            InventoryMovement::create([
                'product_id' => $product->id,
                'user_id' => Auth::id(),
                'type' => 'entrada',
                'quantity' => $request->quantity,
                'stock_before' => $stockBefore,
                'stock_after' => $stockAfter,
                'reason' => $request->reason ?? 'Entrada manual',
            ]);

            // Incrementar stock del producto
            $product->increment('stock_quantity', $request->quantity);

            // Confirmar transacción
            DB::commit();

            return redirect()->back()->with('success', 'Entrada registrada correctamente');

        } catch (\Exception $e) {
            // Revertir cambios en caso de error
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al registrar entrada: ' . $e->getMessage()]);
        }
    }

    /**
     * Procesar salida de productos
     * 
     * Registra una salida de mercancía del inventario:
     * 1. Valida los datos de entrada
     * 2. Verifica que hay stock suficiente
     * 3. Crea el registro de movimiento
     * 4. Actualiza el stock del producto
     * 5. Registra stock antes y después del movimiento
     * 
     * @param Request $request Datos del movimiento
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeExit(Request $request)
    {
        // Validar datos de entrada
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'reason' => 'nullable|string|max:500',
        ]);

        try {
            // Iniciar transacción para integridad de datos
            DB::beginTransaction();

            $product = Product::findOrFail($request->product_id);
            $stockBefore = $product->stock_quantity;

            // Validar que hay stock suficiente para la salida
            if ($stockBefore < $request->quantity) {
                return back()->withErrors([
                    'error' => "Stock insuficiente. Disponible: {$stockBefore}, Solicitado: {$request->quantity}"
                ]);
            }

            $stockAfter = $stockBefore - $request->quantity;

            // Crear registro de movimiento (salida)
            InventoryMovement::create([
                'product_id' => $product->id,
                'user_id' => Auth::id(),
                'type' => 'salida',
                'quantity' => $request->quantity,
                'stock_before' => $stockBefore,
                'stock_after' => $stockAfter,
                'reason' => $request->reason ?? 'Salida manual',
            ]);

            // Decrementar stock del producto
            $product->decrement('stock_quantity', $request->quantity);

            // Confirmar transacción
            DB::commit();

            return redirect()->back()->with('success', 'Salida registrada correctamente');

        } catch (\Exception $e) {
            // Revertir cambios en caso de error
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al registrar salida: ' . $e->getMessage()]);
        }
    }

    /**
     * Historial de movimientos con filtros avanzados
     * 
     * Muestra el historial completo de movimientos de inventario
     * con capacidad de filtrado por:
     * - Tipo de movimiento (entrada/salida/ajuste)
     * - Producto específico
     * - Rango de fechas
     * 
     * Incluye estadísticas del mes y valor total del inventario.
     * 
     * @param Request $request Parámetros de filtrado
     * @return \Illuminate\View\View
     */
    public function history(Request $request)
    {
        // Query base: movimientos con relaciones
        $query = InventoryMovement::with(['product', 'user']);

        // Aplicar filtros opcionales
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Ordenar por fecha descendente y paginar (20 por página)
        $movements = $query->orderBy('created_at', 'desc')->paginate(20);

        // Obtener productos para selector de filtros
        $products = Product::where('is_active', true)
            ->orderBy('name')
            ->get();

        // Calcular estadísticas del mes y valor total de inventario
        $stats = [
            'total_movimientos' => InventoryMovement::count(),
            'entradas_mes' => InventoryMovement::where('type', 'entrada')
                ->whereMonth('created_at', now()->month)
                ->sum('quantity'),
            'salidas_mes' => InventoryMovement::where('type', 'salida')
                ->whereMonth('created_at', now()->month)
                ->sum('quantity'),
            'valor_inventario' => Product::where('is_active', true)
                ->selectRaw('SUM(stock_quantity * price) as total')
                ->first()->total ?? 0,
        ];

        return view('admin.transactions.history', compact('movements', 'products', 'stats'));
    }
}
