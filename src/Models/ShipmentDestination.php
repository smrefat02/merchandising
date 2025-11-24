<?php

declare(strict_types=1);

namespace Applets\Merchandising\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShipmentDestination extends Model
{
    protected $fillable = [
        'sales_contract_id',
        'destination_code',
        'country',
        'port',
        'final_destination',
        'units',
        'packs',
        'vat_no',
    ];

    protected $casts = [
        'units' => 'integer',
        'packs' => 'integer',
    ];

    public function salesContract(): BelongsTo
    {
        return $this->belongsTo(SalesContract::class);
    }
}
