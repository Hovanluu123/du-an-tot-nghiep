@extends('layouts.app')

@section('title', 'Thông tin cá nhân')

@section('content')
<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-[#161615] shadow-lg rounded-lg overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-[#f53003] to-[#F61500]">
            <h1 class="text-2xl font-bold text-white">Thông tin cá nhân</h1>
            <p class="text-white/80 text-sm">Cập nhật thông tin tài khoản của bạn</p>
        </div>

        <div class="p-6">
            <form id="profileForm" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">
                            Họ và tên <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               id="name"
                               name="name"
                               value="{{ $user->name }}"
                               required
                               class="w-full px-4 py-3 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg focus:ring-2 focus:ring-[#f53003] focus:border-transparent dark:bg-[#0a0a0a] dark:text-[#EDEDEC] transition-colors">
                        <div id="name-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email"
                               id="email"
                               name="email"
                               value="{{ $user->email }}"
                               required
                               class="w-full px-4 py-3 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg focus:ring-2 focus:ring-[#f53003] focus:border-transparent dark:bg-[#0a0a0a] dark:text-[#EDEDEC] transition-colors">
                        <div id="email-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">
                            Số điện thoại <span class="text-red-500">*</span>
                        </label>
                        <input type="tel"
                               id="phone"
                               name="phone"
                               value="{{ $user->phone }}"
                               required
                               class="w-full px-4 py-3 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg focus:ring-2 focus:ring-[#f53003] focus:border-transparent dark:bg-[#0a0a0a] dark:text-[#EDEDEC] transition-colors">
                        <div id="phone-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">
                            Vai trò
                        </label>
                        <div class="w-full px-4 py-3 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg bg-[#f8f8f7] dark:bg-[#1D1D1A] text-[#706f6c] dark:text-[#A1A09A]">
                            @if($user->role === 'admin')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Quản trị viên
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Người dùng
                                </span>
                            @endif
                        </div>
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">
                            Địa chỉ
                        </label>
                        <textarea id="address"
                                  name="address"
                                  rows="3"
                                  class="w-full px-4 py-3 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg focus:ring-2 focus:ring-[#f53003] focus:border-transparent dark:bg-[#0a0a0a] dark:text-[#EDEDEC] transition-colors resize-none">{{ $user->address }}</textarea>
                        <div id="address-error" class="text-red-500 text-sm mt-1 hidden"></div>
                    </div>
                </div>

                <div class="border-t border-[#e3e3e0] dark:border-[#3E3E3A] pt-6">
                    <h3 class="text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC] mb-4">Đổi mật khẩu</h3>
                    <p class="text-sm text-[#706f6c] dark:text-[#A1A09A] mb-4">Để lại trống nếu không muốn thay đổi mật khẩu</p>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">
                                Mật khẩu hiện tại
                            </label>
                            <input type="password"
                                   id="current_password"
                                   name="current_password"
                                   class="w-full px-4 py-3 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg focus:ring-2 focus:ring-[#f53003] focus:border-transparent dark:bg-[#0a0a0a] dark:text-[#EDEDEC] transition-colors">
                            <div id="current_password-error" class="text-red-500 text-sm mt-1 hidden"></div>
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">
                                Mật khẩu mới
                            </label>
                            <input type="password"
                                   id="password"
                                   name="password"
                                   class="w-full px-4 py-3 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg focus:ring-2 focus:ring-[#f53003] focus:border-transparent dark:bg-[#0a0a0a] dark:text-[#EDEDEC] transition-colors">
                            <div id="password-error" class="text-red-500 text-sm mt-1 hidden"></div>
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">
                                Xác nhận mật khẩu mới
                            </label>
                            <input type="password"
                                   id="password_confirmation"
                                   name="password_confirmation"
                                   class="w-full px-4 py-3 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg focus:ring-2 focus:ring-[#f53003] focus:border-transparent dark:bg-[#0a0a0a] dark:text-[#EDEDEC] transition-colors">
                            <div id="password_confirmation-error" class="text-red-500 text-sm mt-1 hidden"></div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-4 pt-6 border-t border-[#e3e3e0] dark:border-[#3E3E3A]">
                    <a href="{{ route('dashboard') }}"
                       class="px-6 py-3 border border-[#e3e3e0] dark:border-[#3E3E3A] text-[#706f6c] dark:text-[#A1A09A] rounded-lg hover:bg-[#f8f8f7] dark:hover:bg-[#1D1D1A] transition-colors">
                        Hủy
                    </a>
                    <button type="submit"
                            class="px-6 py-3 bg-[#f53003] hover:bg-[#F61500] text-white rounded-lg transition-colors focus:ring-2 focus:ring-[#f53003] focus:ring-offset-2">
                        Cập nhật thông tin
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="message" class="fixed top-4 right-4 p-4 rounded-lg shadow-lg hidden z-50"></div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('profileForm');
    const messageDiv = document.getElementById('message');

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
        messageDiv.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 ${type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'}`;
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
        const address = document.getElementById('address').value.trim();
        const currentPassword = document.getElementById('current_password').value;
        const password = document.getElementById('password').value;
        const passwordConfirmation = document.getElementById('password_confirmation').value;

        // Clear previous errors
        ['name', 'email', 'phone', 'address', 'current_password', 'password', 'password_confirmation'].forEach(hideError);

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

        if (address && address.length > 500) {
            showError('address', 'Địa chỉ không được vượt quá 500 ký tự');
            hasError = true;
        }

        // Password validation
        if (password || passwordConfirmation) {
            if (!currentPassword) {
                showError('current_password', 'Vui lòng nhập mật khẩu hiện tại');
                hasError = true;
            }

            if (password && password.length < 8) {
                showError('password', 'Mật khẩu mới phải có ít nhất 8 ký tự');
                hasError = true;
            }

            if (password !== passwordConfirmation) {
                showError('password_confirmation', 'Xác nhận mật khẩu không khớp');
                hasError = true;
            }
        }

        if (hasError) return;

        // Submit form
        const formData = new FormData(form);
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;

        submitBtn.textContent = 'Đang cập nhật...';
        submitBtn.disabled = true;

        try {
            const response = await fetch('{{ route("profile.update") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            const data = await response.json();

            if (data.success) {
                showMessage(data.message, 'success');
                // Clear password fields
                document.getElementById('current_password').value = '';
                document.getElementById('password').value = '';
                document.getElementById('password_confirmation').value = '';
            } else {
                if (data.errors) {
                    Object.keys(data.errors).forEach(field => {
                        showError(field, data.errors[field][0]);
                    });
                } else {
                    showMessage(data.message || 'Cập nhật thất bại', 'error');
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
