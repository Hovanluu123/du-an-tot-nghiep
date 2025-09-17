<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'FitZone') - {{ config('app.name', 'Laravel') }}</title>

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
                    <a href="{{ route('dashboard') }}" class="text-2xl font-bold text-[#f53003] hover:text-[#F61500] transition-colors">
                        FitZone
                    </a>
                </div>

                <div class="flex items-center space-x-6">
                    @auth
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('dashboard') }}"
                               class="text-[#706f6c] dark:text-[#A1A09A] hover:text-[#f53003] transition-colors {{ request()->routeIs('dashboard') ? 'text-[#f53003] font-medium' : '' }}">
                                Dashboard
                            </a>
                            <a href="{{ route('profile') }}"
                               class="text-[#706f6c] dark:text-[#A1A09A] hover:text-[#f53003] transition-colors {{ request()->routeIs('profile') ? 'text-[#f53003] font-medium' : '' }}">
                                Thông tin cá nhân
                            </a>

                            @if(Auth::user()->isAdmin())
                                <a href="{{ route('admin.home') }}"
                                   class="text-[#706f6c] dark:text-[#A1A09A] hover:text-[#f53003] transition-colors">
                                    Quản trị
                                </a>
                            @endif
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
                    @else
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('login') }}"
                               class="text-[#706f6c] dark:text-[#A1A09A] hover:text-[#f53003] transition-colors">
                                Đăng nhập
                            </a>
                            <a href="{{ route('register') }}"
                               class="bg-[#f53003] hover:bg-[#F61500] text-white px-4 py-2 rounded-lg transition-colors">
                                Đăng ký
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <script>
        window.Laravel = {
            csrfToken: '{{ csrf_token() }}'
        };
    </script>
</body>
</html>
