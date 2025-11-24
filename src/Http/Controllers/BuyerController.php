<?php

declare(strict_types=1);

namespace Applets\Merchandising\Http\Controllers;

use Applets\Merchandising\Http\Requests\BuyerRequest;
use Applets\Merchandising\Http\Resources\BuyerResource;
use Applets\Merchandising\Models\Buyer;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class BuyerController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $buyers = Buyer::paginate(20);

            return response()->json([
                'success' => true,
                'message' => __('Buyers retrieved successfully'),
                'data' => BuyerResource::collection($buyers)->response()->getData(),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to retrieve buyers'),
                'data' => null,
            ], 500);
        }
    }

    public function store(BuyerRequest $request): JsonResponse
    {
        try {
            $buyer = Buyer::create($request->validated());

            return response()->json([
                'success' => true,
                'message' => __('Buyer created successfully'),
                'data' => new BuyerResource($buyer),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to create buyer'),
                'data' => null,
            ], 500);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $buyer = Buyer::findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => __('Buyer retrieved successfully'),
                'data' => new BuyerResource($buyer),
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => __('Buyer not found'),
                'data' => null,
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to retrieve buyer'),
                'data' => null,
            ], 500);
        }
    }

    public function update(BuyerRequest $request, int $id): JsonResponse
    {
        try {
            $buyer = Buyer::findOrFail($id);
            $buyer->update($request->validated());

            return response()->json([
                'success' => true,
                'message' => __('Buyer updated successfully'),
                'data' => new BuyerResource($buyer),
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => __('Buyer not found'),
                'data' => null,
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to update buyer'),
                'data' => null,
            ], 500);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $buyer = Buyer::findOrFail($id);
            $buyer->delete();

            return response()->json([
                'success' => true,
                'message' => __('Buyer deleted successfully'),
                'data' => null,
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => __('Buyer not found'),
                'data' => null,
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to delete buyer'),
                'data' => null,
            ], 500);
        }
    }
}
