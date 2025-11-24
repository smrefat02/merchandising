<?php

declare(strict_types=1);

namespace Applets\Merchandising\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StyleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'purchase_order_id' => $this->purchase_order_id,
            'purchase_order' => new PurchaseOrderResource($this->whenLoaded('purchaseOrder')),
            'style_no' => $this->style_no,
            'style_name' => $this->style_name,
            'qty' => $this->qty,
            'unit_price' => number_format((float) $this->unit_price, 2, '.', ''),
            'total_value' => number_format((float) $this->total_value, 2, '.', ''),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
