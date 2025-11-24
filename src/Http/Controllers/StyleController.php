<?php

declare(strict_types=1);

namespace Applets\Merchandising\Http\Controllers;

use Applets\Merchandising\Http\Requests\StyleRequest;
use Applets\Merchandising\Http\Resources\StyleResource;
use Applets\Merchandising\Models\Style;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

/**
 * @group Merchandising - Styles
 *
 * APIs for managing styles
 */
class StyleController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $styles = Style::with('purchaseOrder.salesContract')->paginate(20);

            return response()->json([
                'success' => true,
                'message' => __('Styles retrieved successfully'),
                'data' => StyleResource::collection($styles)->response()->getData(),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to retrieve styles'),
                'data' => null,
            ], 500);
        }
    }

    public function store(StyleRequest $request): JsonResponse
    {
        try {
            $style = Style::create($request->validated());
            $style->load('purchaseOrder.salesContract');

            return response()->json([
                'success' => true,
                'message' => __('Style created successfully'),
                'data' => new StyleResource($style),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to create style'),
                'data' => null,
            ], 500);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $style = Style::with('purchaseOrder.salesContract')->findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => __('Style retrieved successfully'),
                'data' => new StyleResource($style),
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => __('Style not found'),
                'data' => null,
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to retrieve style'),
                'data' => null,
            ], 500);
        }
    }

    public function update(StyleRequest $request, int $id): JsonResponse
    {
        try {
            $style = Style::findOrFail($id);
            $style->update($request->validated());
            $style->load('purchaseOrder.salesContract');

            return response()->json([
                'success' => true,
                'message' => __('Style updated successfully'),
                'data' => new StyleResource($style),
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => __('Style not found'),
                'data' => null,
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to update style'),
                'data' => null,
            ], 500);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $style = Style::findOrFail($id);
            $style->delete();

            return response()->json([
                'success' => true,
                'message' => __('Style deleted successfully'),
                'data' => null,
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => __('Style not found'),
                'data' => null,
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to delete style'),
                'data' => null,
            ], 500);
        }
    }
}
