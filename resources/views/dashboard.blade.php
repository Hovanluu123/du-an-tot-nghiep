<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Dashboard - FitZone</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    
    @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/axios@1.6.0/dist/axios.min.js"></script>
    @endif
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] min-h-screen">
    <nav class="bg-white dark:bg-[#161615] shadow-sm border-b border-[#e3e3e0] dark:border-[#3E3E3A]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-[#f53003]">FitZone</h1>
                </div>
                
                <div class="flex items-center space-x-4">
                    <span class="text-[#706f6c] dark:text-[#A1A09A]">
                        Xin chào, {{ Auth::user()->name }}!
                    </span>
                    
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" 
                                class="text-[#f53003] hover:text-[#F61500] font-medium transition-colors">
                            Đăng xuất
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
    
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
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
    </main>
</body>
</html>
