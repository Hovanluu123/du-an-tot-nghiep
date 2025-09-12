<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FitZone - Trang chủ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root{--primary:#ff4d2d}
        .navbar-brand b{color:var(--primary)}
        .category-menu .nav-link{color:#222;font-weight:600}
        .category-menu .nav-link:hover{color:var(--primary)}
        .product-card{border:1px solid #eaeaea;border-radius:12px;overflow:hidden;transition:.2s;background:#fff}
        .product-card:hover{box-shadow:0 12px 28px rgba(0,0,0,.08);transform:translateY(-2px)}
        .product-thumb{aspect-ratio:4/3;object-fit:cover}
        .product-actions{position:absolute;inset:0;display:flex;gap:.5rem;align-items:center;justify-content:center;background:rgba(0,0,0,.4);opacity:0;transition:.2s}
        .product-card:hover .product-actions{opacity:1}
        .project-item{min-width:260px}
        .footer a{color:#222}
        .footer a:hover{color:var(--primary)}
    </style>
</head>
<body>
    <!-- section 1: header + category menu -->
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

    <!-- section 2: banner slideshow full width -->
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://images.unsplash.com/photo-1554344728-77cf90d9ed26?q=80&w=1920&auto=format&fit=crop" class="d-block w-100" style="max-height:520px;object-fit:cover" alt="slide1">
                <div class="carousel-caption text-start">
                    <h2 class="fw-bold">Trang thiết bị Fitness hiện đại</h2>
                    <p>Nâng tầm trải nghiệm tập luyện của bạn.</p>
                    <a href="#products" class="btn btn-danger">Xem sản phẩm</a>
                </div>
            </div>
            <div class="carousel-item">
                <img src="https://images.unsplash.com/photo-1517836357463-d25dfeac3438?q=80&w=1920&auto=format&fit=crop" class="d-block w-100" style="max-height:520px;object-fit:cover" alt="slide2">
                <div class="carousel-caption">
                    <h2 class="fw-bold">Phụ kiện thể thao cao cấp</h2>
                    <p>Đồng hành cùng mục tiêu sức khỏe của bạn.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- section 3: products list + projects -->
    <section id="products" class="py-5 bg-light">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h3 class="m-0">Sản phẩm tiêu biểu</h3>
                <a class="btn btn-outline-danger" href="{{ route('shop.products') }}">Xem tất cả</a>
            </div>
            <div class="row g-4">
                @foreach(collect($featuredProducts)->take(8) as $p)
                    @php($slug = is_array($p) ? $p['slug'] : ($p->slug ?? 'san-pham'))
                    @php($img = is_array($p) ? $p['main_image'] : ($p->main_image ?? 'https://placehold.co/600x400'))
                    @php($name = is_array($p) ? $p['name'] : ($p->name ?? 'Sản phẩm'))
                    @php($price = is_array($p) ? (($p['formatted_sale_price'] ?? $p['formatted_price']) ) : (($p->formatted_sale_price ?? $p->formatted_price) ))
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="product-card position-relative h-100">
                            <img class="w-100 product-thumb" src="{{ $img }}" alt="{{ $name }}">
                            <div class="p-3">
                                <div class="fw-semibold">{{ $name }}</div>
                                <div class="text-danger fw-bold">{{ $price }}</div>
                            </div>
                            <div class="product-actions">
                                <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#quickViewModal" data-name="{{ $name }}" data-img="{{ $img }}" data-price="{{ $price }}">Xem nhanh</button>
                                <a class="btn btn-danger" href="tel:0900000000">Liên hệ</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div id="projects" class="mt-5">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h4 class="m-0">Sản phẩm mới</h4>
                </div>
                <div class="d-flex gap-3 overflow-auto pb-2">
                    @php($items = collect($featuredProducts)->take(8)->values())
                    @for($i=0;$i<10;$i++)
                        @php($p = $items->get($i % max(1, $items->count())))
                        @php($slug = is_array($p) ? $p['slug'] : ($p->slug ?? 'san-pham'))
                        @php($img = is_array($p) ? $p['main_image'] : ($p->main_image ?? 'https://placehold.co/600x400'))
                        @php($name = is_array($p) ? $p['name'] : ($p->name ?? 'Sản phẩm'))
                        @php($price = is_array($p) ? (($p['formatted_sale_price'] ?? $p['formatted_price'])) : (($p->formatted_sale_price ?? $p->formatted_price)))
                        <div class="project-item card border-0 shadow-sm" style="min-width:220px">
                            <a href="{{ route('shop.product', $slug) }}" class="text-decoration-none text-dark">
                                <img src="{{ $img }}" class="card-img-top" style="aspect-ratio: 4/3; object-fit: cover" alt="{{ $name }}">
                                <div class="card-body">
                                    <div class="card-title fw-semibold mb-1">{{ $name }}</div>
                                    <small class="text-danger fw-bold">{{ $price }}</small>
                                </div>
                            </a>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </section>

    <!-- section 4: footer -->
    <footer class="footer border-top py-4">
        <div class="container d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
            <div>© {{ date('Y') }} FitZone</div>
            <div class="d-flex gap-3 fs-4">
                <a href="https://zalo.me" target="_blank" rel="noopener" title="Zalo"><i class="bi bi-chat-left-dots"></i></a>
                <a href="tel:0900000000" title="Gọi ngay"><i class="bi bi-telephone"></i></a>
                <a href="mailto:contact@fitzone.vn" title="Email"><i class="bi bi-envelope"></i></a>
                <a href="https://facebook.com" target="_blank" rel="noopener" title="Facebook"><i class="bi bi-facebook"></i></a>
            </div>
        </div>
    </footer>

    <!-- Quick view modal -->
    <div class="modal fade" id="quickViewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="qvTitle">Sản phẩm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <img id="qvImg" class="w-100 rounded" src="" alt="">
                        </div>
                        <div class="col-md-6">
                            <h4 id="qvName"></h4>
                            <div class="text-danger fw-bold mb-3" id="qvPrice"></div>
                            <p>Mô tả ngắn gọn về sản phẩm. Thiết kế hiện đại, vật liệu cao cấp, đáp ứng nhu cầu luyện tập chuyên nghiệp và gia đình.</p>
                            <a class="btn btn-danger" href="tel:0900000000">Liên hệ tư vấn</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Smooth page transition fade-in/out
        document.body.style.opacity = 0; document.addEventListener('DOMContentLoaded',()=>{document.body.style.transition='opacity .25s ease';document.body.style.opacity=1});
        window.addEventListener('beforeunload',()=>{document.body.style.opacity=0});
        const qvModal = document.getElementById('quickViewModal');
        if (qvModal) {
            qvModal.addEventListener('show.bs.modal', event => {
                const button = event.relatedTarget;
                document.getElementById('qvName').textContent = button.getAttribute('data-name');
                document.getElementById('qvTitle').textContent = button.getAttribute('data-name');
                document.getElementById('qvImg').src = button.getAttribute('data-img');
                document.getElementById('qvPrice').textContent = button.getAttribute('data-price');
            });
        }
    </script>
</body>
</html>


