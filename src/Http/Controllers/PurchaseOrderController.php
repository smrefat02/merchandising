<?php

declare(strict_types=1);

namespace Applets\Merchandising\Http\Controllers;

use Applets\Merchandising\Http\Requests\PurchaseOrderRequest;
use Applets\Merchandising\Http\Resources\PurchaseOrderResource;
use Applets\Merchandising\Models\PurchaseOrder;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

/**
 * @group Merchandising - Purchase Orders
 *
 * APIs for managing purchase orders
 */
class PurchaseOrderController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $purchaseOrders = PurchaseOrder::with(['salesContract.buyer', 'salesContract.merchandiser'])->paginate(20);

            return response()->json([
                'success' => true,
                'message' => __('Purchase orders retrieved successfully'),
                'data' => PurchaseOrderResource::collection($purchaseOrders)->response()->getData(),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to retrieve purchase orders'),
                'data' => null,
            ], 500);
        }
    }

    public function store(PurchaseOrderRequest $request): JsonResponse
    {
        try {
            $purchaseOrder = PurchaseOrder::create($request->validated());
            $purchaseOrder->load(['salesContract.buyer', 'salesContract.merchandiser']);

            return response()->json([
                'success' => true,
                'message' => __('Purchase order created successfully'),
                'data' => new PurchaseOrderResource($purchaseOrder),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to create purchase order'),
                'data' => null,
            ], 500);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $purchaseOrder = PurchaseOrder::with(['salesContract.buyer', 'salesContract.merchandiser'])->findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => __('Purchase order retrieved successfully'),
                'data' => new PurchaseOrderResource($purchaseOrder),
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => __('Purchase order not found'),
                'data' => null,
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to retrieve purchase order'),
                'data' => null,
            ], 500);
        }
    }

    public function update(PurchaseOrderRequest $request, int $id): JsonResponse
    {
        try {
            $purchaseOrder = PurchaseOrder::findOrFail($id);
            $purchaseOrder->update($request->validated());
            $purchaseOrder->load(['salesContract.buyer', 'salesContract.merchandiser']);

            return response()->json([
                'success' => true,
                'message' => __('Purchase order updated successfully'),
                'data' => new PurchaseOrderResource($purchaseOrder),
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => __('Purchase order not found'),
                'data' => null,
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to update purchase order'),
                'data' => null,
            ], 500);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $purchaseOrder = PurchaseOrder::findOrFail($id);
            $purchaseOrder->delete();

            return response()->json([
                'success' => true,
                'message' => __('Purchase order deleted successfully'),
                'data' => null,
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => __('Purchase order not found'),
                'data' => null,
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to delete purchase order'),
                'data' => null,
            ], 500);
        }
    }
}
