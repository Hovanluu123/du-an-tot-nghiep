@extends('admin.layout')

@section('title', 'Chỉnh sửa danh mục')
@section('page-title', 'Chỉnh sửa danh mục')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white dark:bg-[#161615] rounded-lg shadow-lg p-6">
        <form id="categoryForm" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label for="name" class="block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">
                    Tên danh mục <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       required 
                       value="{{ $category->name }}"
                       class="w-full px-4 py-3 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg focus:ring-2 focus:ring-[#f53003] focus:border-transparent dark:bg-[#0a0a0a] dark:text-[#EDEDEC] transition-colors"
                       placeholder="Nhập tên danh mục">
                <div id="name-error" class="text-red-500 text-sm mt-1 hidden"></div>
            </div>
            
            <div>
                <label for="description" class="block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">
                    Mô tả
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="4"
                          class="w-full px-4 py-3 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg focus:ring-2 focus:ring-[#f53003] focus:border-transparent dark:bg-[#0a0a0a] dark:text-[#EDEDEC] transition-colors"
                          placeholder="Nhập mô tả danh mục">{{ $category->description }}</textarea>
                <div id="description-error" class="text-red-500 text-sm mt-1 hidden"></div>
            </div>
            
            <div>
                <label for="image" class="block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">
                    Hình ảnh
                </label>
                
                @if($category->image)
                <div class="mb-3">
                    <img src="{{ asset('storage/' . $category->image) }}" 
                         alt="{{ $category->name }}" 
                         class="h-20 w-20 rounded-lg object-cover">
                    <p class="text-xs text-[#706f6c] dark:text-[#A1A09A] mt-1">Hình ảnh hiện tại</p>
                </div>
                @endif
                
                <input type="file" 
                       id="image" 
                       name="image" 
                       accept="image/*"
                       class="w-full px-4 py-3 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg focus:ring-2 focus:ring-[#f53003] focus:border-transparent dark:bg-[#0a0a0a] dark:text-[#EDEDEC] transition-colors">
                <div id="image-error" class="text-red-500 text-sm mt-1 hidden"></div>
                <p class="text-xs text-[#706f6c] dark:text-[#A1A09A] mt-1">
                    Định dạng: JPEG, PNG, JPG, GIF. Kích thước tối đa: 2MB
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="sort_order" class="block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">
                        Thứ tự sắp xếp
                    </label>
                    <input type="number" 
                           id="sort_order" 
                           name="sort_order" 
                           min="0"
                           value="{{ $category->sort_order }}"
                           class="w-full px-4 py-3 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg focus:ring-2 focus:ring-[#f53003] focus:border-transparent dark:bg-[#0a0a0a] dark:text-[#EDEDEC] transition-colors">
                    <div id="sort_order-error" class="text-red-500 text-sm mt-1 hidden"></div>
                </div>
                
                <div class="flex items-center">
                    <input type="checkbox" 
                           id="is_active" 
                           name="is_active" 
                           value="1"
                           {{ $category->is_active ? 'checked' : '' }}
                           class="h-4 w-4 text-[#f53003] focus:ring-[#f53003] border-[#e3e3e0] dark:border-[#3E3E3A] rounded">
                    <label for="is_active" class="ml-2 text-sm text-[#1b1b18] dark:text-[#EDEDEC]">
                        Kích hoạt danh mục
                    </label>
                </div>
            </div>
            
            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.categories.index') }}" 
                   class="px-6 py-3 border border-[#e3e3e0] dark:border-[#3E3E3A] text-[#706f6c] dark:text-[#A1A09A] rounded-lg hover:bg-[#f8f9fa] dark:hover:bg-[#1a1a1a] transition-colors">
                    Hủy
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-[#f53003] hover:bg-[#F61500] text-white rounded-lg transition-colors">
                    Cập nhật danh mục
                </button>
            </div>
        </form>
        
        <div id="message" class="mt-4 p-4 rounded-lg hidden"></div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('categoryForm');
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
        hideError('description');
        hideError('image');
        hideError('sort_order');
        
        submitBtn.textContent = 'Đang cập nhật...';
        submitBtn.disabled = true;
        
        try {
            const response = await fetch('{{ route("admin.categories.update", $category) }}', {
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
