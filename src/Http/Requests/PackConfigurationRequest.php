<?php

declare(strict_types=1);

namespace Applets\Merchandising\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PackConfigurationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sales_contract_id' => ['required', 'integer', 'exists:sales_contracts,id'],
            'pack_id' => ['required', 'string', 'max:50'],
            'gtin' => ['nullable', 'string', 'max:20', 'regex:/^[0-9]{8,14}$/'],
            'pack_type' => ['required', 'string', 'max:100'],
            'color' => ['required', 'string', 'max:50'],
            'ratio' => ['required', 'string', 'max:255', 'regex:/^[A-Z0-9]+:[0-9]+(,\s*[A-Z0-9]+:[0-9]+)*$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'ratio.regex' => 'Ratio must be in format: SIZE:QTY, SIZE:QTY (e.g., XS:2, S:3, M:4)',
            'gtin.regex' => 'GTIN must contain 8-14 digits only',
        ];
    }
}
