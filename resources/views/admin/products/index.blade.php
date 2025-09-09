@extends('admin.layout')

@section('title', 'Quản lý sản phẩm')
@section('page-title', 'Quản lý sản phẩm')

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="flex justify-between items-center">
        <h3 class="text-lg font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
            Danh sách sản phẩm
        </h3>
        <a href="{{ route('admin.products.create') }}" 
           class="bg-[#f53003] hover:bg-[#F61500] text-white px-4 py-2 rounded-lg transition-colors">
            Thêm sản phẩm mới
        </a>
    </div>

    <!-- Products Table -->
    <div class="bg-white dark:bg-[#161615] rounded-lg shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-[#e3e3e0] dark:divide-[#3E3E3A]">
                <thead class="bg-[#f8f9fa] dark:bg-[#1a1a1a]">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[#706f6c] dark:text-[#A1A09A] uppercase tracking-wider">
                            Hình ảnh
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[#706f6c] dark:text-[#A1A09A] uppercase tracking-wider">
                            Tên sản phẩm
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[#706f6c] dark:text-[#A1A09A] uppercase tracking-wider">
                            Danh mục
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[#706f6c] dark:text-[#A1A09A] uppercase tracking-wider">
                            Giá
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[#706f6c] dark:text-[#A1A09A] uppercase tracking-wider">
                            Tồn kho
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[#706f6c] dark:text-[#A1A09A] uppercase tracking-wider">
                            SKU
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[#706f6c] dark:text-[#A1A09A] uppercase tracking-wider">
                            Trạng thái
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-[#706f6c] dark:text-[#A1A09A] uppercase tracking-wider">
                            Hành động
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-[#161615] divide-y divide-[#e3e3e0] dark:divide-[#3E3E3A]">
                    @forelse($products as $product)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($product->main_image)
                                <img src="{{ asset('storage/' . $product->main_image) }}" 
                                     alt="{{ $product->name }}" 
                                     class="h-12 w-12 rounded-lg object-cover">
                            @else
                                <div class="h-12 w-12 bg-[#f8f9fa] dark:bg-[#1a1a1a] rounded-lg flex items-center justify-center">
                                    <svg class="h-6 w-6 text-[#706f6c] dark:text-[#A1A09A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                                {{ $product->name }}
                            </div>
                            <div class="text-sm text-[#706f6c] dark:text-[#A1A09A] max-w-xs truncate">
                                {{ $product->description ? Str::limit($product->description, 50) : 'Không có mô tả' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $product->category->name }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-[#1b1b18] dark:text-[#EDEDEC]">
                                {{ $product->formatted_price }}
                            </div>
                            @if($product->sale_price)
                            <div class="text-sm text-green-600">
                                {{ $product->formatted_sale_price }}
                            </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm {{ $product->stock_quantity > 0 ? 'text-[#1b1b18] dark:text-[#EDEDEC]' : 'text-red-600' }}">
                                {{ $product->stock_quantity }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-[#706f6c] dark:text-[#A1A09A]">
                            {{ $product->sku }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-col space-y-1">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $product->is_active ? 'Hoạt động' : 'Tạm dừng' }}
                                </span>
                                @if($product->is_featured)
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Nổi bật
                                </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.products.edit', $product) }}" 
                                   class="text-[#f53003] hover:text-[#F61500] transition-colors">
                                    Sửa
                                </a>
                                <button onclick="deleteProduct({{ $product->id }})" 
                                        class="text-red-600 hover:text-red-800 transition-colors">
                                    Xóa
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center text-[#706f6c] dark:text-[#A1A09A]">
                            <svg class="mx-auto h-12 w-12 text-[#e3e3e0] dark:text-[#3E3E3A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">Chưa có sản phẩm nào</h3>
                            <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">Bắt đầu bằng cách tạo sản phẩm đầu tiên.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($products->hasPages())
        <div class="px-6 py-4 border-t border-[#e3e3e0] dark:border-[#3E3E3A]">
            {{ $products->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white dark:bg-[#161615] rounded-lg p-6 max-w-md w-full mx-4">
        <h3 class="text-lg font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-4">
            Xác nhận xóa
        </h3>
        <p class="text-[#706f6c] dark:text-[#A1A09A] mb-6">
            Bạn có chắc chắn muốn xóa sản phẩm này? Hành động này không thể hoàn tác.
        </p>
        <div class="flex justify-end space-x-3">
            <button onclick="closeDeleteModal()" 
                    class="px-4 py-2 text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] transition-colors">
                Hủy
            </button>
            <button onclick="confirmDelete()" 
                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
                Xóa
            </button>
        </div>
    </div>
</div>

<script>
let productToDelete = null;

function deleteProduct(productId) {
    productToDelete = productId;
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('deleteModal').classList.add('flex');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.getElementById('deleteModal').classList.remove('flex');
    productToDelete = null;
}

async function confirmDelete() {
    if (!productToDelete) return;
    
    try {
        const response = await fetch(`/admin/products/${productToDelete}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        });
        
        const data = await response.json();
        
        if (data.success) {
            location.reload();
        } else {
            alert(data.message || 'Có lỗi xảy ra khi xóa sản phẩm');
        }
    } catch (error) {
        alert('Có lỗi xảy ra khi xóa sản phẩm');
    }
    
    closeDeleteModal();
}
</script>
@endsection
