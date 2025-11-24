<?php

declare(strict_types=1);

namespace Applets\Merchandising\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PackConfigurationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'sales_contract_id' => $this->sales_contract_id,
            'sales_contract' => new SalesContractResource($this->whenLoaded('salesContract')),
            'pack_id' => $this->pack_id,
            'gtin' => $this->gtin,
            'pack_type' => $this->pack_type,
            'color' => $this->color,
            'ratio' => $this->ratio,
            'total_units' => $this->total_units,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
