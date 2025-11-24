<?php

declare(strict_types=1);

namespace Applets\Merchandising\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseOrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'sales_contract_id' => $this->sales_contract_id,
            'sales_contract' => new SalesContractResource($this->whenLoaded('salesContract')),
            'po_no' => $this->po_no,
            'buyer_ref' => $this->buyer_ref,
            'dept' => $this->dept,
            'class' => $this->class,
            'subclass' => $this->subclass,
            'season' => $this->season,
            'handover_date' => $this->handover_date?->format('Y-m-d'),
            'delivery_date' => $this->delivery_date?->format('Y-m-d'),
            'total_qty' => $this->total_qty,
            'value_usd' => number_format((float) $this->value_usd, 2, '.', ''),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
