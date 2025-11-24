<?php

declare(strict_types=1);

namespace Applets\Merchandising\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContractTerm extends Model
{
    protected $fillable = [
        'sales_contract_id',
        'term_text',
        'term_order',
    ];

    protected $casts = [
        'term_order' => 'integer',
    ];

    public function salesContract(): BelongsTo
    {
        return $this->belongsTo(SalesContract::class);
    }
}
