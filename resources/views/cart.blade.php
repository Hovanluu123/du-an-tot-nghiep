@extends('layouts.app')

@section('title', 'Giỏ hàng')

@section('content')
    <h2>Giỏ hàng</h2>
    @if (count($cart) > 0)
        <table class="table table-striped cart-table">
            <thead>
                <tr>
                    <th>Ảnh</th>
                    <th>Tên</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cart as $item)
                    <tr data-id="{{ $item['id'] }}">
                        <td><img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}"
                                style="max-width: 50px;"></td>
                        <td>{{ $item['name'] }}</td>
                        <td class="price-{{ $item['id'] }}">{{ number_format($item['price'], 0, ',', '.') }} VNĐ</td>
                        <td>
                            <input type="number" class="form-control quantity-input" data-id="{{ $item['id'] }}"
                                value="{{ $item['quantity'] }}" min="1" style="width: 80px;">
                            <button class="btn btn-sm btn-primary mt-1 update-quantity" data-id="{{ $item['id'] }}">Cập
                                nhật</button>
                        </td>
                        <td class="subtotal-{{ $item['id'] }}">
                            {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} VNĐ</td>
                        <td>
                            <button class="btn btn-sm btn-danger remove-item" data-id="{{ $item['id'] }}">Xóa</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="cart-summary">Tổng số sản phẩm:</td>
                    <td colspan="2" class="cart-summary total-items">{{ array_sum(array_column($cart, 'quantity')) }}
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="cart-summary">Tổng tiền:</td>
                    <td colspan="2" class="cart-summary total-amount">
                        {{ number_format(array_sum(array_map(function ($item) {return $item['price'] * $item['quantity'];}, $cart)),0,',','.') }}
                        VNĐ</td>
                </tr>
            </tfoot>
        </table>
    @else
        {{-- <p>Giỏ hàng của bạn trống.</p> --}}
    @endif
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Cập nhật số lượng sản phẩm
        $('.update-quantity').click(function() {
            let productId = $(this).data('id');
            let quantity = $(this).closest('tr').find('.quantity-input').val();

            $.ajax({
                url: '/cart/update/' + productId,
                method: 'POST',
                data: {
                    product_id: productId,
                    quantity: quantity,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        let price = parseInt($(`.price-${productId}`).text().replace(/\D/g, ''));
                        let subtotal = price * quantity;
                        $(`.subtotal-${productId}`).text(numberFormat(subtotal) + ' VNĐ');
                        updateTotals();
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr) {
                    alert('Lỗi khi cập nhật số lượng: ' + (xhr.responseJSON ? xhr.responseJSON.message : 'Lỗi không xác định'));
                }
            });
        });

        // Xóa sản phẩm khỏi giỏ hàng
        $('.remove-item').click(function() {
            let productId = $(this).data('id');
            if (confirm('Bạn có chắc muốn xóa sản phẩm này?')) {
                $.ajax({
                    url: '/cart/remove/' + productId,
                    method: 'POST',
                    data: {
                        product_id: productId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            $('tr[data-id="' + productId + '"]').remove();
                            updateTotals();
                            if ($('.cart-table tbody tr').length === 0) {
                                location.reload();
                            }
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr) {
                        alert('Lỗi khi xóa sản phẩm: ' + (xhr.responseJSON ? xhr.responseJSON.message : 'Lỗi không xác định'));
                    }
                });
            }
        });

        // Cập nhật tổng số lượng và tổng tiền
        function updateTotals() {
            let totalItems = 0;
            let totalAmount = 0;

            $('.cart-table tbody tr').each(function() {
                let quantity = parseInt($(this).find('.quantity-input').val());
                let subtotalText = $(this).find('td[class^="subtotal-"]').text();
                let subtotal = parseInt(subtotalText.replace(/\D/g, ''));

                totalItems += quantity;
                totalAmount += subtotal;
            });

            $('.total-items').text(totalItems);
            $('.total-amount').text(numberFormat(totalAmount) + ' VNĐ');
        }

        // Định dạng số tiền
        function numberFormat(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }
    });
</script>
@endpush

