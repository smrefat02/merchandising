<?php

declare(strict_types=1);

namespace Applets\Merchandising\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PackConfiguration extends Model
{
    protected $fillable = [
        'sales_contract_id',
        'pack_id',
        'gtin',
        'pack_type',
        'color',
        'ratio',
        'total_units',
    ];

    protected $casts = [
        'total_units' => 'integer',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($pack) {
            $pack->total_units = $pack->calculateTotalUnits();
        });

        static::updating(function ($pack) {
            $pack->total_units = $pack->calculateTotalUnits();
        });
    }

    public function calculateTotalUnits(): int
    {
        if (empty($this->ratio)) {
            return 0;
        }

        $pairs = explode(',', $this->ratio);
        $total = 0;

        foreach ($pairs as $pair) {
            $parts = explode(':', trim($pair));
            if (count($parts) === 2 && is_numeric($parts[1])) {
                $total += (int) $parts[1];
            }
        }

        return $total;
    }

    public function salesContract(): BelongsTo
    {
        return $this->belongsTo(SalesContract::class);
    }
}
