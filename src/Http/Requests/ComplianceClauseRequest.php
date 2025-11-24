<?php

declare(strict_types=1);

namespace Applets\Merchandising\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ComplianceClauseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $salesContractId = $this->input('sales_contract_id');
        $clauseId = $this->route('compliance_clause');

        return [
            'sales_contract_id' => ['required', 'integer', 'exists:sales_contracts,id'],
            'clause_code' => [
                'required',
                'string',
                'max:10',
                Rule::unique('compliance_clauses')->where(function ($query) use ($salesContractId) {
                    return $query->where('sales_contract_id', $salesContractId);
                })->ignore($clauseId),
            ],
            'description' => ['required', 'string', 'max:500'],
            'penalty_usd' => ['required', 'numeric', 'min:0', 'max:999999.99'],
        ];
    }

    public function messages(): array
    {
        return [
            'clause_code.unique' => 'Clause code must be unique for this sales contract',
            'penalty_usd.max' => 'Penalty cannot exceed $999,999.99',
        ];
    }
}
