@extends('auth.layout')

@section('title', 'Đăng nhập')
@section('subtitle', 'Đăng nhập vào tài khoản của bạn')

@section('content')
<form id="loginForm" class="space-y-6">
    @csrf
    
    <div>
        <label for="email" class="block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">
            Email hoặc Số điện thoại
        </label>
        <input type="text" 
               id="email" 
               name="email" 
               required 
               class="w-full px-4 py-3 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg focus:ring-2 focus:ring-[#f53003] focus:border-transparent dark:bg-[#0a0a0a] dark:text-[#EDEDEC] transition-colors"
               placeholder="Nhập email hoặc số điện thoại">
        <div id="email-error" class="text-red-500 text-sm mt-1 hidden"></div>
    </div>
    
    <div>
        <label for="password" class="block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">
            Mật khẩu
        </label>
        <input type="password" 
               id="password" 
               name="password" 
               required 
               class="w-full px-4 py-3 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg focus:ring-2 focus:ring-[#f53003] focus:border-transparent dark:bg-[#0a0a0a] dark:text-[#EDEDEC] transition-colors"
               placeholder="Nhập mật khẩu">
        <div id="password-error" class="text-red-500 text-sm mt-1 hidden"></div>
    </div>
    
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <input type="checkbox" 
                   id="remember" 
                   name="remember" 
                   class="h-4 w-4 text-[#f53003] focus:ring-[#f53003] border-[#e3e3e0] dark:border-[#3E3E3A] rounded">
            <label for="remember" class="ml-2 text-sm text-[#706f6c] dark:text-[#A1A09A]">
                Ghi nhớ đăng nhập
            </label>
        </div>
        
        <a href="#" class="text-sm text-[#f53003] hover:text-[#F61500] transition-colors">
            Quên mật khẩu?
        </a>
    </div>
    
    <button type="submit" 
            class="w-full bg-[#f53003] hover:bg-[#F61500] text-white font-medium py-3 px-4 rounded-lg transition-colors focus:ring-2 focus:ring-[#f53003] focus:ring-offset-2">
        Đăng nhập
    </button>
</form>

<div id="message" class="mt-4 p-4 rounded-lg hidden"></div>
@endsection

@section('footer')
<p class="text-[#706f6c] dark:text-[#A1A09A]">
    Chưa có tài khoản? 
    <a href="{{ route('register') }}" class="text-[#f53003] hover:text-[#F61500] font-medium transition-colors">
        Đăng ký ngay
    </a>
</p>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('loginForm');
    const messageDiv = document.getElementById('message');
    
    // Client-side validation
    function validateEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const phoneRegex = /^[0-9+\-\s()]+$/;
        return emailRegex.test(email) || phoneRegex.test(email);
    }
    
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
        
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value;
        
        // Clear previous errors
        hideError('email');
        hideError('password');
        
        // Validation
        let hasError = false;
        
        if (!email) {
            showError('email', 'Email hoặc số điện thoại là bắt buộc');
            hasError = true;
        } else if (!validateEmail(email)) {
            showError('email', 'Email hoặc số điện thoại không hợp lệ');
            hasError = true;
        }
        
        if (!password) {
            showError('password', 'Mật khẩu là bắt buộc');
            hasError = true;
        } else if (password.length < 8) {
            showError('password', 'Mật khẩu phải có ít nhất 8 ký tự');
            hasError = true;
        }
        
        if (hasError) return;
        
        // Submit form
        const formData = new FormData(form);
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        
        submitBtn.textContent = 'Đang đăng nhập...';
        submitBtn.disabled = true;
        
        try {
            const response = await fetch('{{ route("login") }}', {
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
                    showMessage(data.message || 'Đăng nhập thất bại', 'error');
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
