<?php

namespace App\Http\Controllers;

use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{

    // injection of ProductREpository dependencies class
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /* ============================================== */

    public function index(Request $request)
    {
        $categoryId = $request->query('category_id');
        Log::info("Index method called with category ID: " . $categoryId);

        try {
            $products = $this->productRepository->all($categoryId);
            return response()->json($products);
        } catch (\Exception $e) {
            Log::error("Error in ProductController index method: " . $e->getMessage());
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    /* ============================================== */

    public function store(Request $request)
    {
        Log::info('Store method called with data:', $request->all());

        try {
            $product = $this->productRepository->create($request->all());

            if ($request->hasFile('image')) {
                Log::info('Image file found in the request.');
                $filePath = $request->file('image')->store('public/images');
                $product->update(['image' => $filePath]);
            } else {
                Log::info('No image file found in the request.');
            }

            if ($request->has('category_ids')) {
                $product->categories()->sync($request->input('category_ids'));
            }

            return response()->json($product, 201);
        } catch (\Exception $e) {
            Log::error('Error occurred while storing product:', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /* ============================================== */

    public function show($id)
    {
        $product = $this->productRepository->find($id);
        return response()->json($product);
    }

    /* ============================================== */

    public function update(Request $request, $id)
    {
        $product = $this->productRepository->find($id);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $filePath = $request->file('image')->store('public/images');
            $product->update(['image' => $filePath]);
        }

        $product = $this->productRepository->update($product, $request->all());

        if ($request->has('category_ids')) {
            $product->categories()->sync($request->input('category_ids'));
        }

        return response()->json($product);
    }

    /* ============================================== */

    public function destroy($id)
    {
        $product = $this->productRepository->find($id);
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $this->productRepository->delete($product);
        return response()->json(null, 204);
    }
}
