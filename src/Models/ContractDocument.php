<?php

declare(strict_types=1);

namespace Applets\Merchandising\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContractDocument extends Model
{
    protected $fillable = [
        'sales_contract_id',
        'document_name',
        'is_required',
        'deadline_days',
        'file_path',
        'file_name',
        'uploaded_at',
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'deadline_days' => 'integer',
        'uploaded_at' => 'datetime',
    ];

    public function salesContract(): BelongsTo
    {
        return $this->belongsTo(SalesContract::class);
    }
}
