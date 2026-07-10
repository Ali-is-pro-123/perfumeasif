<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        return view('admin.dashboard', [
            'productsCount' => Product::count(),
            'categoriesCount' => Category::count(),
            'messagesCount' => ContactMessage::count(),
            'ordersCount' => Order::count(),
            'pendingOrders' => Order::where('status', 'pending')->count(),
            'unreadMessages' => ContactMessage::where('is_read', false)->count(),
            'latestMessages' => ContactMessage::latest()->take(5)->get(),
            'latestOrders' => Order::latest()->take(5)->get(),
        ]);
    }

    public function products(): View
    {
        return view('admin.products.index', [
            'products' => Product::orderBy('sort_order')->get(),
        ]);
    }

    public function createProduct(): View
    {
        return view('admin.products.form', [
            'product' => new Product(),
            'categories' => Category::orderBy('sort_order')->get(),
        ]);
    }

    public function storeProduct(Request $request): RedirectResponse
    {
        Product::create($this->productData($request));

        return redirect()->route('admin.products')->with('success', 'Product created.');
    }

    public function editProduct(Product $product): View
    {
        return view('admin.products.form', [
            'product' => $product,
            'categories' => Category::orderBy('sort_order')->get(),
        ]);
    }

    public function updateProduct(Request $request, Product $product): RedirectResponse
    {
        $product->update($this->productData($request, $product));

        return redirect()->route('admin.products')->with('success', 'Product updated.');
    }

    public function deleteProduct(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('admin.products')->with('success', 'Product deleted.');
    }

    public function messages(): View
    {
        ContactMessage::where('is_read', false)->update(['is_read' => true]);

        return view('admin.messages', [
            'messages' => ContactMessage::latest()->get(),
        ]);
    }

    public function orders(Request $request): View
    {
        $orders = Order::with('items')->latest();
        $period = $request->query('period', 'all');
        $status = $request->query('status');

        if ($status) {
            $orders->where('status', $status);
        }

        match ($period) {
            'today' => $orders->whereDate('created_at', today()),
            'week' => $orders->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]),
            'month' => $orders->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()]),
            'custom' => $this->applyCustomOrderDates($orders, $request),
            default => null,
        };

        $filteredOrders = $orders->get();

        return view('admin.orders.index', [
            'orders' => $filteredOrders,
            'statuses' => Order::STATUSES,
            'period' => $period,
            'status' => $status,
            'from' => $request->query('from'),
            'to' => $request->query('to'),
            'report' => [
                'count' => $filteredOrders->count(),
                'total' => $filteredOrders->sum('total'),
                'pending' => $filteredOrders->where('status', 'pending')->count(),
                'completed' => $filteredOrders->where('status', 'completed')->count(),
            ],
        ]);
    }

    public function updateOrder(Request $request, Order $order): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:' . implode(',', Order::STATUSES)],
        ]);

        $order->update($data);

        return back()->with('success', 'Order status updated.');
    }

    public function categories(): View
    {
        return view('admin.categories.index', [
            'categories' => Category::withCount('products')->orderBy('sort_order')->get(),
        ]);
    }

    public function createCategory(): View
    {
        return view('admin.categories.form', ['category' => new Category()]);
    }

    public function storeCategory(Request $request): RedirectResponse
    {
        Category::create($this->categoryData($request));

        return redirect()->route('admin.categories')->with('success', 'Category created.');
    }

    public function editCategory(Category $category): View
    {
        return view('admin.categories.form', compact('category'));
    }

    public function updateCategory(Request $request, Category $category): RedirectResponse
    {
        $category->update($this->categoryData($request, $category));

        return redirect()->route('admin.categories')->with('success', 'Category updated.');
    }

    public function deleteCategory(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('admin.categories')->with('success', 'Category deleted.');
    }

    private function productData(Request $request, ?Product $product = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'category' => ['nullable', 'string', 'max:255'],
            'badge' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'size' => ['required', 'string', 'max:255'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_featured' => ['nullable', 'boolean'],
            'is_carousel' => ['nullable', 'boolean'],
        ]);

        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        if (! empty($data['category_id'])) {
            $data['category'] = Category::find($data['category_id'])?->name ?: $data['category'];
        }
        $data['image'] = $data['image'] ?: ($product?->image ?: 'assets/brand-01.jpeg');
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_carousel'] = $request->boolean('is_carousel');

        return $data;
    }

    private function categoryData(Request $request, ?Category $category = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }

    private function applyCustomOrderDates($orders, Request $request): void
    {
        if ($request->filled('from')) {
            $orders->whereDate('created_at', '>=', $request->date('from'));
        }

        if ($request->filled('to')) {
            $orders->whereDate('created_at', '<=', $request->date('to'));
        }
    }
}
