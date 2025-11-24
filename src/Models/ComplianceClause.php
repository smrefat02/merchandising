<?php

declare(strict_types=1);

namespace Applets\Merchandising\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ComplianceClause extends Model
{
    protected $fillable = [
        'sales_contract_id',
        'clause_code',
        'description',
        'penalty_usd',
    ];

    protected $casts = [
        'penalty_usd' => 'decimal:2',
    ];

    public function salesContract(): BelongsTo
    {
        return $this->belongsTo(SalesContract::class);
    }
}
