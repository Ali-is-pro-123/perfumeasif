<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Services\OrderMailer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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

    public function checkout(Request $request): View|RedirectResponse
    {
        $summary = $this->summary($request);

        if (empty($summary['items'])) {
            return redirect()->route('cart')->with('success', 'Please add a product before checkout.');
        }

        return view('checkout', $summary);
    }

    public function storeOrder(Request $request): RedirectResponse
    {
        $summary = $this->summary($request);

        if (empty($summary['items'])) {
            return redirect()->route('cart')->with('success', 'Your cart is empty.');
        }

        $data = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:40'],
            'address' => ['required', 'string', 'max:500'],
            'city' => ['nullable', 'string', 'max:120'],
            'notes' => ['nullable', 'string', 'max:1200'],
        ]);

        $order = DB::transaction(function () use ($data, $summary) {
            $order = Order::create($data + [
                'order_number' => 'AR-' . now()->format('ymd') . '-' . Str::upper(Str::random(5)),
                'status' => 'pending',
                'subtotal' => $summary['total'],
                'shipping' => 0,
                'total' => $summary['total'],
            ]);

            foreach ($summary['items'] as $item) {
                $product = $item['product'];
                $order->items()->create([
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_size' => $product->size,
                    'unit_price' => $product->price,
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['subtotal'],
                ]);
            }

            return $order;
        });

        $request->session()->forget('cart');
        app(OrderMailer::class)->sendCustomerConfirmation($order->load('items'));

        return redirect()->route('checkout.thank-you', $order)->with('success', 'Order placed successfully.');
    }

    public function thankYou(Order $order): View
    {
        return view('order-success', [
            'order' => $order->load('items'),
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

    private function summary(Request $request): array
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

        return compact('items', 'total');
    }
}
