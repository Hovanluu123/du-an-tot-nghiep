@extends('admin.layout')

@section('title', 'Thêm sản phẩm mới')
@section('page-title', 'Thêm sản phẩm mới')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white dark:bg-[#161615] rounded-lg shadow-lg p-6">
        <form id="productForm" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">
                        Tên sản phẩm <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           required 
                           class="w-full px-4 py-3 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg focus:ring-2 focus:ring-[#f53003] focus:border-transparent dark:bg-[#0a0a0a] dark:text-[#EDEDEC] transition-colors"
                           placeholder="Nhập tên sản phẩm">
                    <div id="name-error" class="text-red-500 text-sm mt-1 hidden"></div>
                </div>
                
                <div>
                    <label for="category_id" class="block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">
                        Danh mục <span class="text-red-500">*</span>
                    </label>
                    <select id="category_id" 
                            name="category_id" 
                            required
                            class="w-full px-4 py-3 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg focus:ring-2 focus:ring-[#f53003] focus:border-transparent dark:bg-[#0a0a0a] dark:text-[#EDEDEC] transition-colors">
                        <option value="">Chọn danh mục</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <div id="category_id-error" class="text-red-500 text-sm mt-1 hidden"></div>
                </div>
            </div>
            
            <div>
                <label for="description" class="block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">
                    Mô tả sản phẩm
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="4"
                          class="w-full px-4 py-3 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg focus:ring-2 focus:ring-[#f53003] focus:border-transparent dark:bg-[#0a0a0a] dark:text-[#EDEDEC] transition-colors"
                          placeholder="Nhập mô tả sản phẩm"></textarea>
                <div id="description-error" class="text-red-500 text-sm mt-1 hidden"></div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="price" class="block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">
                        Giá gốc (VNĐ) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           id="price" 
                           name="price" 
                           required 
                           min="0"
                           step="1000"
                           class="w-full px-4 py-3 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg focus:ring-2 focus:ring-[#f53003] focus:border-transparent dark:bg-[#0a0a0a] dark:text-[#EDEDEC] transition-colors"
                           placeholder="0">
                    <div id="price-error" class="text-red-500 text-sm mt-1 hidden"></div>
                </div>
                
                <div>
                    <label for="sale_price" class="block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">
                        Giá khuyến mãi (VNĐ)
                    </label>
                    <input type="number" 
                           id="sale_price" 
                           name="sale_price" 
                           min="0"
                           step="1000"
                           class="w-full px-4 py-3 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg focus:ring-2 focus:ring-[#f53003] focus:border-transparent dark:bg-[#0a0a0a] dark:text-[#EDEDEC] transition-colors"
                           placeholder="0">
                    <div id="sale_price-error" class="text-red-500 text-sm mt-1 hidden"></div>
                </div>
                
                <div>
                    <label for="stock_quantity" class="block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">
                        Số lượng tồn kho <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           id="stock_quantity" 
                           name="stock_quantity" 
                           required 
                           min="0"
                           class="w-full px-4 py-3 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg focus:ring-2 focus:ring-[#f53003] focus:border-transparent dark:bg-[#0a0a0a] dark:text-[#EDEDEC] transition-colors"
                           placeholder="0">
                    <div id="stock_quantity-error" class="text-red-500 text-sm mt-1 hidden"></div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="sku" class="block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">
                        Mã SKU
                    </label>
                    <input type="text" 
                           id="sku" 
                           name="sku" 
                           class="w-full px-4 py-3 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg focus:ring-2 focus:ring-[#f53003] focus:border-transparent dark:bg-[#0a0a0a] dark:text-[#EDEDEC] transition-colors"
                           placeholder="Mã SKU (tự động tạo nếu để trống)">
                    <div id="sku-error" class="text-red-500 text-sm mt-1 hidden"></div>
                </div>
                
                <div>
                    <label for="images" class="block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">
                        Hình ảnh sản phẩm
                    </label>
                    <input type="file" 
                           id="images" 
                           name="images[]" 
                           multiple
                           accept="image/*"
                           class="w-full px-4 py-3 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg focus:ring-2 focus:ring-[#f53003] focus:border-transparent dark:bg-[#0a0a0a] dark:text-[#EDEDEC] transition-colors">
                    <div id="images-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    <p class="text-xs text-[#706f6c] dark:text-[#A1A09A] mt-1">
                        Có thể chọn nhiều hình ảnh. Định dạng: JPEG, PNG, JPG, GIF. Kích thước tối đa: 2MB mỗi file
                    </p>
                </div>
            </div>
            
            <div>
                <label for="specifications" class="block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">
                    Thông số kỹ thuật (JSON)
                </label>
                <textarea id="specifications" 
                          name="specifications" 
                          rows="3"
                          class="w-full px-4 py-3 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg focus:ring-2 focus:ring-[#f53003] focus:border-transparent dark:bg-[#0a0a0a] dark:text-[#EDEDEC] transition-colors font-mono text-sm"
                          placeholder='{"màu": "đỏ", "kích thước": "M", "chất liệu": "cotton"}'></textarea>
                <div id="specifications-error" class="text-red-500 text-sm mt-1 hidden"></div>
                <p class="text-xs text-[#706f6c] dark:text-[#A1A09A] mt-1">
                    Nhập thông số kỹ thuật dưới dạng JSON (tùy chọn)
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex items-center">
                    <input type="checkbox" 
                           id="is_active" 
                           name="is_active" 
                           value="1"
                           checked
                           class="h-4 w-4 text-[#f53003] focus:ring-[#f53003] border-[#e3e3e0] dark:border-[#3E3E3A] rounded">
                    <label for="is_active" class="ml-2 text-sm text-[#1b1b18] dark:text-[#EDEDEC]">
                        Kích hoạt sản phẩm
                    </label>
                </div>
                
                <div class="flex items-center">
                    <input type="checkbox" 
                           id="is_featured" 
                           name="is_featured" 
                           value="1"
                           class="h-4 w-4 text-[#f53003] focus:ring-[#f53003] border-[#e3e3e0] dark:border-[#3E3E3A] rounded">
                    <label for="is_featured" class="ml-2 text-sm text-[#1b1b18] dark:text-[#EDEDEC]">
                        Sản phẩm nổi bật
                    </label>
                </div>
            </div>
            
            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.products.index') }}" 
                   class="px-6 py-3 border border-[#e3e3e0] dark:border-[#3E3E3A] text-[#706f6c] dark:text-[#A1A09A] rounded-lg hover:bg-[#f8f9fa] dark:hover:bg-[#1a1a1a] transition-colors">
                    Hủy
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-[#f53003] hover:bg-[#F61500] text-white rounded-lg transition-colors">
                    Tạo sản phẩm
                </button>
            </div>
        </form>
        
        <div id="message" class="mt-4 p-4 rounded-lg hidden"></div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('productForm');
    const messageDiv = document.getElementById('message');
    
    function showError(fieldId, message) {
        const errorDiv = document.getElementById(fieldId + '-error');
        errorDiv.textContent = message;
        errorDiv.classList.remove('hidden');
    }
    
    function hideError(fieldId) {
        const errorDiv = document.getElementById(fieldId + '-error');
        errorDiv.classList.add('hidden');
    }
    
    function showMessage(message, type = 'success') {
        messageDiv.textContent = message;
        messageDiv.className = `mt-4 p-4 rounded-lg ${type === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}`;
        messageDiv.classList.remove('hidden');
        
        setTimeout(() => {
            messageDiv.classList.add('hidden');
        }, 5000);
    }
    
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = new FormData(form);
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        
        // Clear previous errors
        hideError('name');
        hideError('category_id');
        hideError('description');
        hideError('price');
        hideError('sale_price');
        hideError('stock_quantity');
        hideError('sku');
        hideError('images');
        hideError('specifications');
        
        submitBtn.textContent = 'Đang tạo...';
        submitBtn.disabled = true;
        
        try {
            const response = await fetch('{{ route("admin.products.store") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                showMessage(data.message, 'success');
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 1000);
            } else {
                if (data.errors) {
                    Object.keys(data.errors).forEach(field => {
                        showError(field, data.errors[field][0]);
                    });
                } else {
                    showMessage(data.message || 'Có lỗi xảy ra', 'error');
                }
            }
        } catch (error) {
            showMessage('Có lỗi xảy ra, vui lòng thử lại', 'error');
        } finally {
            submitBtn.textContent = originalText;
            submitBtn.disabled = false;
        }
    });
});
</script>
@endsection
