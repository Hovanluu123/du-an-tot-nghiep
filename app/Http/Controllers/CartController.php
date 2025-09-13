<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart', compact('cart'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ], [
            'quantity.min' => 'Số lượng phải lớn hơn 0.',
        ]);

        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        // Fake product data (replace with DB query later)
        $fakeProducts = [
            1 => ['id' => 1, 'name' => 'Giày chạy bộ', 'price' => 1200000, 'image' => 'giay-chay-bo.jpg'],
            2 => ['id' => 2, 'name' => 'Áo thể thao', 'price' => 500000, 'image' => 'ao-the-thao.jpg'],
        ];

        if (!isset($fakeProducts[$productId])) {
            return response()->json(['success' => false, 'message' => 'Sản phẩm không tồn tại.'], 400);
        }

        $product = $fakeProducts[$productId];
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'id' => $productId,
                'name' => $product['name'],
                'price' => $product['price'],
                'image' => $product['image'],
                'quantity' => $quantity,
            ];
        }

        session()->put('cart', $cart);

        $totalItems = array_sum(array_column($cart, 'quantity'));
        return response()->json(['success' => true, 'message' => 'Thêm vào giỏ hàng thành công!', 'totalItems' => $totalItems]);
    }

    public function update(Request $request, $id)
    {

        $quantity = $request->input('quantity');
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $quantity;
            session()->put('cart', $cart);
            return response()->json(['success' => true, 'message' => 'Cập nhật thành công']);
        }
        return response()->json(['success' => false, 'message' => 'Không tìm thấy sản phẩm']);
    }

    public function remove(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            $totalItems = array_sum(array_column($cart, 'quantity'));
            return response()->json(['success' => true, 'message' => 'Xóa sản phẩm thành công!', 'totalItems' => $totalItems]);
        }


        return response()->json(['success' => false, 'message' => 'Sản phẩm không tồn tại trong giỏ hàng.'], 400);
    }
}
