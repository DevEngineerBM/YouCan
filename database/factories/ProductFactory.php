
<?php



use App\Models\Product;
use Faker\Generator as Faker;


$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => 'Test Product',
        'description' => 'Test Description',
        'price' => 10,

    ];
});
