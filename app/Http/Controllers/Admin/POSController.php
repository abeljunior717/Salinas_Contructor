<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\InventoryMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

/**
 * Controlador del Punto de Venta (POS)
 * 
 * Gestiona todas las operaciones relacionadas con el sistema de ventas:
 * - Interfaz de punto de venta
 * - Procesamiento de ventas
 * - Generación de recibos
 * - Historial de ventas
 * - Actualización automática de inventario
 * 
 * @package App\Http\Controllers\Admin
 * @author Abel Luna Pérez
 * @version 1.0
 */
class POSController extends Controller
{
    /**
     * Mostrar interfaz de punto de venta
     * 
     * Carga todos los productos activos con stock disponible
     * y las categorías para el sistema de filtrado.
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Obtener productos activos con stock disponible
        $products = Product::where('is_active', true)
            ->where('stock_quantity', '>', 0)
            ->with('category')
            ->orderBy('name')
            ->get();

        // Obtener categorías activas con conteo de productos
        $categories = \App\Models\Category::where('is_active', true)
            ->withCount('products')
            ->get();

        return view('admin.pos.index', compact('products', 'categories'));
    }

    /**
     * Procesar venta
     * 
     * Registra una nueva venta en el sistema realizando:
     * 1. Validación de datos y stock disponible
     * 2. Creación del registro de venta
     * 3. Registro de items vendidos
     * 4. Actualización automática de inventario
     * 5. Registro de movimiento de inventario
     * 
     * @param Request $request Datos de la venta
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processSale(Request $request)
    {
        // Validar datos de entrada
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|in:efectivo,tarjeta,transferencia',
            'customer_name' => 'nullable|string|max:255',
            'customer_phone' => 'nullable|string|max:20',
        ]);

        try {
            // Iniciar transacción para garantizar integridad de datos
            DB::beginTransaction();

            // Validar stock disponible para todos los productos
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                if ($product->stock_quantity < $item['quantity']) {
                    return back()->withErrors([
                        'error' => "Stock insuficiente para {$product->name}. Disponible: {$product->stock_quantity}"
                    ]);
                }
            }

            // Calcular subtotal sumando precio * cantidad de cada item
            $subtotal = 0;
            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);
                $subtotal += $product->price * $item['quantity'];
            }

            // Calcular impuestos y total
            $tax = $subtotal * 0.19; // IVA 19%
            $total = $subtotal + $tax;

            // Crear registro de venta con folio único
            $sale = Sale::create([
                'user_id' => Auth::id(),
                'sale_number' => $this->generateSaleNumber(),
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'subtotal' => $subtotal,
                'tax_amount' => $tax,
                'total_amount' => $total,
                'payment_method' => $request->payment_method,
                'status' => 'completada',
            ]);

            // Procesar cada item: crear registro, actualizar inventario y registrar movimiento
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);

                // Crear item de venta (detalle del producto vendido)
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                    'line_total' => $product->price * $item['quantity'],
                ]);

                // Registrar movimiento de inventario (salida por venta)
                $stockBefore = $product->stock_quantity;
                $stockAfter = $stockBefore - $item['quantity'];

                InventoryMovement::create([
                    'product_id' => $product->id,
                    'user_id' => Auth::id(),
                    'type' => 'salida',
                    'quantity' => $item['quantity'],
                    'stock_before' => $stockBefore,
                    'stock_after' => $stockAfter,
                    'reason' => "Venta #{$sale->sale_number}",
                ]);

                // Actualizar stock del producto (decrementar cantidad vendida)
                $product->decrement('stock_quantity', $item['quantity']);
            }

            // Confirmar transacción
            DB::commit();

            return redirect()->route('admin.pos.receipt', $sale->id)
                ->with('success', 'Venta procesada exitosamente');

        } catch (\Exception $e) {
            // Revertir cambios en caso de error
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al procesar la venta: ' . $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Mostrar recibo de venta
     * 
     * Genera la vista del recibo con todos los detalles de la venta
     * incluyendo items, totales y datos del cliente.
     * 
     * @param int $id ID de la venta
     * @return \Illuminate\View\View
     */
    public function receipt($id)
    {
        // Cargar venta con relaciones (items, productos y usuario)
        $sale = Sale::with(['items.product', 'user'])
            ->findOrFail($id);

        return view('admin.pos.receipt', compact('sale'));
    }

    /**
     * Historial de ventas
     * 
     * Muestra el listado completo de ventas con filtros opcionales
     * por fecha y método de pago. Incluye estadísticas generales.
     * 
     * @param Request $request Parámetros de filtrado
     * @return \Illuminate\View\View
     */
    public function sales(Request $request)
    {
        // Query base: ventas con relaciones, ordenadas por fecha descendente
        $query = Sale::with(['user', 'items'])
            ->orderBy('created_at', 'desc');

        // Aplicar filtros opcionales
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        // Paginar resultados (15 por página)
        $sales = $query->paginate(15);

        // Calcular estadísticas generales
        $stats = [
            'total_sales' => Sale::count(),
            'total_revenue' => Sale::sum('total_amount'),
            'today_sales' => Sale::whereDate('created_at', today())->count(),
            'today_revenue' => Sale::whereDate('created_at', today())->sum('total_amount'),
        ];

        return view('admin.pos.sales', compact('sales', 'stats'));
    }

    /**
     * Ver detalle de venta específica
     * 
     * Muestra información completa de una venta individual
     * incluyendo todos los items, totales y datos del cliente.
     * 
     * @param int $id ID de la venta
     * @return \Illuminate\View\View
     */
    public function showSale($id)
    {
        // Cargar venta con todas sus relaciones
        $sale = Sale::with(['items.product', 'user'])
            ->findOrFail($id);

        return view('admin.pos.show', compact('sale'));
    }

    /**
     * Buscar productos para POS (API JSON)
     * 
     * Endpoint para búsqueda dinámica de productos en el POS.
     * Busca por nombre o SKU en productos activos con stock.
     * 
     * @param Request $request Query de búsqueda
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchProducts(Request $request)
    {
        $search = $request->get('q', '');

        // Buscar productos activos con stock por nombre o SKU
        $products = Product::where('is_active', true)
            ->where('stock_quantity', '>', 0)
            ->where(function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('sku', 'like', "%{$search}%");
            })
            ->with('category')
            ->limit(10)
            ->get();

        return response()->json($products);
    }

    /**
     * Generar número de venta único
     * 
     * Genera un folio único para cada venta con el formato:
     * VTA-YYYYMMDD-####
     * 
     * Donde:
     * - VTA: Prefijo fijo para ventas
     * - YYYYMMDD: Fecha actual (año-mes-día)
     * - ####: Número secuencial del día (con padding de 4 dígitos)
     * 
     * Ejemplo: VTA-20251207-0001
     * 
     * @return string Número de venta único
     */
    private function generateSaleNumber()
    {
        // Contar ventas del día actual y generar siguiente número
        $count = Sale::whereDate('created_at', today())->count() + 1;
        
        // Formato: VTA-YYYYMMDD-#### (ej: VTA-20251207-0001)
        return 'VTA-' . date('Ymd') . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }
}
