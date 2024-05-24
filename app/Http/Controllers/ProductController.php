<?php

namespace App\Http\Controllers;

use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use App\Services\ProductValidator;

class ProductController extends Controller
{

    protected $ProductRepo;

    public function __construct(ProductRepository $ProductRepo)
    {
        $this->ProductRepo = $ProductRepo;
    }

    public function index(Request $request)
    {
        $filters = [
            'category_id' => $request->query('category_id')
        ];
        $sortField = $request->query('sort_field');
        $sortOrder = $request->query('sort_order', 'asc');

        $products = $this->ProductRepo->getProducts($filters, $sortField, $sortOrder);
        return response()->json($products);
    }

    public function store(Request $request)
    {

        try {

            $validatedData = ProductValidator::validateProductData($request->all());

            $product = $this->ProductRepo->create($validatedData);
            return response()->json($product, 201);
            // \InvalidAr... handle missing or invalid input data
        } catch (\InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function show($id)
    {
        $product = $this->ProductRepo->find($id);
        return response()->json($product);
    }

    public function update(Request $request, $id)
    {

        $validatedData = ProductValidator::validateProductData($request->all());

        $product = $this->ProductRepo->update($id, $validatedData);
        return response()->json($product);
    }

    public function destroy($id)
    {
        $this->ProductRepo->delete($id);
        return response()->json(null, 204);
    }
}
