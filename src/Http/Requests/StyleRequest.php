<?php

declare(strict_types=1);

namespace Applets\Merchandising\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StyleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'purchase_order_id' => ['required', 'integer', 'exists:purchase_orders,id'],
            'style_no' => ['required', 'string', 'max:100'],
            'style_name' => ['required', 'string', 'max:255'],
            'qty' => ['required', 'integer', 'min:1'],
            'unit_price' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'qty.min' => 'Quantity must be at least 1',
            'unit_price.min' => 'Unit price must be a positive number',
        ];
    }
}
