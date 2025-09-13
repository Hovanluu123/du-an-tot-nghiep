<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        // Fake data sản phẩm dựa trên Model Product
        $products = [
            (object) [
                'id' => 1,
                'name' => 'Giày chạy bộ Nike',
                'slug' => 'giay-chay-bo-nike',
                'description' => 'Giày chạy bộ chuyên nghiệp',
                'price' => 1200000.00,
                'sale_price' => 1000000.00,
                'stock_quantity' => 10,
                'sku' => 'PRD-ABC12345',
                'images' => ['giay-chay-bo.jpg'],
                'specifications' => ['Size: 40', 'Color: Black'],
                'is_active' => true,
                'is_featured' => true,
                'category_id' => 1,
                'mainImage' => 'giay-chay-bo.jpg',
                'formattedPrice' => '1.200.000 VNĐ',
                'formattedSalePrice' => '1.000.000 VNĐ',
            ],
            (object) [
                'id' => 2,
                'name' => 'Áo thể thao Adidas',
                'slug' => 'ao-the-thao-adidas',
                'description' => 'Áo thể thao thoáng mát',
                'price' => 500000.00,
                'sale_price' => null,
                'stock_quantity' => 15,
                'sku' => 'PRD-XYZ98765',
                'images' => ['ao-the-thao.jpg'],
                'specifications' => ['Size: M', 'Color: Blue'],
                'is_active' => true,
                'is_featured' => false,
                'category_id' => 2,
                'mainImage' => 'ao-the-thao.jpg',
                'formattedPrice' => '500.000 VNĐ',
                'formattedSalePrice' => null,
            ],
        ];
        // $products = Product::with('category')->latest()->paginate(10); // Uncomment khi có DB
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::active()->ordered()->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:products',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'stock_quantity' => 'required|integer|min:0',
            'sku' => 'nullable|string|max:50|unique:products',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'specifications' => 'nullable|array',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'category_id' => 'required|exists:categories,id',
        ], [
            'name.required' => 'Tên sản phẩm là bắt buộc',
            'name.unique' => 'Tên sản phẩm đã tồn tại',
            'price.required' => 'Giá sản phẩm là bắt buộc',
            'price.min' => 'Giá sản phẩm phải lớn hơn 0',
            'sale_price.lt' => 'Giá khuyến mãi phải nhỏ hơn giá gốc',
            'stock_quantity.required' => 'Số lượng tồn kho là bắt buộc',
            'stock_quantity.min' => 'Số lượng tồn kho không được âm',
            'sku.unique' => 'Mã SKU đã tồn tại',
            'images.*.image' => 'File phải là hình ảnh',
            'images.*.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif',
            'images.*.max' => 'Kích thước hình ảnh không được vượt quá 2MB',
            'category_id.required' => 'Danh mục là bắt buộc',
            'category_id.exists' => 'Danh mục không tồn tại',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('products', 'public');
                $imagePaths[] = $imagePath;
            }
            $data['images'] = $imagePaths;
            $data['mainImage'] = $imagePaths[0] ?? null; // Lấy ảnh đầu tiên làm mainImage
        }

        Product::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Sản phẩm đã được tạo thành công!',
            'redirect' => route('admin.products.index')
        ]);
    }

    public function show(Product $product)
    {
        $product->load('category');
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::active()->ordered()->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products')->ignore($product->id)
            ],
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'stock_quantity' => 'required|integer|min:0',
            'sku' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('products')->ignore($product->id)
            ],
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'specifications' => 'nullable|array',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'category_id' => 'required|exists:categories,id',
        ], [
            'name.required' => 'Tên sản phẩm là bắt buộc',
            'name.unique' => 'Tên sản phẩm đã tồn tại',
            'price.required' => 'Giá sản phẩm là bắt buộc',
            'price.min' => 'Giá sản phẩm phải lớn hơn 0',
            'sale_price.lt' => 'Giá khuyến mãi phải nhỏ hơn giá gốc',
            'stock_quantity.required' => 'Số lượng tồn kho là bắt buộc',
            'stock_quantity.min' => 'Số lượng tồn kho không được âm',
            'sku.unique' => 'Mã SKU đã tồn tại',
            'images.*.image' => 'File phải là hình ảnh',
            'images.*.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif',
            'images.*.max' => 'Kích thước hình ảnh không được vượt quá 2MB',
            'category_id.required' => 'Danh mục là bắt buộc',
            'category_id.exists' => 'Danh mục không tồn tại',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('images')) {
            if ($product->images) {
                foreach ($product->images as $image) {
                    if (\Storage::disk('public')->exists($image)) {
                        \Storage::disk('public')->delete($image);
                    }
                }
            }
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('products', 'public');
                $imagePaths[] = $imagePath;
            }
            $data['images'] = $imagePaths;
            $data['mainImage'] = $imagePaths[0] ?? $product->mainImage; // Giữ mainImage cũ nếu không có ảnh mới
        }

        $product->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Sản phẩm đã được cập nhật thành công!',
            'redirect' => route('admin.products.index')
        ]);
    }

    public function destroy(Product $product)
    {
        if ($product->images) {
            foreach ($product->images as $image) {
                if (\Storage::disk('public')->exists($image)) {
                    \Storage::disk('public')->delete($image);
                }
            }
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Sản phẩm đã được xóa thành công!'
        ]);
    }
}