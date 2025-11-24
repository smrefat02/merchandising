<?php

declare(strict_types=1);

namespace Applets\Merchandising\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PurchaseOrder extends Model
{
    protected $fillable = [
        'sales_contract_id',
        'po_no',
        'buyer_ref',
        'dept',
        'class',
        'subclass',
        'season',
        'handover_date',
        'delivery_date',
        'total_qty',
        'value_usd',
    ];

    protected $casts = [
        'handover_date' => 'date',
        'delivery_date' => 'date',
        'total_qty' => 'integer',
        'value_usd' => 'decimal:2',
    ];

    public function salesContract(): BelongsTo
    {
        return $this->belongsTo(SalesContract::class);
    }

    public function styles(): HasMany
    {
        return $this->hasMany(Style::class);
    }
}
