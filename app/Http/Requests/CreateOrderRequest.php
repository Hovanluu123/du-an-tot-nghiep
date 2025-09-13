<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'payment_method' => ['required', 'string', 'in:cod,vnpaytest'],
            'shipping_method' => ['nullable', 'string'],
            'transport_company' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'items.required' => 'Vui lòng chọn sản phẩm.',
            'items.min' => 'Phải có ít nhất 1 sản phẩm.',
            'items.*.product_id.required' => 'ID sản phẩm không được để trống.',
            'items.*.product_id.exists' => 'Sản phẩm không tồn tại.',
            'items.*.quantity.required' => 'Số lượng không được để trống.',
            'items.*.quantity.min' => 'Số lượng phải lớn hơn 0.',
            'payment_method.required' => 'Vui lòng chọn phương thức thanh toán.',
            'payment_method.in' => 'Phương thức thanh toán không hợp lệ.',
        ];
    }

    public function attributes(): array
    {
        return [
            'items' => 'Danh sách sản phẩm',
            'payment_method' => 'Phương thức thanh toán',
            'shipping_method' => 'Phương thức giao hàng',
            'transport_company' => 'Công ty vận chuyển',
        ];
    }
}
