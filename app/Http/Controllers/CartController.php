<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $cart_items = Cart::where('user_id', auth()->id())
            ->with('product')
            ->get();

        $total = $cart_items->sum(function($item) {
            return $item->quantity * $item->price;
        });

        return view('cart.index', compact('cart_items', 'total'));
    }

    public function addToCart(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        // Verificar si ya existe en carrito
        $cart_item = Cart::where('user_id', auth()->id())
            ->where('product_id', $validated['product_id'])
            ->first();

        if ($cart_item) {
            $cart_item->increment('quantity', $validated['quantity']);
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
                'price' => $product->price,
            ]);
        }

        return redirect()->route('cart.index')
                       ->with('success', 'Producto agregado al carrito');
    }

    public function updateQuantity(Request $request, Cart $item)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        if ($this->isOwner($item)) {
            $item->update(['quantity' => $validated['quantity']]);
            return redirect()->back()->with('success', 'Cantidad actualizada');
        }

        return redirect()->back()->with('error', 'No autorizado');
    }

    public function removeFromCart(Cart $item)
    {
        if ($this->isOwner($item)) {
            $item->delete();
            return redirect()->back()->with('success', 'Producto removido del carrito');
        }

        return redirect()->back()->with('error', 'No autorizado');
    }

    public function checkout()
    {
        $cart_items = Cart::where('user_id', auth()->id())
            ->with('product')
            ->get();

        if ($cart_items->isEmpty()) {
            return redirect()->route('cart.index')
                           ->with('error', 'El carrito está vacío');
        }

        $total = $cart_items->sum(function($item) {
            return $item->quantity * $item->price;
        });

        // Crear cotización desde carrito
        $quotation = auth()->user()->quotations()->create([
            'status' => 'pending',
            'total_amount' => $total,
        ]);

        // Transferir items del carrito a la cotización
        foreach ($cart_items as $cart_item) {
            $quotation->items()->create([
                'product_id' => $cart_item->product_id,
                'quantity' => $cart_item->quantity,
                'price' => $cart_item->price,
            ]);
        }

        // Limpiar carrito
        Cart::where('user_id', auth()->id())->delete();

        return redirect()->route('quotations.show', $quotation)
                       ->with('success', 'Cotización creada exitosamente');
    }

    private function isOwner(Cart $item)
    {
        return $item->user_id === auth()->id();
    }
}
