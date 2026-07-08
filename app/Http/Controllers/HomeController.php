<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('home', [
            'featuredProducts' => Product::with('categoryModel')->where('is_featured', true)->orderBy('sort_order')->take(3)->get(),
            'carouselProducts' => Product::with('categoryModel')->where('is_carousel', true)->orderBy('sort_order')->get(),
        ]);
    }

    public function products(Request $request): View
    {
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();
        $activeCategory = $request->query('category');
        $products = Product::with('categoryModel')->orderBy('sort_order');

        if ($activeCategory) {
            $products->whereHas('categoryModel', fn ($query) => $query->where('slug', $activeCategory));
        }

        return view('products', [
            'products' => $products->get(),
            'categories' => $categories,
            'activeCategory' => $activeCategory,
        ]);
    }

    public function product(Product $product): View
    {
        return view('product-detail', [
            'product' => $product,
            'relatedProducts' => Product::with('categoryModel')->whereKeyNot($product->id)->orderBy('sort_order')->take(2)->get(),
        ]);
    }

    public function about(): View
    {
        return view('about');
    }

    public function contact(): View
    {
        return view('contact');
    }

    public function storeContact(Request $request): RedirectResponse
    {
        ContactMessage::create($request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'address' => ['required', 'string', 'max:500'],
            'message' => ['required', 'string', 'max:2000'],
        ]));

        return back()->with('success', 'Message received. We will reply within one business day.');
    }
}
