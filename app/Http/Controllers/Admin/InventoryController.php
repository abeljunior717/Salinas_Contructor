<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InventoryMovement;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    /**
     * Mostrar historial de movimientos de inventario
     */
    public function index(Request $request)
    {
        $query = InventoryMovement::with(['product', 'user'])
            ->orderBy('created_at', 'desc');

        // Filtros
        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $movements = $query->paginate(20);
        $products = Product::orderBy('name')->get();

        return view('admin.inventory.index', compact('movements', 'products'));
    }

    /**
     * Mostrar formulario para registrar movimiento
     */
    public function create()
    {
        $products = Product::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('admin.inventory.create', compact('products'));
    }

    /**
     * Registrar nuevo movimiento de inventario
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:entrada,salida,ajuste',
            'quantity' => 'required|integer|min:1',
            'reason' => 'nullable|string|max:500',
            'reference' => 'nullable|string|max:100',
        ]);

        try {
            DB::beginTransaction();

            $product = Product::findOrFail($request->product_id);
            $stockBefore = $product->stock_quantity;

            // Calcular nuevo stock según el tipo de movimiento
            $stockAfter = match($request->type) {
                'entrada' => $stockBefore + $request->quantity,
                'salida' => $stockBefore - $request->quantity,
                'ajuste' => $request->quantity,
            };

            // Validar que no quede stock negativo
            if ($stockAfter < 0) {
                return back()->withErrors([
                    'quantity' => 'No hay suficiente stock disponible. Stock actual: ' . $stockBefore
                ])->withInput();
            }

            // Crear movimiento
            InventoryMovement::create([
                'product_id' => $product->id,
                'user_id' => Auth::id(),
                'type' => $request->type,
                'quantity' => $request->quantity,
                'stock_before' => $stockBefore,
                'stock_after' => $stockAfter,
                'reason' => $request->reason,
                'reference' => $request->reference,
            ]);

            // Actualizar stock del producto
            $product->update([
                'stock_quantity' => $stockAfter
            ]);

            DB::commit();

            return redirect()->route('admin.inventory.index')
                ->with('success', 'Movimiento de inventario registrado correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([
                'error' => 'Error al registrar el movimiento: ' . $e->getMessage()
            ])->withInput();
        }
    }

    /**
     * Mostrar productos con stock bajo
     */
    public function alerts()
    {
        $products = Product::whereColumn('stock_quantity', '<', 'stock_min')
            ->where('is_active', true)
            ->with('category')
            ->orderBy('stock_quantity', 'asc')
            ->get();

        return view('admin.inventory.alerts', compact('products'));
    }

    /**
     * Obtener stock actual de un producto (AJAX)
     */
    public function getStock(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        
        return response()->json([
            'stock_quantity' => $product->stock_quantity,
            'stock_min' => $product->stock_min,
            'is_low_stock' => $product->isLowStock()
        ]);
    }
}
