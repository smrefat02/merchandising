<?php

declare(strict_types=1);

namespace Applets\Merchandising\Http\Controllers;

use Applets\Merchandising\Http\Requests\ComplianceClauseRequest;
use Applets\Merchandising\Http\Resources\ComplianceClauseResource;
use Applets\Merchandising\Models\ComplianceClause;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

/**
 * @group Merchandising - Compliance Clauses
 *
 * APIs for managing compliance clauses
 */
class ComplianceClauseController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $clauses = ComplianceClause::with('salesContract')->paginate(20);

            return response()->json([
                'success' => true,
                'message' => __('Compliance clauses retrieved successfully'),
                'data' => ComplianceClauseResource::collection($clauses)->response()->getData(),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to retrieve compliance clauses'),
                'data' => null,
            ], 500);
        }
    }

    public function store(ComplianceClauseRequest $request): JsonResponse
    {
        try {
            $clause = ComplianceClause::create($request->validated());
            $clause->load('salesContract');

            return response()->json([
                'success' => true,
                'message' => __('Compliance clause created successfully'),
                'data' => new ComplianceClauseResource($clause),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to create compliance clause'),
                'data' => null,
            ], 500);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $clause = ComplianceClause::with('salesContract')->findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => __('Compliance clause retrieved successfully'),
                'data' => new ComplianceClauseResource($clause),
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => __('Compliance clause not found'),
                'data' => null,
            ], 404);
        }
    }

    public function update(ComplianceClauseRequest $request, int $id): JsonResponse
    {
        try {
            $clause = ComplianceClause::findOrFail($id);
            $clause->update($request->validated());
            $clause->load('salesContract');

            return response()->json([
                'success' => true,
                'message' => __('Compliance clause updated successfully'),
                'data' => new ComplianceClauseResource($clause),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to update compliance clause'),
                'data' => null,
            ], 500);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $clause = ComplianceClause::findOrFail($id);
            $clause->delete();

            return response()->json([
                'success' => true,
                'message' => __('Compliance clause deleted successfully'),
                'data' => null,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to delete compliance clause'),
                'data' => null,
            ], 500);
        }
    }

    public function totalPenalties(int $sales_contract_id): JsonResponse
    {
        try {
            $total = ComplianceClause::where('sales_contract_id', $sales_contract_id)
                ->sum('penalty_usd');

            return response()->json([
                'success' => true,
                'message' => __('Total penalties calculated successfully'),
                'data' => [
                    'sales_contract_id' => $sales_contract_id,
                    'total_penalties_usd' => number_format($total, 2),
                    'formatted' => '$' . number_format($total, 2) . ' USD',
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to calculate total penalties'),
                'data' => null,
            ], 500);
        }
    }
}
