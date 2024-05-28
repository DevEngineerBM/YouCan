<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_creation()
    {
        // Create a category to get category id in test file
        $category = factory(Category::class)->create();

        // POST request to create a product
        $response = $this->postJson('/api/products', [
            'name' => 'Test Product',
            'description' => 'Test Description',
            'price' => 10.50,
            'category_ids' => [$category->id],
        ]);

        // make sure the response is (201)
        $response->assertStatus(201);

        // Make sure that the product was created in the database
        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'description' => 'Test Description',
            'price' => 10.50,
        ]);

        // Assert that the product is associated with the correct category
        $product = Product::first();
        $this->assertTrue($product->categories->contains($category));
    }
}
