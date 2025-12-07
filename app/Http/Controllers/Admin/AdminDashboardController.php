<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\News;
use App\Models\Quotation;
use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_products' => Product::count(),
            'total_categories' => Category::count(),
            'total_news' => News::count(),
            'total_quotations' => Quotation::count(),
            'total_users' => User::where('role', 'client')->count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'pending_quotations' => Quotation::where('status', 'pendiente')->count(),
            'unread_messages' => Message::where('is_read', false)->count(),
        ];

        $recent_quotations = Quotation::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_quotations'));
    }

    // ===== PRODUCTOS =====
    public function products()
    {
        $products = Product::with('category')->paginate(12);
        return view('admin.products.index', compact('products'));
    }

    public function createProduct()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:products,slug',
            'description' => 'required|string',
            'technical_specs' => 'nullable|json',
            'price' => 'required|numeric|min:0',
            'cost' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'stock_quantity' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'image_url' => 'nullable|url',
            'benefits' => 'nullable|string',
            'materials' => 'nullable|string',
            'intended_use' => 'nullable|string',
            'other_qualities' => 'nullable|string',
            'detailed_specs' => 'nullable|json',
            'color' => 'nullable|string|max:100',
            'performance' => 'nullable|string|max:100',
            'material_type' => 'nullable|string|max:100',
            'weight_spec' => 'nullable|string|max:100',
            'accessories' => 'nullable|string|max:255',
            'warranty' => 'nullable|string|max:100',
            'package_content' => 'nullable|string|max:255',
            'model_spec' => 'nullable|string|max:100',
            'height_spec' => 'nullable|string|max:50',
            'width_spec' => 'nullable|string|max:50',
            'length_spec' => 'nullable|string|max:50',
            'depth_spec' => 'nullable|string|max:50',
            'capacity' => 'nullable|string|max:255',
            'pieces_count' => 'nullable|string|max:50',
        ]);

        Product::create($validated);

        return redirect()->route('admin.products')
                       ->with('success', 'Producto creado exitosamente');
    }

    public function editProduct(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function updateProduct(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:products,slug,' . $product->id,
            'description' => 'required|string',
            'technical_specs' => 'nullable|json',
            'price' => 'required|numeric|min:0',
            'cost' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'stock_quantity' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'image_url' => 'nullable|url',
            'benefits' => 'nullable|string',
            'materials' => 'nullable|string',
            'intended_use' => 'nullable|string',
            'other_qualities' => 'nullable|string',
            'detailed_specs' => 'nullable|json',
            'color' => 'nullable|string|max:100',
            'performance' => 'nullable|string|max:100',
            'material_type' => 'nullable|string|max:100',
            'weight_spec' => 'nullable|string|max:100',
            'accessories' => 'nullable|string|max:255',
            'warranty' => 'nullable|string|max:100',
            'package_content' => 'nullable|string|max:255',
            'model_spec' => 'nullable|string|max:100',
            'height_spec' => 'nullable|string|max:50',
            'width_spec' => 'nullable|string|max:50',
            'length_spec' => 'nullable|string|max:50',
            'depth_spec' => 'nullable|string|max:50',
            'capacity' => 'nullable|string|max:255',
            'pieces_count' => 'nullable|string|max:50',
        ]);

        $product->update($validated);

        return redirect()->route('admin.products')
                       ->with('success', 'Producto actualizado exitosamente');
    }

    public function deleteProduct(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products')
                       ->with('success', 'Producto eliminado exitosamente');
    }

    // ===== CATEGORÍAS =====
    public function categories()
    {
        $categories = Category::withCount('products')->paginate(12);
        return view('admin.categories.index', compact('categories'));
    }

    public function createCategory()
    {
        return view('admin.categories.create');
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'slug' => 'required|string|unique:categories,slug',
            'description' => 'nullable|string',
        ]);

        Category::create($validated);

        return redirect()->route('admin.categories')
                       ->with('success', 'Categoría creada exitosamente');
    }

    public function editCategory(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function updateCategory(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'slug' => 'required|string|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string',
        ]);

        $category->update($validated);

        return redirect()->route('admin.categories')
                       ->with('success', 'Categoría actualizada exitosamente');
    }

    public function deleteCategory(Category $category)
    {
        if ($category->products()->count() > 0) {
            return redirect()->route('admin.categories')
                           ->with('error', 'No puedes eliminar una categoría con productos');
        }

        $category->delete();
        return redirect()->route('admin.categories')
                       ->with('success', 'Categoría eliminada exitosamente');
    }

    // ===== NOTICIAS =====
    public function news()
    {
        $news = News::paginate(12);
        return view('admin.news.index', compact('news'));
    }

    public function createNews()
    {
        return view('admin.news.create');
    }

    public function storeNews(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:news,slug',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'featured_image_url' => 'nullable|url',
        ]);

        // Guardar con los nombres de columna correctos
        $validated['author_id'] = auth()->id();

        News::create($validated);

        return redirect()->route('admin.news')
                       ->with('success', 'Noticia publicada exitosamente');
    }

    public function editNews(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    public function updateNews(Request $request, News $news)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:news,slug,' . $news->id,
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'featured_image_url' => 'nullable|url',
        ]);

        $news->update($validated);

        return redirect()->route('admin.news')
                       ->with('success', 'Noticia actualizada exitosamente');
    }

    public function deleteNews(News $news)
    {
        $news->delete();
        return redirect()->route('admin.news')
                       ->with('success', 'Noticia eliminada exitosamente');
    }

    // ===== COTIZACIONES =====
    public function quotations()
    {
        $quotations = Quotation::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(12);
        return view('admin.quotations.index', compact('quotations'));
    }

    public function viewQuotation(Quotation $quotation)
    {
        $quotation->load(['user', 'items.product']);
        return view('admin.quotations.show', compact('quotation'));
    }

    public function updateQuotationStatus(Request $request, Quotation $quotation)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $quotation->update($validated);

        return redirect()->back()
                       ->with('success', 'Estado de cotización actualizado');
    }

    public function approveQuotation(Quotation $quotation)
    {
        if ($quotation->status !== 'pendiente') {
            return redirect()->back()->with('error', 'Solo se pueden aprobar cotizaciones pendientes');
        }

        $quotation->update([
            'status' => 'aceptada',
            'approved_at' => now(),
            'payment_deadline' => now()->addMonth(), // 1 mes para pagar
        ]);

        return redirect()->back()->with('success', 'Cotización aprobada correctamente');
    }

    public function rejectQuotation(Quotation $quotation)
    {
        if ($quotation->status !== 'pendiente') {
            return redirect()->back()->with('error', 'Solo se pueden rechazar cotizaciones pendientes');
        }

        $quotation->update([
            'status' => 'rechazada',
            'rejected_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Cotización rechazada');
    }

    // ===== USUARIOS =====
    public function users()
    {
        $users = User::where('role', 'client')
            ->paginate(12);
        return view('admin.users.index', compact('users'));
    }

    public function deleteUser(User $user)
    {
        if ($user->role === 'admin') {
            return redirect()->back()
                           ->with('error', 'No puedes eliminar administradores');
        }

        $user->delete();
        return redirect()->route('admin.users')
                       ->with('success', 'Usuario eliminado exitosamente');
    }

    // ===== REPORTES =====
    public function reports()
    {
        $stats = [
            'total_products' => Product::count(),
            'total_categories' => Category::count(),
            'total_news' => News::count(),
            'total_quotations' => Quotation::count(),
            'total_users' => User::where('role', 'client')->count(),
        ];

        $quotations_by_status = Quotation::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->get();

        $products_by_category = Product::selectRaw('category_id, count(*) as count')
            ->groupBy('category_id')
            ->with('category')
            ->get();

        return view('admin.reports.index', compact('stats', 'quotations_by_status', 'products_by_category'));
    }
}
