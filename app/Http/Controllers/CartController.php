<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(Request $request): View
    {
        $cart = $this->cart($request);
        $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');
        $items = [];
        $total = 0;

        foreach ($cart as $productId => $quantity) {
            $product = $products->get($productId);
            if (! $product) {
                continue;
            }

            $subtotal = (float) $product->price * $quantity;
            $total += $subtotal;
            $items[] = compact('product', 'quantity', 'subtotal');
        }

        return view('cart', [
            'items' => $items,
            'total' => $total,
        ]);
    }

    public function add(Request $request, Product $product): RedirectResponse
    {
        $quantity = max(1, min(20, (int) $request->input('quantity', 1)));
        $cart = $this->cart($request);
        $cart[$product->id] = min(20, ($cart[$product->id] ?? 0) + $quantity);
        $request->session()->put('cart', $cart);

        return back()->with('success', $product->name . ' added to cart.');
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $quantity = max(0, min(20, (int) $request->input('quantity', 1)));
        $cart = $this->cart($request);

        if ($quantity === 0) {
            unset($cart[$product->id]);
        } else {
            $cart[$product->id] = $quantity;
        }

        $request->session()->put('cart', $cart);

        return back()->with('success', 'Cart updated.');
    }

    public function remove(Request $request, Product $product): RedirectResponse
    {
        $cart = $this->cart($request);
        unset($cart[$product->id]);
        $request->session()->put('cart', $cart);

        return back()->with('success', 'Item removed from cart.');
    }

    private function cart(Request $request): array
    {
        return $request->session()->get('cart', []);
    }
}
