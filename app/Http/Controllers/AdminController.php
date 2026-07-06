<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
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
            'messagesCount' => ContactMessage::count(),
            'unreadMessages' => ContactMessage::where('is_read', false)->count(),
            'latestMessages' => ContactMessage::latest()->take(5)->get(),
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
        return view('admin.products.form', ['product' => new Product()]);
    }

    public function storeProduct(Request $request): RedirectResponse
    {
        Product::create($this->productData($request));

        return redirect()->route('admin.products')->with('success', 'Product created.');
    }

    public function editProduct(Product $product): View
    {
        return view('admin.products.form', compact('product'));
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

    private function productData(Request $request, ?Product $product = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
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
        $data['image'] = $data['image'] ?: ($product?->image ?: 'assets/brand-01.jpeg');
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_carousel'] = $request->boolean('is_carousel');

        return $data;
    }
}
