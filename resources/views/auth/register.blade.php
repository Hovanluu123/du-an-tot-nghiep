@extends('auth.layout')

@section('title', 'Đăng ký')
@section('subtitle', 'Tạo tài khoản mới')

@section('content')
<form id="registerForm" class="space-y-6">
    @csrf

    <div>
        <label for="name" class="block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">
            Họ và tên
        </label>
        <input type="text"
               id="name"
               name="name"
               required
               class="w-full px-4 py-3 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg focus:ring-2 focus:ring-[#f53003] focus:border-transparent dark:bg-[#0a0a0a] dark:text-[#EDEDEC] transition-colors"
               placeholder="Nhập họ và tên">
        <div id="name-error" class="text-red-500 text-sm mt-1 hidden"></div>
    </div>

    <div>
        <label for="email" class="block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">
            Email
        </label>
        <input type="email"
               id="email"
               name="email"
               required
               class="w-full px-4 py-3 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg focus:ring-2 focus:ring-[#f53003] focus:border-transparent dark:bg-[#0a0a0a] dark:text-[#EDEDEC] transition-colors"
               placeholder="Nhập email">
        <div id="email-error" class="text-red-500 text-sm mt-1 hidden"></div>
    </div>

    <div>
        <label for="phone" class="block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">
            Số điện thoại
        </label>
        <input type="tel"
               id="phone"
               name="phone"
               required
               class="w-full px-4 py-3 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg focus:ring-2 focus:ring-[#f53003] focus:border-transparent dark:bg-[#0a0a0a] dark:text-[#EDEDEC] transition-colors"
               placeholder="Nhập số điện thoại">
        <div id="phone-error" class="text-red-500 text-sm mt-1 hidden"></div>
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
               placeholder="Nhập mật khẩu (ít nhất 8 ký tự)">
        <div id="password-error" class="text-red-500 text-sm mt-1 hidden"></div>
    </div>

    <div>
        <label for="password_confirmation" class="block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">
            Xác nhận mật khẩu
        </label>
        <input type="password"
               id="password_confirmation"
               name="password_confirmation"
               required
               class="w-full px-4 py-3 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg focus:ring-2 focus:ring-[#f53003] focus:border-transparent dark:bg-[#0a0a0a] dark:text-[#EDEDEC] transition-colors"
               placeholder="Nhập lại mật khẩu">
        <div id="password_confirmation-error" class="text-red-500 text-sm mt-1 hidden"></div>
    </div>

    <div>
        <label for="address" class="block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">
            Địa chỉ <span class="text-[#706f6c] text-xs">(tùy chọn)</span>
        </label>
        <textarea id="address"
                  name="address"
                  rows="3"
                  class="w-full px-4 py-3 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg focus:ring-2 focus:ring-[#f53003] focus:border-transparent dark:bg-[#0a0a0a] dark:text-[#EDEDEC] transition-colors resize-none"
                  placeholder="Nhập địa chỉ của bạn"></textarea>
        <div id="address-error" class="text-red-500 text-sm mt-1 hidden"></div>
    </div>

    <div class="flex items-center">
        <input type="checkbox"
               id="terms"
               name="terms"
               required
               class="h-4 w-4 text-[#f53003] focus:ring-[#f53003] border-[#e3e3e0] dark:border-[#3E3E3A] rounded">
        <label for="terms" class="ml-2 text-sm text-[#706f6c] dark:text-[#A1A09A]">
            Tôi đồng ý với
            <a href="#" class="text-[#f53003] hover:text-[#F61500] transition-colors">Điều khoản sử dụng</a>
            và
            <a href="#" class="text-[#f53003] hover:text-[#F61500] transition-colors">Chính sách bảo mật</a>
        </label>
    </div>
    <div id="terms-error" class="text-red-500 text-sm hidden"></div>

    <button type="submit"
            class="w-full bg-[#f53003] hover:bg-[#F61500] text-white font-medium py-3 px-4 rounded-lg transition-colors focus:ring-2 focus:ring-[#f53003] focus:ring-offset-2">
        Đăng ký
    </button>
</form>

<div id="message" class="mt-4 p-4 rounded-lg hidden"></div>
@endsection

@section('footer')
<p class="text-[#706f6c] dark:text-[#A1A09A]">
    Đã có tài khoản?
    <a href="{{ route('login') }}" class="text-[#f53003] hover:text-[#F61500] font-medium transition-colors">
        Đăng nhập ngay
    </a>
</p>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registerForm');
    const messageDiv = document.getElementById('message');

    // Client-side validation
    function validateEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    function validatePhone(phone) {
        const phoneRegex = /^[0-9+\-\s()]+$/;
        return phoneRegex.test(phone) && phone.length >= 10;
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

        const name = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        const phone = document.getElementById('phone').value.trim();
        const password = document.getElementById('password').value;
        const passwordConfirmation = document.getElementById('password_confirmation').value;
        const address = document.getElementById('address').value.trim();
        const terms = document.getElementById('terms').checked;

        // Clear previous errors
        hideError('name');
        hideError('email');
        hideError('phone');
        hideError('password');
        hideError('password_confirmation');
        hideError('address');
        hideError('terms');

        // Validation
        let hasError = false;

        if (!name) {
            showError('name', 'Họ tên là bắt buộc');
            hasError = true;
        }

        if (!email) {
            showError('email', 'Email là bắt buộc');
            hasError = true;
        } else if (!validateEmail(email)) {
            showError('email', 'Email không hợp lệ');
            hasError = true;
        }

        if (!phone) {
            showError('phone', 'Số điện thoại là bắt buộc');
            hasError = true;
        } else if (!validatePhone(phone)) {
            showError('phone', 'Số điện thoại không hợp lệ (ít nhất 10 số)');
            hasError = true;
        }

        if (!password) {
            showError('password', 'Mật khẩu là bắt buộc');
            hasError = true;
        } else if (password.length < 8) {
            showError('password', 'Mật khẩu phải có ít nhất 8 ký tự');
            hasError = true;
        }

        if (!passwordConfirmation) {
            showError('password_confirmation', 'Xác nhận mật khẩu là bắt buộc');
            hasError = true;
        } else if (password !== passwordConfirmation) {
            showError('password_confirmation', 'Xác nhận mật khẩu không khớp');
            hasError = true;
        }

        // Validate address if provided
        if (address && address.length > 500) {
            showError('address', 'Địa chỉ không được vượt quá 500 ký tự');
            hasError = true;
        }

        if (!terms) {
            showError('terms', 'Bạn phải đồng ý với điều khoản sử dụng');
            hasError = true;
        }

        if (hasError) return;

        // Submit form
        const formData = new FormData(form);
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;

        submitBtn.textContent = 'Đang đăng ký...';
        submitBtn.disabled = true;

        try {
            const response = await fetch('{{ route("register") }}', {
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
                    showMessage(data.message || 'Đăng ký thất bại', 'error');
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
