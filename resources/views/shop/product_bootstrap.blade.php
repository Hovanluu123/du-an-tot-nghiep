<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $product->name }} - FitZone</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root{--primary:#ff4d2d}
        .navbar-brand b{color:var(--primary)}
        .price{color:#e03516;font-weight:700}
    </style>
    <script>
        if ('scrollRestoration' in history) { history.scrollRestoration = 'manual'; }
    </script>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">Fit<b>Zone</b></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <form class="ms-auto me-3 d-none d-lg-flex" action="{{ route('shop.products') }}">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="{{ request('q') }}" placeholder="Tìm kiếm sản phẩm...">
                        <button class="btn btn-danger">Tìm</button>
                    </div>
                </form>
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('shop.products') }}">Sản phẩm</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('cart.index') }}"><i class="bi bi-cart3"></i> Giỏ hàng</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-5 bg-light">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6">
                    <img class="w-100 rounded shadow-sm" src="{{ $product->images[0] ?? $product->main_image }}" alt="{{ $product->name }}">
                </div>
                <div class="col-md-6">
                    <h1 class="h3">{{ $product->name }}</h1>
                    <div class="price h4 mb-3">{{ $product->formatted_sale_price ?? $product->formatted_price }}</div>
                    <p>{{ $product->description }}</p>
                    <form action="{{ route('cart.add', $product->id) }}" method="post" class="d-grid gap-2 d-md-block">
                        @csrf
                        <button class="btn btn-danger btn-lg"><i class="bi bi-cart-plus"></i> Thêm vào giỏ</button>
                    </form>
                </div>
            </div>

            <hr class="my-5">
            <h3>Sản phẩm liên quan</h3>
            <div class="row g-4">
                @foreach($relatedProducts as $p)
                    <div class="col-6 col-md-3">
                        <a href="{{ route('shop.product', $p['slug'] ?? $p->slug) }}" class="text-decoration-none text-dark">
                            <div class="card h-100">
                                <img src="{{ $p['main_image'] ?? $p->main_image }}" class="card-img-top" style="aspect-ratio:4/3;object-fit:cover" alt="{{ $p['name'] ?? $p->name }}">
                                <div class="card-body">
                                    <div class="card-title fw-semibold">{{ $p['name'] ?? $p->name }}</div>
                                    <div class="text-danger fw-bold">{{ ($p['formatted_sale_price'] ?? null) ?: ($p['formatted_price'] ?? '') }}</div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </main>

    <footer class="border-top py-4 bg-white">
        <div class="container d-flex justify-content-between align-items-center">
            <div>© {{ date('Y') }} FitZone</div>
            <div class="d-flex gap-3 fs-5">
                <a href="https://zalo.me" target="_blank" rel="noopener" class="text-decoration-none text-dark"><i class="bi bi-chat-left-dots"></i></a>
                <a href="tel:0900000000" class="text-decoration-none text-dark"><i class="bi bi-telephone"></i></a>
                <a href="mailto:contact@fitzone.vn" class="text-decoration-none text-dark"><i class="bi bi-envelope"></i></a>
                <a href="https://facebook.com" target="_blank" rel="noopener" class="text-decoration-none text-dark"><i class="bi bi-facebook"></i></a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Smooth page transition (fade)
        document.body.style.opacity = 0; document.addEventListener('DOMContentLoaded',()=>{document.body.style.transition='opacity .25s ease';document.body.style.opacity=1});
        window.addEventListener('beforeunload',()=>{document.body.style.opacity=0});
    </script>
</body>
</html>


