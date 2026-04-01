<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FitZone - Sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root{--primary:#ff4d2d}
        .navbar-brand b{color:var(--primary)}
        .product-card{border:1px solid #eaeaea;border-radius:12px;overflow:hidden;transition:.2s;background:#fff;height:100%}
        .product-card:hover{box-shadow:0 12px 28px rgba(0,0,0,.08);transform:translateY(-2px)}
        .product-thumb{aspect-ratio:4/3;object-fit:cover}
        .chip{border:1px solid #e5e7eb;border-radius:10rem;padding:.35rem .75rem;display:inline-block}
        .chip.active{border-color:var(--primary);color:var(--primary);background:#fff5f3}
    </style>
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
                    <li class="nav-item"><a class="nav-link active" href="{{ route('shop.products') }}">Sản phẩm</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('cart.index') }}"><i class="bi bi-cart3"></i> Giỏ hàng</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4 bg-light">
        <div class="container">
            <div class="row g-4">
                <aside class="col-12 col-lg-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="fw-semibold mb-3">Danh mục</div>
                            <div class="mb-2">
                                <a class="chip {{ request('category') ? '' : 'active' }}" href="{{ route('shop.products') }}">Tất cả</a>
                            </div>
                            @foreach($categories as $cat)
                                @php($cSlug = is_array($cat) ? ($cat['slug'] ?? '') : ($cat->slug ?? ''))
                                @php($cName = is_array($cat) ? ($cat['name'] ?? '') : ($cat->name ?? ''))
                                <div class="mb-2">
                                    <a class="chip {{ (request('category') === $cSlug) ? 'active' : '' }}" href="{{ route('shop.products', ['category' => $cSlug] + request()->except('page')) }}">{{ $cName }}</a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </aside>

                <section class="col-12 col-lg-9">
                    <div class="row g-4">
                        @forelse($products as $product)
                            @php($slug = $product['slug'] ?? ($product->slug ?? 'san-pham'))
                            @php($img = $product['main_image'] ?? ($product->main_image ?? 'https://placehold.co/600x400'))
                            @php($name = $product['name'] ?? ($product->name ?? 'Sản phẩm'))
                            @php($price = ($product['formatted_sale_price'] ?? null) ?: ($product['formatted_price'] ?? $product->formatted_price ?? ''))
                            @php($pid = $product['id'] ?? ($product->id ?? 1))
                            <div class="col-6 col-md-4">
                                <div class="product-card">
                                    <a href="{{ route('shop.product', $slug) }}" class="text-decoration-none text-dark">
                                        <img class="w-100 product-thumb" src="{{ $img }}" alt="{{ $name }}">
                                        <div class="p-3">
                                            <div class="fw-semibold mb-1">{{ $name }}</div>
                                            <div class="text-danger fw-bold">{{ $price }}</div>
                                        </div>
                                    </a>
                                    <div class="p-3 pt-0">
                                        <form action="{{ route('cart.add', $pid) }}" method="post">
                                            @csrf
                                            <button class="btn btn-danger w-100"><i class="bi bi-cart-plus"></i> Thêm vào giỏ</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12"><p>Không có sản phẩm phù hợp.</p></div>
                        @endforelse
                    </div>
                </section>
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
</body>
</html>


