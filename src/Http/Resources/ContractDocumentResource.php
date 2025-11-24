<?php

declare(strict_types=1);

namespace Applets\Merchandising\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContractDocumentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'sales_contract_id' => $this->sales_contract_id,
            'document_name' => $this->document_name,
            'is_required' => $this->is_required,
            'deadline_days' => $this->deadline_days,
            'file_path' => $this->file_path,
            'file_name' => $this->file_name,
            'uploaded_at' => $this->uploaded_at?->format('Y-m-d H:i:s'),
            'is_uploaded' => !empty($this->file_path),
            'file_url' => $this->file_path ? route('contract-documents.download', $this->id) : null,
            'formatted_deadline' => $this->deadline_days ? "{$this->deadline_days} days after shipment" : null,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'sales_contract' => new SalesContractResource($this->whenLoaded('salesContract')),
        ];
    }
}
