<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use App\Validators\ProductValidator;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductService
{
    protected $productRepository;
    protected $productValidator;

    public function __construct(ProductRepository $productRepository, ProductValidator $productValidator)
    {
        $this->productRepository = $productRepository;
        $this->productValidator = $productValidator;
    }

    public function all($categoryId = null): Collection
    {
        return $this->productRepository->all($categoryId);
    }

    public function find(int $id): Product
    {
        return $this->productRepository->find($id);
    }

    public function create(array $data): Product
    {
        $validatedData = $this->productValidator->validateProductData($data);

        return $this->productRepository->create($validatedData);
    }

    public function update(Product $product, array $data): Product
    {
        $validatedData = $this->productValidator->validateProductData($data);

        return $this->productRepository->update($product, $validatedData);
    }

    public function delete(Product $product): void
    {

        $this->productRepository->delete($product);
    }
}
