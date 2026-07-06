<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('home', [
            'featuredProducts' => Product::where('is_featured', true)->orderBy('sort_order')->take(3)->get(),
            'carouselProducts' => Product::where('is_carousel', true)->orderBy('sort_order')->get(),
        ]);
    }

    public function products(): View
    {
        return view('products', [
            'products' => Product::orderBy('sort_order')->get(),
        ]);
    }

    public function product(Product $product): View
    {
        return view('product-detail', [
            'product' => $product,
            'relatedProducts' => Product::whereKeyNot($product->id)->orderBy('sort_order')->take(2)->get(),
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
            'message' => ['required', 'string', 'max:2000'],
        ]));

        return back()->with('success', 'Message received. We will reply within one business day.');
    }
}
