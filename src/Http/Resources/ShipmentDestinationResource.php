<?php

declare(strict_types=1);

namespace Applets\Merchandising\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShipmentDestinationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'sales_contract_id' => $this->sales_contract_id,
            'sales_contract' => new SalesContractResource($this->whenLoaded('salesContract')),
            'destination_code' => $this->destination_code,
            'country' => $this->country,
            'port' => $this->port,
            'final_destination' => $this->final_destination,
            'units' => $this->units,
            'packs' => $this->packs,
            'vat_no' => $this->vat_no,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
