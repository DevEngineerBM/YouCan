<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $categoryId = $request->query('category_id');
        Log::info("Index method called with category ID: " . $categoryId);

        try {
            $products = $this->productService->all($categoryId);

            return response()->json($products);
        } catch (\Throwable $e) {
            Log::error("Error in ProductController index method: " . $e->getMessage());

            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    public function store(Request $request)
    {
        Log::info('Store method called with data:', $request->all());

        try {
            $product = $this->productService->create($request->all());

            if ($request->hasFile('image')) {
                // fix public thing later
                $filePath = $request->file('image')->store('public/images');
                $product->update(['image' => $filePath]);
            } else {
                Log::info('No image file found in the request.');
            }

            if ($request->has('category_ids')) {
                $product->categories()->sync($request->input('category_ids'));
            }

            return response()->json($product, 201);
        } catch (\throwable $e) {
            Log::error('Error occurred while storing product:', ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    public function show($id)
    {
        try {
            $product = $this->productService->find($id);

            return response()->json($product);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Not Found'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $product = $this->productService->find($id);

        if ($request->hasFile('image')) {
            if ($product->image) {
                // to fix later (security issue)
                Storage::disk('public')->delete($product->image);
            }
            $request->file('image')->store('public/images');
        }

        $product = $this->productService->update($product, $request->all());

        if ($request->has('category_ids')) {
            $product->categories()->sync($request->input('category_ids'));
        }

        return response()->json($product);
    }

    public function destroy($id)
    {
        $product = $this->productService->find($id);
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $this->productService->delete($product);

        return response()->json(null, 204);
    }
}
