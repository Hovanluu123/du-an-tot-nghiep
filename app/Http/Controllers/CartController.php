<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    private function getCart(Request $request): array
    {
        return $request->session()->get('cart', []);
    }

    private function saveCart(Request $request, array $cart): void
    {
        $request->session()->put('cart', $cart);
    }

    public function index(Request $request)
    {
        $cart = $this->getCart($request);
        $items = [];
        $subtotal = 0;
        foreach ($cart as $product) {
            $quantity = $product['quantity'] ?? 1;
            $price = $product['price'] ?? 150000;
            $lineTotal = $price * $quantity;
            $subtotal += $lineTotal;
            $items[] = [
                'product' => (object) $product,
                'quantity' => $quantity,
                'price' => $price,
                'lineTotal' => $lineTotal,
            ];
        }

        return view('shop.cart_bootstrap', [
            'items' => $items,
            'subtotal' => $subtotal,
        ]);
    }

    public function add(Request $request, int $productId)
    {
        $cart = $this->getCart($request);
        $quantity = max(1, (int) $request->input('quantity', 1));
        $cart[$productId] = $cart[$productId] ?? [
            'id' => $productId,
            'slug' => 'san-pham-' . $productId,
            'name' => 'Sản phẩm ' . $productId,
            'formatted_price' => number_format(150000, 0, ',', '.') . ' VNĐ',
            'formatted_sale_price' => null,
            'main_image' => 'https://placehold.co/600x400?text=SP+' . $productId,
            'sku' => 'PRD-' . $productId,
            'price' => 150000,
        ];
        $cart[$productId]['quantity'] = ($cart[$productId]['quantity'] ?? 0) + $quantity;
        $this->saveCart($request, $cart);

        return redirect()->back()->with('success', 'Đã thêm vào giỏ hàng');
    }

    public function update(Request $request, int $productId)
    {
        $quantity = (int) $request->input('quantity', 1);
        $cart = $this->getCart($request);
        if ($quantity <= 0) {
            unset($cart[$productId]);
        } else {
            if (!isset($cart[$productId])) {
                $cart[$productId] = [
                    'id' => $productId,
                    'slug' => 'san-pham-' . $productId,
                    'name' => 'Sản phẩm ' . $productId,
                    'formatted_price' => number_format(150000, 0, ',', '.') . ' VNĐ',
                    'formatted_sale_price' => null,
                    'main_image' => 'https://placehold.co/600x400?text=SP+' . $productId,
                    'sku' => 'PRD-' . $productId,
                    'price' => 150000,
                ];
            }
            $cart[$productId]['quantity'] = $quantity;
        }
        $this->saveCart($request, $cart);
        return redirect()->route('cart.index');
    }

    public function remove(Request $request, int $productId)
    {
        $cart = $this->getCart($request);
        unset($cart[$productId]);
        $this->saveCart($request, $cart);
        return redirect()->route('cart.index');
    }

    public function clear(Request $request)
    {
        $request->session()->forget('cart');
        return redirect()->route('cart.index');
    }
}


