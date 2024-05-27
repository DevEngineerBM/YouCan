<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CreateProduct extends Command
{
    protected $signature = 'product:create {name} {description} {price} {--image=} {--category_ids=*}';
    protected $description = 'Create a new product';

    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        parent::__construct();
        $this->productRepository = $productRepository;
    }

    public function handle()
    {
        $name = $this->argument('name');
        $description = $this->argument('description');
        $price = $this->argument('price');
        $image = $this->option('image');
        $categoryIds = $this->option('category_ids');

        $data = [
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'image' => $image,
            'category_ids' => $categoryIds
        ];

        try {
            $product = $this->productRepository->create($data);

            if ($image) {

                $filePath = Storage::putFile('public/images', $image);
                $product->update(['image' => $filePath]);
            }

            if (!empty($categoryIds)) {
                $product->categories()->sync($categoryIds);
            }

            $this->info('Product created successfully');
        } catch (\Exception $e) {
            Log::error('Error creating product:', ['error' => $e->getMessage()]);
            $this->error('Failed to create product: ' . $e->getMessage());
        }
    }
}
