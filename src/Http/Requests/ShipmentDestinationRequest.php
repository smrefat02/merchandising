<?php

declare(strict_types=1);

namespace Applets\Merchandising\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShipmentDestinationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sales_contract_id' => ['required', 'integer', 'exists:sales_contracts,id'],
            'destination_code' => ['required', 'string', 'max:50'],
            'country' => ['required', 'string', 'max:100'],
            'port' => ['required', 'string', 'max:150'],
            'final_destination' => ['required', 'string', 'max:255'],
            'units' => ['required', 'integer', 'min:1'],
            'packs' => ['required', 'integer', 'min:1'],
            'vat_no' => ['nullable', 'string', 'max:50', 'regex:/^[A-Z]{2}[0-9A-Z]{2,13}$/'], // Changed to nullable
        ];
    }

    public function messages(): array
    {
        return [
            'units.min' => 'Units must be at least 1',
            'packs.min' => 'Packs must be at least 1',
            'vat_no.regex' => 'VAT number must start with 2-letter country code followed by 2-13 alphanumeric characters',
        ];
    }
}
