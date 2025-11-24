<?php

declare(strict_types=1);

namespace Applets\Merchandising\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ComplianceClauseResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'sales_contract_id' => $this->sales_contract_id,
            'clause_code' => $this->clause_code,
            'description' => $this->description,
            'penalty_usd' => $this->penalty_usd,
            'penalty_formatted' => '$' . number_format($this->penalty_usd, 2) . ' USD',
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'sales_contract' => new SalesContractResource($this->whenLoaded('salesContract')),
        ];
    }
}
