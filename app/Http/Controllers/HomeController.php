<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Throwable;

class HomeController extends Controller
{
    public function index(): View
    {
        try {
            $featuredProducts = Product::with('categoryModel')->where('is_featured', true)->orderBy('sort_order')->take(3)->get();
            $carouselProducts = Product::with('categoryModel')->where('is_carousel', true)->orderBy('sort_order')->get();
        } catch (Throwable) {
            $featuredProducts = $this->staticProducts()->take(3);
            $carouselProducts = $this->staticProducts();
        }

        return view('home', [
            'featuredProducts' => $featuredProducts,
            'carouselProducts' => $carouselProducts,
        ]);
    }

    public function products(Request $request): View
    {
        $activeCategory = $request->query('category');

        try {
            $categories = Category::where('is_active', true)->orderBy('sort_order')->get();
            $products = Product::with('categoryModel')->orderBy('sort_order');

            if ($activeCategory) {
                $products->whereHas('categoryModel', fn ($query) => $query->where('slug', $activeCategory));
            }

            $products = $products->get();
        } catch (Throwable) {
            $categories = $this->staticCategories();
            $products = $this->staticProducts();

            if ($activeCategory) {
                $products = $products->filter(fn ($product) => $product->category_slug === $activeCategory)->values();
            }
        }

        return view('products', [
            'products' => $products,
            'categories' => $categories,
            'activeCategory' => $activeCategory,
        ]);
    }

    public function product(string $product): View
    {
        try {
            $productModel = Product::where('slug', $product)->firstOrFail();
            $relatedProducts = Product::with('categoryModel')->whereKeyNot($productModel->id)->orderBy('sort_order')->take(2)->get();
        } catch (Throwable) {
            $products = $this->staticProducts();
            $productModel = $products->firstWhere('slug', $product) ?? $products->first();
            $relatedProducts = $products->where('slug', '!=', $productModel->slug)->take(2)->values();
        }

        return view('product-detail', [
            'product' => $productModel,
            'relatedProducts' => $relatedProducts,
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
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'address' => ['required', 'string', 'max:500'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        try {
            ContactMessage::create($data);
        } catch (Throwable) {
            report(new \RuntimeException('Contact message received while database was unavailable.'));
        }

        return back()->with('success', 'Message received. We will reply within one business day.');
    }

    private function staticCategories()
    {
        return collect([
            (object) ['name' => 'Floral', 'slug' => 'floral'],
            (object) ['name' => 'Fresh', 'slug' => 'fresh'],
            (object) ['name' => 'Evening', 'slug' => 'evening'],
            (object) ['name' => 'Gift Sets', 'slug' => 'gift-sets'],
        ]);
    }

    private function staticProducts()
    {
        return collect([
            $this->staticProduct('Jasmine Veil', 'jasmine-veil', 'Floral', 'floral', 'Bestseller', 'Night jasmine, bergamot peel, and amber musk', 'Night jasmine, bergamot peel, and amber musk for a polished floral trail.', 118, '50 ml'),
            $this->staticProduct('Cedar Bloom', 'cedar-bloom', 'Fresh', 'fresh', 'New arrival', 'Violet leaf, salted fig, and cedarwood', 'Violet leaf, salted fig, and cedarwood for fresh everyday wear.', 104, '50 ml'),
            $this->staticProduct('Nocturne Skin', 'nocturne-skin', 'Evening', 'evening', 'Evening', 'Cardamom, suede, and vanilla resin', 'Cardamom, suede, and vanilla resin for warm after-dark elegance.', 132, '50 ml'),
            $this->staticProduct('Amber Linen', 'amber-linen', 'Fresh', 'fresh', 'Clean', 'Mineral amber, linen musk, and mandarin', 'A clean amber fragrance with crisp linen musk and soft citrus.', 96, '30 ml'),
            $this->staticProduct('Citrus Smoke', 'citrus-smoke', 'Fresh', 'fresh', 'Fresh', 'Bitter orange, vetiver, and smoked tea', 'Bright citrus over soft smoke for a refined daily signature.', 112, '50 ml'),
            $this->staticProduct('Discovery Wardrobe', 'discovery-wardrobe', 'Gift Sets', 'gift-sets', 'Gift set', 'Six extrait fragrance trials', 'A curated set of six signature fragrances for travel and gifting.', 48, '6 x 2 ml'),
        ]);
    }

    private function staticProduct(string $name, string $slug, string $category, string $categorySlug, string $badge, string $notes, string $description, int $price, string $size): Product
    {
        return Product::make([
            'name' => $name,
            'category' => $category,
            'badge' => $badge,
            'notes' => $notes,
            'description' => $description,
            'price' => $price,
            'size' => $size,
            'image' => 'assets/hero-perfume.png',
        ])->forceFill([
            'id' => null,
            'slug' => $slug,
            'category_slug' => $categorySlug,
        ]);
    }
}
