<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Throwable;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        try {
            return view('admin.dashboard', [
                'productsCount' => Product::count(),
                'categoriesCount' => Category::count(),
                'messagesCount' => ContactMessage::count(),
                'unreadMessages' => ContactMessage::where('is_read', false)->count(),
                'latestMessages' => ContactMessage::latest()->take(5)->get(),
            ]);
        } catch (Throwable) {
            return view('admin.dashboard', [
                'productsCount' => 6,
                'categoriesCount' => 4,
                'messagesCount' => 0,
                'unreadMessages' => 0,
                'latestMessages' => collect(),
            ]);
        }
    }

    public function products(): View
    {
        try {
            $products = Product::orderBy('sort_order')->get();
        } catch (Throwable) {
            $products = $this->demoProducts();
        }

        return view('admin.products.index', compact('products'));
    }

    public function createProduct(): View
    {
        try {
            $categories = Category::orderBy('sort_order')->get();
        } catch (Throwable) {
            $categories = $this->demoCategories();
        }

        return view('admin.products.form', [
            'product' => new Product(),
            'categories' => $categories,
        ]);
    }

    public function storeProduct(Request $request): RedirectResponse
    {
        try {
            Product::create($this->productData($request));
        } catch (Throwable) {
            return redirect()->route('admin.products')->with('success', 'Demo mode: product changes are not saved on Vercel.');
        }

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
        try {
            ContactMessage::where('is_read', false)->update(['is_read' => true]);

            $messages = ContactMessage::latest()->get();
        } catch (Throwable) {
            $messages = collect();
        }

        return view('admin.messages', compact('messages'));
    }

    public function categories(): View
    {
        try {
            $categories = Category::withCount('products')->orderBy('sort_order')->get();
        } catch (Throwable) {
            $categories = $this->demoCategories();
        }

        return view('admin.categories.index', compact('categories'));
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

    private function demoProducts()
    {
        return collect([
            $this->demoProduct('Jasmine Veil', 'Floral', 'Bestseller', 118),
            $this->demoProduct('Cedar Bloom', 'Fresh', 'New arrival', 104),
            $this->demoProduct('Nocturne Skin', 'Evening', 'Evening', 132),
        ]);
    }

    private function demoProduct(string $name, string $category, string $badge, int $price): Product
    {
        return Product::make([
            'name' => $name,
            'slug' => Str::slug($name),
            'category' => $category,
            'badge' => $badge,
            'notes' => 'Demo fragrance notes',
            'description' => 'Demo product visible while Vercel database writes are unavailable.',
            'image' => 'assets/hero-perfume.png',
            'price' => $price,
            'size' => '50 ml',
            'sort_order' => 1,
            'is_featured' => true,
            'is_carousel' => true,
        ]);
    }

    private function demoCategories()
    {
        return collect([
            (object) ['id' => 1, 'name' => 'Floral', 'slug' => 'floral', 'description' => 'Demo category', 'sort_order' => 1, 'is_active' => true, 'products_count' => 2],
            (object) ['id' => 2, 'name' => 'Fresh', 'slug' => 'fresh', 'description' => 'Demo category', 'sort_order' => 2, 'is_active' => true, 'products_count' => 2],
            (object) ['id' => 3, 'name' => 'Evening', 'slug' => 'evening', 'description' => 'Demo category', 'sort_order' => 3, 'is_active' => true, 'products_count' => 1],
        ]);
    }
}
