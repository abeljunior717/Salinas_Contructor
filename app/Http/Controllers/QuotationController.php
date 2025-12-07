<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\Product;
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Public preview of quotation form (for guests) - shows summary and CTA to create account.
     */
    public function preview(\Illuminate\Http\Request $request)
    {
        $products = Product::where('is_active', true)->with('category')->get();

        $preselected = $request->query('product_id');
        $quantity = (int) $request->query('quantity', 1);

        return view('quotations.create', compact('products', 'preselected', 'quantity'))
            ->with('guestPreview', true);
    }

    public function index()
    {
        $quotations = auth()->user()->quotations()->latest()->paginate(10);
        return view('quotations.index', compact('quotations'));
    }

    public function show(Quotation $quotation)
    {
        // Verificar que el usuario sea dueño de la cotización o sea admin
        if (auth()->id() !== $quotation->user_id && auth()->user()->role !== 'admin') {
            abort(403, 'No tienes permiso para ver esta cotización.');
        }
        
        return view('quotations.show', compact('quotation'));
    }

    public function create()
    {
        $products = Product::where('is_active', true)->with('category')->get();
        return view('quotations.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);
        // Server-side validation: asegurar que los productos estén disponibles y la cantidad no exceda el stock
        $errors = [];
        foreach ($validated['items'] as $i => $item) {
            $product = Product::find($item['product_id']);
            if (!$product) {
                $errors[] = "Producto con id {$item['product_id']} no encontrado.";
                continue;
            }
            if ($product->stock_quantity <= 0) {
                $errors[] = "El producto {$product->name} no está disponible.";
            }
            if ($item['quantity'] > $product->stock_quantity) {
                $errors[] = "La cantidad solicitada para {$product->name} excede el stock disponible ({$product->stock_quantity}).";
            }
        }

        if (!empty($errors)) {
            return redirect()->back()->withInput()->withErrors($errors);
        }

        $quotation = new Quotation();
        $quotation->user_id = auth()->id();
        $quotation->reference_number = Quotation::generateReferenceNumber();
        $quotation->notes = $validated['notes'] ?? null;
        $quotation->valid_until = now()->addDays(30);
        $quotation->status = 'pendiente';

        $subtotal = 0;

        // Calcular subtotal primero
        foreach ($validated['items'] as $item) {
            $product = Product::findOrFail($item['product_id']);
            $lineTotal = $product->price * $item['quantity'];
            $subtotal += $lineTotal;
        }

        $taxAmount = $subtotal * 0.19; // IVA 19%
        $totalAmount = $subtotal + $taxAmount;

        $quotation->subtotal = $subtotal;
        $quotation->tax_amount = $taxAmount;
        $quotation->total_amount = $totalAmount;
        $quotation->save();

        // Ahora crear los items con quotation_id
        foreach ($validated['items'] as $item) {
            $product = Product::findOrFail($item['product_id']);
            $lineTotal = $product->price * $item['quantity'];

            QuotationItem::create([
                'quotation_id' => $quotation->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $product->price,
                'line_total' => $lineTotal,
            ]);
        }

        return redirect()->route('quotations.show', $quotation)
                        ->with('success', '¡Solicitud de cotización enviada! Por favor espere a que su solicitud sea aceptada por nuestro equipo.');
    }

    public function approve(Quotation $quotation)
    {
        $this->authorize('update', $quotation);
        
        if ($quotation->status !== 'pendiente') {
            return redirect()->back()->with('error', 'Solo se pueden aprobar cotizaciones pendientes');
        }

        $quotation->update(['status' => 'aceptada']);

        return redirect()->back()->with('success', 'Cotización aprobada correctamente');
    }

    public function reject(Quotation $quotation)
    {
        $this->authorize('update', $quotation);
        
        if ($quotation->status !== 'pendiente') {
            return redirect()->back()->with('error', 'Solo se pueden rechazar cotizaciones pendientes');
        }

        $quotation->update(['status' => 'rechazada']);

        return redirect()->back()->with('success', 'Cotización rechazada');
    }
}
