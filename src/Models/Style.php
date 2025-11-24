<?php

declare(strict_types=1);

namespace Applets\Merchandising\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Style extends Model
{
    protected $fillable = [
        'purchase_order_id',
        'style_no',
        'style_name',
        'qty',
        'unit_price',
        'total_value',
    ];

    protected $casts = [
        'qty' => 'integer',
        'unit_price' => 'decimal:2',
        'total_value' => 'decimal:2',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($style) {
            $style->total_value = $style->qty * $style->unit_price;
        });

        static::updating(function ($style) {
            $style->total_value = $style->qty * $style->unit_price;
        });
    }

    public function purchaseOrder(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrder::class);
    }
}
