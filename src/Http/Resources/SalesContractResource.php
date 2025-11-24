<?php

declare(strict_types=1);

namespace Applets\Merchandising\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SalesContractResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'buyer_id' => $this->buyer_id,
            'buyer' => new BuyerResource($this->whenLoaded('buyer')),
            'contract_no' => $this->contract_no,
            'season' => $this->season,
            'revision' => $this->revision,
            'issue_date' => $this->issue_date?->format('Y-m-d'),
            'merchandiser_id' => $this->merchandiser_id,
            'merchandiser' => new UserResource($this->whenLoaded('merchandiser')),
            'shipment_terms' => $this->shipment_terms,
            'payment_terms' => $this->payment_terms,
            'shipment_date' => $this->shipment_date?->format('Y-m-d'),
            'expiry_date' => $this->expiry_date?->format('Y-m-d'),
            'mode_of_shipment' => $this->mode_of_shipment,
            'allow_partial_shipment' => $this->allow_partial_shipment,
            'allow_transshipment' => $this->allow_transshipment,
            'bank_details' => $this->bank_details,
            'remarks' => $this->remarks,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
