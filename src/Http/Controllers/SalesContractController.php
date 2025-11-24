<?php

declare(strict_types=1);

namespace Applets\Merchandising\Http\Controllers;

use Applets\Merchandising\Http\Requests\SalesContractRequest;
use Applets\Merchandising\Http\Resources\SalesContractResource;
use Applets\Merchandising\Models\SalesContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class SalesContractController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $contracts = SalesContract::with(['buyer', 'merchandiser'])->paginate(20);

            return response()->json([
                'success' => true,
                'message' => __('Sales contracts retrieved successfully'),
                'data' => SalesContractResource::collection($contracts)->response()->getData(),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to retrieve sales contracts'),
                'data' => null,
            ], 500);
        }
    }

    public function store(SalesContractRequest $request): JsonResponse
    {
        try {
            $contract = SalesContract::create($request->validated());
            $contract->load(['buyer', 'merchandiser']);

            return response()->json([
                'success' => true,
                'message' => __('Sales contract created successfully'),
                'data' => new SalesContractResource($contract),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to create sales contract'),
                'data' => null,
            ], 500);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $contract = SalesContract::with(['buyer', 'merchandiser'])->findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => __('Sales contract retrieved successfully'),
                'data' => new SalesContractResource($contract),
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => __('Sales contract not found'),
                'data' => null,
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to retrieve sales contract'),
                'data' => null,
            ], 500);
        }
    }

    public function update(SalesContractRequest $request, int $id): JsonResponse
    {
        try {
            $contract = SalesContract::findOrFail($id);
            $contract->update($request->validated());
            $contract->load(['buyer', 'merchandiser']);

            return response()->json([
                'success' => true,
                'message' => __('Sales contract updated successfully'),
                'data' => new SalesContractResource($contract),
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => __('Sales contract not found'),
                'data' => null,
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to update sales contract'),
                'data' => null,
            ], 500);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $contract = SalesContract::findOrFail($id);
            $contract->delete();

            return response()->json([
                'success' => true,
                'message' => __('Sales contract deleted successfully'),
                'data' => null,
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => __('Sales contract not found'),
                'data' => null,
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to delete sales contract'),
                'data' => null,
            ], 500);
        }
    }
}
