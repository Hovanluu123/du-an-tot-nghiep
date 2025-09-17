@extends('admin.layout')

@section('title', 'Admin Dashboard')
@section('page-title', 'Admin Dashboard')

@section('content')
<div class="px-4 py-6 sm:px-0">
    <div class="bg-white dark:bg-[#161615] rounded-lg shadow-lg p-8">
        <h2 class="text-3xl font-bold text-[#1b1b18] dark:text-[#EDEDEC] mb-6">
            Chào mừng đến với FitZone! 🏃‍♂️
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <div class="bg-gradient-to-r from-[#f53003] to-[#F61500] rounded-lg p-6 text-white">
                <h3 class="text-xl font-semibold mb-2">Thông tin cá nhân</h3>
                <p class="text-sm opacity-90">Email: {{ Auth::user()->email }}</p>
                <p class="text-sm opacity-90">SĐT: {{ Auth::user()->phone ?? 'Chưa cập nhật' }}</p>
            </div>

            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-6 text-white">
                <h3 class="text-xl font-semibold mb-2">Sản phẩm</h3>
                <p class="text-sm opacity-90">Khám phá các sản phẩm thể thao</p>
            </div>

            <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-6 text-white">
                <h3 class="text-xl font-semibold mb-2">Đơn hàng</h3>
                <p class="text-sm opacity-90">Theo dõi đơn hàng của bạn</p>
            </div>
        </div>

        <div class="bg-[#fff2f2] dark:bg-[#1D0002] rounded-lg p-6">
            <h3 class="text-xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC] mb-4">
                Tính năng sắp có
            </h3>
            <ul class="space-y-2 text-[#706f6c] dark:text-[#A1A09A]">
                <li>• Danh mục sản phẩm thể thao đa dạng</li>
                <li>• Giỏ hàng và thanh toán online</li>
                <li>• Theo dõi đơn hàng real-time</li>
                <li>• Hệ thống đánh giá sản phẩm</li>
                <li>• Chương trình khuyến mãi hấp dẫn</li>
            </ul>
        </div>
    </div>
</div>
@endsection
