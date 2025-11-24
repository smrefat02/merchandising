<?php

declare(strict_types=1);

namespace Applets\Merchandising\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SalesContractRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $contractId = $this->route('sales_contract');

        return [
            'contract_no' => [
                'required',
                'string',
                'max:100',
                Rule::unique('sales_contracts', 'contract_no')->ignore($contractId),
            ],
            'buyer_id' => ['required', 'integer', 'exists:buyers,id'],
            'season' => ['required', 'string', 'max:100'],
            'revision' => ['required', 'string', 'max:50'],
            'issue_date' => ['required', 'date'],
            'merchandiser_id' => ['required', 'integer', 'exists:users,id'],
            'shipment_terms' => ['required', 'string', 'max:150'],
            'payment_terms' => ['required', 'string', 'max:150'],
            'shipment_date' => ['nullable', 'date'],
            'expiry_date' => ['nullable', 'date'],
            'mode_of_shipment' => ['required', 'string', 'in:sea,air,courier'],
            'allow_partial_shipment' => ['required', 'boolean'],
            'allow_transshipment' => ['required', 'boolean'],
            'bank_details' => ['nullable', 'string'],
            'remarks' => ['nullable', 'string'],
        ];
    }
}
