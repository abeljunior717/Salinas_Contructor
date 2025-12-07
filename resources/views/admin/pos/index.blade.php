@extends('layouts.app')

@section('title', 'Punto de Venta - Admin')

@section('content')
<div class="min-h-screen bg-gray-100">
    <div class="bg-gradient-to-r from-green-600 to-green-800 text-white py-4 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold"><i class="fas fa-cash-register mr-2"></i>Punto de Venta</h1>
                <p class="text-green-100 text-sm">Sistema de ventas</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.pos.sales') }}" class="bg-white text-green-700 px-4 py-2 rounded-lg font-semibold hover:bg-green-50 transition">
                    <i class="fas fa-history mr-2"></i>Historial
                </a>
                <a href="{{ route('admin.dashboard') }}" class="bg-green-700 text-white px-4 py-2 rounded-lg font-semibold hover:bg-green-900 transition">
                    <i class="fas fa-arrow-left mr-2"></i>Volver
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-6">
        @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-xl mr-3"></i>
                    <div>
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Panel de Productos -->
            <div class="lg:col-span-2 bg-white rounded-lg shadow-lg p-6">
                <div class="mb-4">
                    <input type="text" id="search-product" placeholder="🔍 Buscar producto por nombre o SKU..." 
                           class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-green-500 focus:outline-none text-lg">
                </div>

                <!-- Filtros por categoría -->
                <div class="flex gap-2 mb-4 overflow-x-auto pb-2">
                    <button onclick="filterByCategory('all')" 
                            class="category-filter px-4 py-2 rounded-full bg-green-600 text-white font-semibold whitespace-nowrap active">
                        Todos
                    </button>
                    @foreach($categories as $category)
                        <button onclick="filterByCategory('{{ $category->id }}')" 
                                class="category-filter px-4 py-2 rounded-full bg-gray-200 text-gray-700 font-semibold hover:bg-gray-300 whitespace-nowrap">
                            {{ $category->name }}
                        </button>
                    @endforeach
                </div>

                <!-- Grid de productos -->
                <div id="products-grid" class="grid grid-cols-2 md:grid-cols-3 gap-3 max-h-[600px] overflow-y-auto">
                    @foreach($products as $product)
                        <div class="product-item border-2 border-gray-200 rounded-lg p-3 hover:border-green-500 cursor-pointer transition"
                             data-category="{{ $product->category_id }}"
                             data-name="{{ strtolower($product->name) }}"
                             onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }}, {{ $product->stock_quantity }})">
                            <div class="text-center">
                                <div class="bg-gray-100 rounded-lg p-2 mb-2">
                                    <i class="fas fa-box text-3xl text-gray-400"></i>
                                </div>
                                <h3 class="font-bold text-sm mb-1 line-clamp-2">{{ $product->name }}</h3>
                                <p class="text-green-600 font-bold text-lg">${{ number_format($product->price, 0) }}</p>
                                <p class="text-xs text-gray-500">
                                    Stock: <span class="font-semibold {{ $product->stock_quantity < 10 ? 'text-red-600' : 'text-green-600' }}">
                                        {{ $product->stock_quantity }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Carrito de Compra -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-xl font-bold mb-4 flex items-center">
                    <i class="fas fa-shopping-cart text-green-600 mr-2"></i>
                    Carrito de Venta
                </h2>

                <form id="sale-form" method="POST" action="{{ route('admin.pos.process') }}">
                    @csrf
                    
                    <!-- Items del carrito -->
                    <div id="cart-items" class="mb-4 max-h-[300px] overflow-y-auto">
                        <p class="text-gray-400 text-center py-8">Carrito vacío</p>
                    </div>

                    <!-- Información del cliente (opcional) -->
                    <div class="border-t pt-4 mb-4">
                        <h3 class="font-semibold mb-2">Cliente (Opcional)</h3>
                        <input type="text" name="customer_name" placeholder="Nombre del cliente" 
                               class="w-full px-3 py-2 border rounded-lg mb-2">
                        <input type="text" name="customer_phone" placeholder="Teléfono" 
                               class="w-full px-3 py-2 border rounded-lg">
                    </div>

                    <!-- Método de pago -->
                    <div class="border-t pt-4 mb-4">
                        <h3 class="font-semibold mb-2">Método de Pago</h3>
                        <select name="payment_method" required class="w-full px-3 py-2 border rounded-lg">
                            <option value="efectivo">💵 Efectivo</option>
                            <option value="tarjeta">💳 Tarjeta</option>
                            <option value="transferencia">🏦 Transferencia</option>
                        </select>
                    </div>

                    <!-- Resumen -->
                    <div class="border-t pt-4 mb-4 space-y-2">
                        <div class="flex justify-between text-gray-700">
                            <span>Subtotal:</span>
                            <span id="subtotal" class="font-semibold">$0</span>
                        </div>
                        <div class="flex justify-between text-gray-700">
                            <span>IVA (19%):</span>
                            <span id="tax" class="font-semibold">$0</span>
                        </div>
                        <div class="flex justify-between text-xl font-bold text-green-700 pt-2 border-t-2">
                            <span>Total:</span>
                            <span id="total">$0</span>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="space-y-2">
                        <button type="submit" id="btn-process" 
                                class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-lg transition disabled:bg-gray-300"
                                disabled>
                            <i class="fas fa-check-circle mr-2"></i>Procesar Venta
                        </button>
                        <button type="button" onclick="clearCart()" 
                                class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 rounded-lg transition">
                            <i class="fas fa-trash mr-2"></i>Limpiar Carrito
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
let cart = [];

function addToCart(id, name, price, stock) {
    const existingItem = cart.find(item => item.product_id === id);
    
    if (existingItem) {
        if (existingItem.quantity < stock) {
            existingItem.quantity++;
        } else {
            alert('Stock insuficiente');
            return;
        }
    } else {
        cart.push({
            product_id: id,
            name: name,
            price: price,
            quantity: 1,
            stock: stock
        });
    }
    
    updateCart();
}

function updateQuantity(id, change) {
    const item = cart.find(item => item.product_id === id);
    if (item) {
        item.quantity += change;
        if (item.quantity > item.stock) {
            item.quantity = item.stock;
            alert('Stock insuficiente');
        }
        if (item.quantity <= 0) {
            removeFromCart(id);
        } else {
            updateCart();
        }
    }
}

function removeFromCart(id) {
    cart = cart.filter(item => item.product_id !== id);
    updateCart();
}

function updateCart() {
    const cartItems = document.getElementById('cart-items');
    const btnProcess = document.getElementById('btn-process');
    
    if (cart.length === 0) {
        cartItems.innerHTML = '<p class="text-gray-400 text-center py-8">Carrito vacío</p>';
        btnProcess.disabled = true;
    } else {
        let html = '';
        cart.forEach(item => {
            html += `
                <div class="border-b pb-2 mb-2">
                    <div class="flex justify-between items-start mb-1">
                        <span class="font-semibold text-sm flex-1">${item.name}</span>
                        <button type="button" onclick="removeFromCart(${item.product_id})" 
                                class="text-red-500 hover:text-red-700 ml-2">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <button type="button" onclick="updateQuantity(${item.product_id}, -1)"
                                    class="bg-gray-200 hover:bg-gray-300 w-7 h-7 rounded">-</button>
                            <span class="font-bold w-8 text-center">${item.quantity}</span>
                            <button type="button" onclick="updateQuantity(${item.product_id}, 1)"
                                    class="bg-gray-200 hover:bg-gray-300 w-7 h-7 rounded">+</button>
                        </div>
                        <span class="font-bold text-green-600">$${(item.price * item.quantity).toLocaleString()}</span>
                    </div>
                    <input type="hidden" name="items[${item.product_id}][product_id]" value="${item.product_id}">
                    <input type="hidden" name="items[${item.product_id}][quantity]" value="${item.quantity}">
                </div>
            `;
        });
        cartItems.innerHTML = html;
        btnProcess.disabled = false;
    }
    
    updateTotals();
}

function updateTotals() {
    const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    const tax = subtotal * 0.19;
    const total = subtotal + tax;
    
    document.getElementById('subtotal').textContent = '$' + subtotal.toLocaleString();
    document.getElementById('tax').textContent = '$' + tax.toLocaleString();
    document.getElementById('total').textContent = '$' + total.toLocaleString();
}

function clearCart() {
    if (confirm('¿Limpiar el carrito?')) {
        cart = [];
        updateCart();
    }
}

function filterByCategory(categoryId) {
    const buttons = document.querySelectorAll('.category-filter');
    buttons.forEach(btn => {
        btn.classList.remove('active', 'bg-green-600', 'text-white');
        btn.classList.add('bg-gray-200', 'text-gray-700');
    });
    event.target.classList.add('active', 'bg-green-600', 'text-white');
    event.target.classList.remove('bg-gray-200', 'text-gray-700');
    
    const products = document.querySelectorAll('.product-item');
    products.forEach(product => {
        if (categoryId === 'all' || product.dataset.category === categoryId) {
            product.style.display = 'block';
        } else {
            product.style.display = 'none';
        }
    });
}

// Búsqueda de productos
document.getElementById('search-product').addEventListener('input', function(e) {
    const search = e.target.value.toLowerCase();
    const products = document.querySelectorAll('.product-item');
    
    products.forEach(product => {
        const name = product.dataset.name;
        if (name.includes(search)) {
            product.style.display = 'block';
        } else {
            product.style.display = 'none';
        }
    });
});
</script>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection
