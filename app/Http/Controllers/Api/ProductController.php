<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('variations');

        // Filtering
        $query = Product::with('variations')
                ->when($request->filled('type'), fn($q) => $q->where('type', $request->type))
                ->when($request->filled('name'), function ($q) use ($request) {
                    $q->where(function ($q2) use ($request) {
                        $q2->where('name->en', 'like', '%' . $request->name . '%')
                            ->orWhere('name->ar', 'like', '%' . $request->name . '%');
                    });
                })
                ->when($request->filled('min_price'), fn($q) => $q->where('price', '>=', $request->min_price))
                ->when($request->filled('max_price'), fn($q) => $q->where('price', '<=', $request->max_price));


        return ProductResource::collection($query->paginate(10));
    }

    public function show(Product $product)
    {
        $product->load('variations');
        return new ProductResource($product);
    }

    public function store(ProductRequest $request)
    {
        try {
            $product = DB::transaction(function () use ($request) {
                $validated = $request->validated();

                $product = Product::create($validated);

                if ($product->type === 'variable') {
                    $product->variations()->createMany($request->input('variations', []));
                }

                return $product;
            });

            return (new ProductResource($product->load('variations')))
                    ->response()
                    ->setStatusCode(201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Throwable $e) {
            Log::error('Create Product Error: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }


    public function update(ProductRequest $request, Product $product)
    {
        try {
            return DB::transaction(function () use ($request, $product) {
                $product->update($request->validated());

                $product->variations()->delete();

                if ($product->type === 'variable') {
                    $product->variations()->createMany($request->input('variations', []));
                }

                return (new ProductResource($product->load('variations')))
                        ->response()
                        ->setStatusCode(200);
            });
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Throwable $e) {
            Log::error('Update Product Error: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return response()->json(['error' => 'Product not found'], 404);
            }

            $product->delete();

            return response()->json(['message' => 'Product deleted successfully'], 200);
        } catch (\Throwable $e) {
            Log::error('Delete Product Error: ' . $e->getMessage());
            return response()->json(['error' => 'Delete failed'], 500);
        }
    }

}
