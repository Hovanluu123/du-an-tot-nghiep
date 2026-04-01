<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FitZone - Giỏ hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">Fit<b>Zone</b></a>
            <div class="ms-auto">
                <a class="btn btn-outline-secondary" href="{{ route('shop.products') }}">Tiếp tục mua sắm</a>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        <h3 class="mb-3">Giỏ hàng</h3>

        @if(empty($items))
            <div class="alert alert-info">Giỏ hàng trống. <a href="{{ route('shop.products') }}" class="alert-link">Tiếp tục mua sắm</a></div>
        @else
            <div class="card">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Sản phẩm</th>
                                <th class="text-end">Giá</th>
                                <th class="text-center">Số lượng</th>
                                <th class="text-end">Thành tiền</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($items as $item)
                            @php($pid = $item['product']->id ?? $item['product']['id'] ?? 1)
                            <tr>
                                <td>
                                    <div class="fw-semibold">{{ $item['product']->name ?? $item['product']['name'] }}</div>
                                </td>
                                <td class="text-end">{{ number_format($item['price'], 0, ',', '.') }} VNĐ</td>
                                <td class="text-center">
                                    <form action="{{ route('cart.update', $pid) }}" method="post" class="d-inline-flex align-items-center gap-2">
                                        @csrf
                                        <input class="form-control" style="width:100px" type="number" name="quantity" value="{{ $item['quantity'] }}" min="0">
                                        <button class="btn btn-danger">Cập nhật</button>
                                    </form>
                                </td>
                                <td class="text-end">{{ number_format($item['lineTotal'], 0, ',', '.') }} VNĐ</td>
                                <td class="text-end">
                                    <form action="{{ route('cart.remove', $pid) }}" method="post" class="d-inline">
                                        @csrf
                                        <button class="btn btn-outline-secondary">Xoá</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="d-flex align-items-center justify-content-between mt-3">
                <form action="{{ route('cart.clear') }}" method="post">
                    @csrf
                    <button class="btn btn-outline-secondary">Xoá tất cả</button>
                </form>
                <div class="fs-5">Tổng: <span class="fw-bold text-danger">{{ number_format($subtotal, 0, ',', '.') }} VNĐ</span></div>
            </div>
        @endif
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


