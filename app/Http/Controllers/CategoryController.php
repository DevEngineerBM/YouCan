<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use Illuminate\Http\Request;


class CategoryController extends Controller
{

    // injection of categoryRepository dependencies
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /* ============================================== */

    public function index()
    {
        $categories = $this->categoryService->all();
        return response()->json($categories);
    }

    /* ============================================== */

    public function store(Request $request)
    {
        $category = $this->categoryService->create($request->all());
        return response()->json($category, 201);
    }

    /* ============================================== */

    public function show($id)
    {
        $category = $this->categoryService->find($id);
        return response()->json($category);
    }

    /* ============================================== */

    public function update(Request $request, $id)
    {
        $category = $this->categoryService->find($id);
        $category = $this->categoryService->update($category, $request->all());
        return response()->json($category);
    }

    /* ============================================== */

    public function destroy($id)
    {
        $category = $this->categoryService->find($id);
        $this->categoryService->delete($category);
        return response()->json(null, 204);
    }
}
