<?php

declare(strict_types=1);

namespace Applets\Merchandising\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SalesContract extends Model
{
    protected $fillable = [
        'buyer_id',
        'contract_no',
        'season',
        'revision',
        'issue_date',
        'merchandiser_id',
        'shipment_terms',
        'payment_terms',
        'shipment_date',
        'expiry_date',
        'mode_of_shipment',
        'allow_partial_shipment',
        'allow_transshipment',
        'bank_details',
        'remarks',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'shipment_date' => 'date',
        'expiry_date' => 'date',
        'allow_partial_shipment' => 'boolean',
        'allow_transshipment' => 'boolean',
    ];

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(Buyer::class);
    }

    public function merchandiser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'merchandiser_id');
    }

    public function purchaseOrders(): HasMany
    {
        return $this->hasMany(PurchaseOrder::class);
    }

    public function packConfigurations(): HasMany
    {
        return $this->hasMany(PackConfiguration::class);
    }

    public function shipmentDestinations(): HasMany
    {
        return $this->hasMany(ShipmentDestination::class);
    }

    public function contractDocuments(): HasMany
    {
        return $this->hasMany(ContractDocument::class);
    }

    public function complianceClauses(): HasMany
    {
        return $this->hasMany(ComplianceClause::class);
    }

    public function contractTerms(): HasMany
    {
        return $this->hasMany(ContractTerm::class);
    }
}
