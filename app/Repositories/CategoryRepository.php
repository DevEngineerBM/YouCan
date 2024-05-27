<?php

namespace App\Repositories;

use App\Models\Category;
use App\Services\CategoryValidator;

class CategoryRepository
{
    public function all()
    {
        return Category::with('parent', 'children')->get();
    }

    public function find($id)
    {
        return Category::with('parent', 'children')->findOrFail($id);
    }

    public function create(array $data)
    {
        $validatedData = CategoryValidator::validateCategoryData($data);
        return Category::create($validatedData);
    }

    public function update(Category $category, array $data)
    {
        $validatedData = CategoryValidator::validateCategoryData($data);
        $category->update($validatedData);
        return $category;
    }

    public function delete(Category $category)
    {
        $category->delete();
    }
}
