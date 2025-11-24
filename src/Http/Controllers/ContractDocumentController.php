<?php

declare(strict_types=1);

namespace Applets\Merchandising\Http\Controllers;

use Applets\Merchandising\Http\Requests\ContractDocumentRequest;
use Applets\Merchandising\Http\Resources\ContractDocumentResource;
use Applets\Merchandising\Models\ContractDocument;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * @group Merchandising - Contract Documents
 *
 * APIs for managing contract documents
 */
class ContractDocumentController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $documents = ContractDocument::with('salesContract')->paginate(20);

            return response()->json([
                'success' => true,
                'message' => __('Contract documents retrieved successfully'),
                'data' => ContractDocumentResource::collection($documents)->response()->getData(),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to retrieve contract documents'),
                'data' => null,
            ], 500);
        }
    }

    public function store(ContractDocumentRequest $request): JsonResponse
    {
        try {
            $document = ContractDocument::create($request->validated());
            $document->load('salesContract');

            return response()->json([
                'success' => true,
                'message' => __('Contract document created successfully'),
                'data' => new ContractDocumentResource($document),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to create contract document'),
                'data' => null,
            ], 500);
        }
    }

    public function upload(Request $request, int $id): JsonResponse
    {
        try {
            $document = ContractDocument::findOrFail($id);

            $request->validate([
                'file' => ['required', 'file', 'mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png', 'max:10240'],
            ]);

            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $fileName = str_replace(' ', '_', $document->document_name) . '_' . time() . '.' . $extension;
            $directory = 'contract_documents/' . $document->sales_contract_id;
            $filePath = $file->storeAs($directory, $fileName, 'local');

            if ($document->file_path) {
                Storage::disk('local')->delete($document->file_path);
            }

            $document->update([
                'file_path' => $filePath,
                'file_name' => $file->getClientOriginalName(),
                'uploaded_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => __('File uploaded successfully'),
                'data' => new ContractDocumentResource($document->fresh('salesContract')),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to upload file'),
                'data' => null,
            ], 500);
        }
    }

    public function download(int $id): BinaryFileResponse|JsonResponse
    {
        try {
            $document = ContractDocument::findOrFail($id);

            if (!$document->file_path || !Storage::disk('local')->exists($document->file_path)) {
                return response()->json([
                    'success' => false,
                    'message' => __('File not found'),
                    'data' => null,
                ], 404);
            }

            return response()->download(
                Storage::disk('local')->path($document->file_path),
                $document->file_name
            );
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to download file'),
                'data' => null,
            ], 500);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $document = ContractDocument::with('salesContract')->findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => __('Contract document retrieved successfully'),
                'data' => new ContractDocumentResource($document),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Contract document not found'),
                'data' => null,
            ], 404);
        }
    }

    public function update(ContractDocumentRequest $request, int $id): JsonResponse
    {
        try {
            $document = ContractDocument::findOrFail($id);
            $document->update($request->validated());
            $document->load('salesContract');

            return response()->json([
                'success' => true,
                'message' => __('Contract document updated successfully'),
                'data' => new ContractDocumentResource($document),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to update contract document'),
                'data' => null,
            ], 500);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $document = ContractDocument::findOrFail($id);

            if ($document->file_path) {
                Storage::disk('local')->delete($document->file_path);
            }

            $document->delete();

            return response()->json([
                'success' => true,
                'message' => __('Contract document deleted successfully'),
                'data' => null,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('Failed to delete contract document'),
                'data' => null,
            ], 500);
        }
    }
}
