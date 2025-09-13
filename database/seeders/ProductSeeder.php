<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo category demo nếu chưa có
        $category1 = Category::firstOrCreate(['name' => 'Giày thể thao']);
        $category2 = Category::firstOrCreate(['name' => 'Quần áo thể thao']);
        $category3 = Category::firstOrCreate(['name' => 'Phụ kiện thể thao']);

        // Tạo 5 sản phẩm demo
        $products = [
            [
                'name' => 'Giày Nike Air Max 270',
                'price' => 2500000,
                'description' => 'Giày thể thao Nike Air Max 270 với công nghệ Air Max tiên tiến, đế giày êm ái và thiết kế thời trang.',
                'size' => '42',
                'color' => 'Trắng',
                'image' => 'https://example.com/images/nike-air-max-270.jpg',
                'stock' => 50,
                'category_id' => $category1->id,
            ],
            [
                'name' => 'Áo thun Adidas Originals',
                'price' => 450000,
                'description' => 'Áo thun thể thao Adidas Originals chất liệu cotton cao cấp, thoáng mát và thoải mái.',
                'size' => 'L',
                'color' => 'Xanh navy',
                'image' => 'https://example.com/images/adidas-originals-tee.jpg',
                'stock' => 100,
                'category_id' => $category2->id,
            ],
            [
                'name' => 'Quần short thể thao Puma',
                'price' => 380000,
                'description' => 'Quần short thể thao Puma với chất liệu polyester thoáng khí, phù hợp cho các hoạt động thể thao.',
                'size' => 'M',
                'color' => 'Đen',
                'image' => 'https://example.com/images/puma-shorts.jpg',
                'stock' => 75,
                'category_id' => $category2->id,
            ],
            [
                'name' => 'Balo thể thao Under Armour',
                'price' => 1200000,
                'description' => 'Balo thể thao Under Armour với nhiều ngăn tiện lợi, chất liệu chống nước và bền bỉ.',
                'size' => 'One Size',
                'color' => 'Xám',
                'image' => 'https://example.com/images/under-armour-backpack.jpg',
                'stock' => 30,
                'category_id' => $category3->id,
            ],
            [
                'name' => 'Giày chạy bộ New Balance',
                'price' => 1800000,
                'description' => 'Giày chạy bộ New Balance với công nghệ Fresh Foam, đế giày êm ái và hỗ trợ tốt cho chân.',
                'size' => '40',
                'color' => 'Xanh lá',
                'image' => 'https://example.com/images/new-balance-running.jpg',
                'stock' => 60,
                'category_id' => $category1->id,
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }
    }
}
