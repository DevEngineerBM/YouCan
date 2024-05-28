<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class ProductRepository
{
    public function all($categoryId = null): Collection
    {
        try {

            if ($categoryId) {

                Log::info("Filtering products by category ID: $categoryId");

                return Product::whereHas('categories', function ($q) use ($categoryId) {

                    $q->where('categories.id', $categoryId);
                })->with('categories')->get();
            }

            Log::info("Fetching all products");

            return Product::with('categories')->get();
        } catch (\Throwable $e) {

            Log::error("Error fetching products: " . $e->getMessage());

            throw $e;
        }
    }

    public function find(int $id): Product
    {

        return Product::with('categories')->findOrFail($id);
    }

    public function create(array $data): Product
    {

        return Product::create($data);
    }

    public function update(Product $product, array $data): Product
    {

        $product->update($data);

        return  $product;
    }

    public function delete(Product $product): void
    {
        $product->delete();
    }
}
