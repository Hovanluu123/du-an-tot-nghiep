<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function home()
    {
        $featuredProducts = collect($this->fakeProducts(8));
        $categories = collect($this->fakeCategories());

        return view('shop.home_bootstrap', compact('featuredProducts', 'categories'));
    }

    public function products(Request $request)
    {
        $categorySlug = $request->query('category');
        $categories = collect($this->fakeCategories());
        $products = collect($this->fakeProducts(12));
        return view('shop.products_bootstrap', compact('products', 'categories', 'categorySlug'));
    }

    public function product(string $slug)
    {
        $product = (object) $this->fakeProduct($slug);
        $relatedProducts = collect($this->fakeProducts(8));
        return view('shop.product_bootstrap', compact('product', 'relatedProducts'));
    }

    private function fakeProducts(int $count): array
    {
        $items = [];
        for ($i = 1; $i <= $count; $i++) {
            $items[] = $this->fakeProduct("san-pham-{$i}");
        }
        return $items;
    }

    private function fakeProduct(string $slug): array
    {
        $price = 199000 + rand(0, 5) * 10000;
        $sale = rand(0, 1) ? $price - 30000 : null;
        $name = 'Sản phẩm ' . strtoupper(substr(md5($slug), 0, 4));
        $img = "https://placehold.co/600x400?text=" . urlencode($name);
        return [
            'id' => rand(1000, 9999),
            'slug' => $slug,
            'name' => $name,
            'description' => 'Mô tả ngắn gọn về sản phẩm dùng để minh họa giao diện.',
            'formatted_price' => number_format($price, 0, ',', '.') . ' VNĐ',
            'formatted_sale_price' => $sale ? number_format($sale, 0, ',', '.') . ' VNĐ' : null,
            'main_image' => $img,
            'images' => [$img, $img, $img],
            'sku' => 'PRD-' . strtoupper(substr($slug, -4)),
        ];
    }

    private function fakeCategories(): array
    {
        return [
            ['name' => 'Yoga', 'slug' => 'yoga'],
            ['name' => 'Gym', 'slug' => 'gym'],
            ['name' => 'Phụ kiện', 'slug' => 'phu-kien'],
            ['name' => 'Trang phục', 'slug' => 'trang-phuc'],
        ];
    }
}


