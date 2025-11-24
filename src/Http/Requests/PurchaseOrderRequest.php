<?php

declare(strict_types=1);

namespace Applets\Merchandising\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PurchaseOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $purchaseOrderId = $this->route('purchase_order');

        return [
            'sales_contract_id' => ['required', 'integer', 'exists:sales_contracts,id'],
            'po_no' => [
                'required',
                'string',
                'max:100',
                Rule::unique('purchase_orders', 'po_no')->ignore($purchaseOrderId),
            ],
            'buyer_ref' => ['nullable', 'string', 'max:100'],
            'dept' => ['required', 'string', 'max:100'],
            'class' => ['required', 'string', 'max:100'],
            'subclass' => ['nullable', 'string', 'max:100'],
            'season' => ['required', 'string', 'max:50'],
            'handover_date' => ['nullable', 'date'],
            'delivery_date' => ['nullable', 'date', 'after_or_equal:handover_date'],
            'total_qty' => ['required', 'integer', 'min:1'],
            'value_usd' => ['required', 'numeric', 'min:0'],
        ];
    }
}
