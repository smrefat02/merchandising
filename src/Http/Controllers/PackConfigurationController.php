<?php

declare(strict_types=1);

namespace Applets\Merchandising\Http\Controllers;

use Applets\Merchandising\Http\Requests\PackConfigurationRequest;
use Applets\Merchandising\Http\Resources\PackConfigurationResource;
use Applets\Merchandising\Models\PackConfiguration;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

/**
 * @group Merchandising - Pack Configurations
 *
 * APIs for managing pack configurations
 */
class PackConfigurationController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $packConfigurations = PackConfiguration::with('style.purchaseOrder.salesContract')->paginate(20);

            return response()->json([
                'success' => true,
                'message' => __('Pack configurations retrieved successfully'),
                'data' => PackConfigurationResource::collection($packConfigurations)->response()->getData(),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to retrieve pack configurations'),
                'data' => null,
            ], 500);
        }
    }

    public function store(PackConfigurationRequest $request): JsonResponse
    {
        try {
            $packConfiguration = PackConfiguration::create($request->validated());
            $packConfiguration->load('style.purchaseOrder.salesContract');

            return response()->json([
                'success' => true,
                'message' => __('Pack configuration created successfully'),
                'data' => new PackConfigurationResource($packConfiguration),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to create pack configuration'),
                'data' => null,
            ], 500);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $packConfiguration = PackConfiguration::with('style.purchaseOrder.salesContract')->findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => __('Pack configuration retrieved successfully'),
                'data' => new PackConfigurationResource($packConfiguration),
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => __('Pack configuration not found'),
                'data' => null,
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to retrieve pack configuration'),
                'data' => null,
            ], 500);
        }
    }

    public function update(PackConfigurationRequest $request, int $id): JsonResponse
    {
        try {
            $packConfiguration = PackConfiguration::findOrFail($id);
            $packConfiguration->update($request->validated());
            $packConfiguration->load('style.purchaseOrder.salesContract');

            return response()->json([
                'success' => true,
                'message' => __('Pack configuration updated successfully'),
                'data' => new PackConfigurationResource($packConfiguration),
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => __('Pack configuration not found'),
                'data' => null,
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to update pack configuration'),
                'data' => null,
            ], 500);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $packConfiguration = PackConfiguration::findOrFail($id);
            $packConfiguration->delete();

            return response()->json([
                'success' => true,
                'message' => __('Pack configuration deleted successfully'),
                'data' => null,
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => __('Pack configuration not found'),
                'data' => null,
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to delete pack configuration'),
                'data' => null,
            ], 500);
        }
    }
}
