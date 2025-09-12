<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'FitZone')</title>

    @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    @endif
</head>
<body class="bg-gradient-to-b from-gray-50 to-white text-gray-900 min-h-screen">
    <style>
        :root{--primary:#ff4d2d;--primary-600:#ff3a17;--primary-700:#e63213}
        .btn{display:inline-flex;align-items:center;justify-content:center;border-radius:.5rem;padding:.5rem .875rem;font-weight:600}
        .btn-primary{background:var(--primary);color:#fff}
        .btn-primary:hover{background:var(--primary-600)}
        .btn-outline{border:1px solid var(--primary);color:var(--primary);background:#fff}
        .btn-outline:hover{background:var(--primary);color:#fff}
        .chip{border:1px solid #e5e7eb;border-radius:.5rem;padding:.375rem .75rem}
        .chip-active{border-color:var(--primary);color:var(--primary);background:#fff5f3}
        .link{color:#111827}
        .link:hover{color:var(--primary)}
        .brand{color:#111827}
        .brand b{color:var(--primary)}
        .price{color:var(--primary-700);font-weight:700}
        .card{background:#fff;border:1px solid #e5e7eb;border-radius:.75rem;transition:.2s;overflow:hidden}
        .card:hover{box-shadow:0 8px 24px rgb(0 0 0 / .08);transform:translateY(-2px)}
    </style>
    <header class="bg-white/90 backdrop-blur sticky top-0 z-40 border-b">
        <div class="container mx-auto px-4 py-4 flex items-center gap-6">
            <a href="{{ route('home') }}" class="text-2xl font-extrabold tracking-tight brand">Fit<b>Zone</b></a>
            <form action="{{ route('shop.products') }}" class="hidden md:flex items-center flex-1 max-w-xl">
                <input name="q" value="{{ request('q') }}" placeholder="Tìm kiếm sản phẩm, danh mục..." class="w-full rounded-l-lg border border-gray-300 px-4 py-2 focus:ring-2 focus:ring-[var(--primary)] focus:border-[var(--primary)]">
                <button class="rounded-r-lg btn btn-primary">Tìm</button>
            </form>
            <nav class="ml-auto flex items-center gap-4 text-sm font-medium">
                <a class="link" href="{{ route('home') }}">Trang chủ</a>
                <a class="link" href="{{ route('shop.products') }}">Sản phẩm</a>
                <a class="inline-flex items-center gap-2 chip hover:bg-gray-50" href="{{ route('cart.index') }}"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>Giỏ hàng</a>
            </nav>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8">
        @yield('content')
    </main>

    <footer class="border-t bg-white/70">
        <div class="container mx-auto px-4 py-8 text-sm text-gray-500 flex flex-col md:flex-row items-center justify-between gap-4">
            <div>© {{ date('Y') }} <span class="font-semibold">FitZone</span>. All rights reserved.</div>
            <div class="flex items-center gap-4">
                <a class="hover:text-blue-600" href="{{ route('shop.products') }}">Sản phẩm</a>
                <a class="hover:text-blue-600" href="{{ route('cart.index') }}">Giỏ hàng</a>
            </div>
        </div>
    </footer>
</body>
</html>


