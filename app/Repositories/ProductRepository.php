<?php

namespace App\Repositories;

use App\Models\Product;
use App\Services\ProductValidator;
use Illuminate\Support\Facades\Log;

class ProductRepository
{
    public function all($categoryId = null)
    {
        try {
            if ($categoryId) {
                Log::info("Filtering products by category ID: $categoryId");
                return Product::whereHas('categories', function ($q) use ($categoryId) {
                    $q->where('categories.id', $categoryId); // Specify the table name for the id column
                })->with('categories')->get();
            } else {
                Log::info("Fetching all products");
                return Product::with('categories')->get();
            }
        } catch (\Exception $e) {
            Log::error("Error fetching products: " . $e->getMessage());
            throw $e;
        }
    }

    public function find($id)
    {
        return Product::with('categories')->findOrFail($id);
    }

    public function create(array $data)
    {
        $validatedData = ProductValidator::validateProductData($data);
        return Product::create($validatedData);
    }

    public function update(Product $product, array $data)
    {
        $validatedData = ProductValidator::validateProductData($data);
        $product->update($validatedData);
        return $product;
    }

    public function delete(Product $product)
    {
        $product->delete();
    }
}
