<?php

declare(strict_types=1);

namespace Applets\Merchandising\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContractTermRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sales_contract_id' => ['required', 'integer', 'exists:sales_contracts,id'],
            'term_text' => ['required', 'string', 'min:10'],
            'term_order' => ['nullable', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'term_text.min' => 'Term text must be at least 10 characters',
            'term_order.min' => 'Term order must be at least 1',
        ];
    }
}
