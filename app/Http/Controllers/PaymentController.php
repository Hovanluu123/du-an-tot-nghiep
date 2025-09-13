<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Http\Requests\CreateOrderRequest;
use App\Support\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function createOrder(CreateOrderRequest $request)
    {
        $validated = $request->validated();

        return DB::transaction(function () use ($validated) {
            // Tính tổng tiền
            $totalAmount = 0;
            $orderItems = [];

            foreach ($validated['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);
                $itemTotal = $product->price * $item['quantity'];
                $totalAmount += $itemTotal;

                $orderItems[] = [
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                ];
            }

            // Tạo đơn hàng
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'shipping_method' => $validated['shipping_method'] ?? null,
                'transport_company' => $validated['transport_company'] ?? null,
            ]);

            // Tạo chi tiết đơn hàng
            foreach ($orderItems as $item) {
                $order->orderItems()->create($item);
            }

            // Tạo payment
            $payment = Payment::create([
                'order_id' => $order->id,
                'method' => $validated['payment_method'],
                'amount' => $totalAmount,
                'status' => 'pending',
            ]);

            // Xử lý theo phương thức thanh toán
            if ($validated['payment_method'] === 'cod') {
                return ApiResponse::created([
                    'order' => $order->load('orderItems.product'),
                    'payment' => $payment,
                ], 'Đơn hàng COD đã được tạo thành công. Vui lòng chờ xác nhận.');
            }

            if ($validated['payment_method'] === 'vnpaytest') {
                // Tạo URL thanh toán VNPAY (test)
                $vnpayUrl = $this->createVnpayUrl($order, $payment);

                return ApiResponse::created([
                    'order' => $order->load('orderItems.product'),
                    'payment' => $payment,
                    'vnpay_url' => $vnpayUrl,
                ], 'Đơn hàng VNPAY đã được tạo. Vui lòng thanh toán.');
            }
        });
    }

    private function createVnpayUrl(Order $order, Payment $payment): string
    {
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = url('/api/payment/vnpay/callback');
        $vnp_TmnCode = "HW9RA4KF";
        $vnp_HashSecret = "TR3QKBZQJPHH81R0YCIR0U55MZR91A25";

        $vnp_TxnRef = 'ORDER_' . $order->id . '_' . time();
        $vnp_OrderInfo = 'Thanh toan don hang #' . $order->id;
        $vnp_OrderType = 'other';
        $vnp_Amount = $payment->amount * 100;
        $vnp_Locale = 'vn';
        $vnp_IpAddr = request()->ip();

        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        ];

        ksort($inputData);
        $query = '';
        $i = 0;
        $hashdata = '';
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        $payment->update(['transaction_id' => $vnp_TxnRef]);

        return $vnp_Url;
    }

    public function vnpayCallback(Request $request)
    {
        $vnp_HashSecret = "TR3QKBZQJPHH81R0YCIR0U55MZR91A25";
        $vnp_SecureHash = $request->input('vnp_SecureHash');
        $vnp_TxnRef = $request->input('vnp_TxnRef');
        $vnp_ResponseCode = $request->input('vnp_ResponseCode');

        // Tìm payment theo transaction_id
        $payment = Payment::where('transaction_id', $vnp_TxnRef)->first();

        if (!$payment) {
            return ApiResponse::error('Giao dịch không tồn tại', 404);
        }

        // Kiểm tra chữ ký
        $inputData = $request->except(['vnp_SecureHash']);
        ksort($inputData);
        $hashdata = '';
        $i = 0;
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);

        if ($secureHash !== $vnp_SecureHash) {
            return ApiResponse::error('Chữ ký không hợp lệ', 400);
        }

        // Cập nhật trạng thái payment
        if ($vnp_ResponseCode === '00') {
            $payment->update([
                'status' => 'completed',
                'vnpay_response' => $request->all(),
            ]);

            $payment->order->update(['status' => 'pending']);

            return ApiResponse::success([
                'order' => $payment->order->load('orderItems.product'),
                'payment' => $payment,
            ], 'Thanh toán thành công');
        } else {
            $payment->update([
                'status' => 'failed',
                'vnpay_response' => $request->all(),
            ]);

            return ApiResponse::error('Thanh toán thất bại', 400);
        }
    }

    public function getOrders(Request $request)
    {
        $user = Auth::user();
        $orders = Order::with(['orderItems.product', 'payments'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return ApiResponse::success($orders);
    }

    public function getOrder($id)
    {
        $order = Order::with(['orderItems.product', 'payments'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return ApiResponse::success($order);
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,failed'
        ]);

        $order = Order::where('user_id', Auth::id())->findOrFail($id);
        $order->update(['status' => $request->status]);

        return ApiResponse::success($order, 'Cập nhật trạng thái đơn hàng thành công');
    }

    public function updatePaymentStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,failed'
        ]);

        $payment = Payment::whereHas('order', function($query) {
            $query->where('user_id', Auth::id());
        })->findOrFail($id);

        $payment->update(['status' => $request->status]);

        return ApiResponse::success($payment, 'Cập nhật trạng thái thanh toán thành công');
    }
}
