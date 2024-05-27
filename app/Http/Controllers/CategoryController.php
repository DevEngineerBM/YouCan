<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    // injection of categoryRepository dependencies
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /* ============================================== */

    public function index(Request $request)
    {
        $categories = $this->categoryRepository->all();
        return response()->json($categories);
    }

    /* ============================================== */

    public function store(Request $request)
    {
        $category = $this->categoryRepository->create($request->all());
        return response()->json($category, 201);
    }

    /* ============================================== */

    public function show($id)
    {
        $category = $this->categoryRepository->find($id);
        return response()->json($category);
    }

    /* ============================================== */

    public function update(Request $request, $id)
    {
        $category = $this->categoryRepository->find($id);
        $category = $this->categoryRepository->update($category, $request->all());
        return response()->json($category);
    }

    /* ============================================== */

    public function destroy($id)
    {
        $category = $this->categoryRepository->find($id);
        $this->categoryRepository->delete($category);
        return response()->json(null, 204);
    }
}
