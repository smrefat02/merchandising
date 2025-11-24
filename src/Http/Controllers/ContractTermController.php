<?php

declare(strict_types=1);

namespace Applets\Merchandising\Http\Controllers;

use Applets\Merchandising\Http\Requests\ContractTermRequest;
use Applets\Merchandising\Http\Resources\ContractTermResource;
use Applets\Merchandising\Models\ContractTerm;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

/**
 * @group Merchandising - Contract Terms
 *
 * APIs for managing contract terms
 */
class ContractTermController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $terms = ContractTerm::with('salesContract')
                ->orderBy('sales_contract_id')
                ->orderBy('term_order')
                ->paginate(20);

            return response()->json([
                'success' => true,
                'message' => __('Contract terms retrieved successfully'),
                'data' => ContractTermResource::collection($terms)->response()->getData(),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to retrieve contract terms'),
                'data' => null,
            ], 500);
        }
    }

    public function store(ContractTermRequest $request): JsonResponse
    {
        try {
            // Get the next term_order for this contract
            $maxOrder = ContractTerm::where('sales_contract_id', $request->sales_contract_id)
                ->max('term_order') ?? 0;

            $term = ContractTerm::create(array_merge(
                $request->validated(),
                ['term_order' => $maxOrder + 1]
            ));
            $term->load('salesContract');

            return response()->json([
                'success' => true,
                'message' => __('Contract term created successfully'),
                'data' => new ContractTermResource($term),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to create contract term'),
                'data' => null,
            ], 500);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $term = ContractTerm::with('salesContract')->findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => __('Contract term retrieved successfully'),
                'data' => new ContractTermResource($term),
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => __('Contract term not found'),
                'data' => null,
            ], 404);
        }
    }

    public function update(ContractTermRequest $request, int $id): JsonResponse
    {
        try {
            $term = ContractTerm::findOrFail($id);
            $term->update($request->validated());
            $term->load('salesContract');

            return response()->json([
                'success' => true,
                'message' => __('Contract term updated successfully'),
                'data' => new ContractTermResource($term),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to update contract term'),
                'data' => null,
            ], 500);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $term = ContractTerm::findOrFail($id);
            $term->delete();

            return response()->json([
                'success' => true,
                'message' => __('Contract term deleted successfully'),
                'data' => null,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to delete contract term'),
                'data' => null,
            ], 500);
        }
    }

    public function reorder(Request $request): JsonResponse
    {
        $request->validate([
            'terms' => 'required|array',
            'terms.*.id' => 'required|integer|exists:contract_terms,id',
            'terms.*.term_order' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            foreach ($request->terms as $termData) {
                ContractTerm::where('id', $termData['id'])
                    ->update(['term_order' => $termData['term_order']]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => __('Contract terms reordered successfully'),
                'data' => null,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => __('Failed to reorder contract terms'),
                'data' => null,
            ], 500);
        }
    }
}
