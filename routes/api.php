<?php

declare(strict_types=1);

use Applets\Merchandising\Http\Controllers\BuyerController;
use Applets\Merchandising\Http\Controllers\ComplianceClauseController;
use Applets\Merchandising\Http\Controllers\ContractDocumentController;
use Applets\Merchandising\Http\Controllers\ContractTermController;
use Applets\Merchandising\Http\Controllers\PackConfigurationController;
use Applets\Merchandising\Http\Controllers\PurchaseOrderController;
use Applets\Merchandising\Http\Controllers\SalesContractController;
use Applets\Merchandising\Http\Controllers\ShipmentDestinationController;
use Applets\Merchandising\Http\Controllers\StyleController;
use Illuminate\Support\Facades\Route;

Route::middleware(['api'])->prefix('api/merchandising')->group(function () {
    Route::apiResource('buyers', BuyerController::class);
    Route::apiResource('sales-contracts', SalesContractController::class);
    Route::apiResource('purchase-orders', PurchaseOrderController::class);
    Route::apiResource('styles', StyleController::class);
    Route::apiResource('pack-configurations', PackConfigurationController::class);
    Route::apiResource('shipment-destinations', ShipmentDestinationController::class);

    Route::apiResource('contract-documents', ContractDocumentController::class);
    Route::post('contract-documents/{id}/upload', [ContractDocumentController::class, 'upload']);
    Route::get('contract-documents/{id}/download', [ContractDocumentController::class, 'download'])->name('contract-documents.download');

    Route::apiResource('compliance-clauses', ComplianceClauseController::class);
    Route::get('compliance-clauses/contract/{sales_contract_id}/total-penalties', [ComplianceClauseController::class, 'totalPenalties']);

    Route::apiResource('contract-terms', ContractTermController::class);
    Route::post('contract-terms/reorder', [ContractTermController::class, 'reorder']);
});
