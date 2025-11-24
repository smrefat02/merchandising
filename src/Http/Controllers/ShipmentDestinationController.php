<?php

declare(strict_types=1);

namespace Applets\Merchandising\Http\Controllers;

use Applets\Merchandising\Http\Requests\ShipmentDestinationRequest;
use Applets\Merchandising\Http\Resources\ShipmentDestinationResource;
use Applets\Merchandising\Models\ShipmentDestination;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

/**
 * @group Merchandising - Shipment Destinations
 *
 * APIs for managing shipment destinations
 */
class ShipmentDestinationController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $destinations = ShipmentDestination::with('salesContract')->paginate(20);

            return response()->json([
                'success' => true,
                'message' => __('Shipment destinations retrieved successfully'),
                'data' => ShipmentDestinationResource::collection($destinations)->response()->getData(),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to retrieve shipment destinations'),
                'data' => null,
            ], 500);
        }
    }

    public function store(ShipmentDestinationRequest $request): JsonResponse
    {
        try {
            $destination = ShipmentDestination::create($request->validated());
            $destination->load('salesContract');

            return response()->json([
                'success' => true,
                'message' => __('Shipment destination created successfully'),
                'data' => new ShipmentDestinationResource($destination),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to create shipment destination'),
                'data' => null,
            ], 500);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $destination = ShipmentDestination::with('salesContract')->findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => __('Shipment destination retrieved successfully'),
                'data' => new ShipmentDestinationResource($destination),
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => __('Shipment destination not found'),
                'data' => null,
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to retrieve shipment destination'),
                'data' => null,
            ], 500);
        }
    }

    public function update(ShipmentDestinationRequest $request, int $id): JsonResponse
    {
        try {
            $destination = ShipmentDestination::findOrFail($id);
            $destination->update($request->validated());
            $destination->load('salesContract');

            return response()->json([
                'success' => true,
                'message' => __('Shipment destination updated successfully'),
                'data' => new ShipmentDestinationResource($destination),
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => __('Shipment destination not found'),
                'data' => null,
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to update shipment destination'),
                'data' => null,
            ], 500);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $destination = ShipmentDestination::findOrFail($id);
            $destination->delete();

            return response()->json([
                'success' => true,
                'message' => __('Shipment destination deleted successfully'),
                'data' => null,
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => __('Shipment destination not found'),
                'data' => null,
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to delete shipment destination'),
                'data' => null,
            ], 500);
        }
    }
}
