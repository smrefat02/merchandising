<?php

declare(strict_types=1);

namespace Applets\Merchandising\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContractDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sales_contract_id' => ['required', 'integer', 'exists:sales_contracts,id'],
            'document_name' => ['required', 'string', 'max:255'],
            'is_required' => ['required', 'boolean'],
            'deadline_days' => ['nullable', 'integer', 'min:1', 'max:365'],
            'file' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png', 'max:10240'],
        ];
    }

    public function messages(): array
    {
        return [
            'deadline_days.min' => 'Deadline must be at least 1 day',
            'deadline_days.max' => 'Deadline cannot exceed 365 days',
            'file.mimes' => 'File must be PDF, DOC, DOCX, XLS, XLSX, JPG, or PNG',
            'file.max' => 'File size cannot exceed 10MB',
        ];
    }
}
