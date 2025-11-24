<?php

declare(strict_types=1);

namespace Applets\Merchandising\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Buyer extends Model
{
    protected $fillable = [
        'name',
    ];

    public function salesContracts(): HasMany
    {
        return $this->hasMany(SalesContract::class);
    }
}
